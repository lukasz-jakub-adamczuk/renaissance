<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\Folder;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

use Renaissance\Helper\Comments;

use Symfony\Component\Yaml\Yaml;

class ArticleInfoView extends View {

    private $_iScreensLimit = 12;

    public function fill() {
        // old page urls
        $url = isset($_GET['url']) ? $_GET['url'].',articles.html' : null;

        // new page urls
        $articleSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;

        $articleEntity = Dao::entity('article');

        if ($url) {
            $article = $articleEntity->getArticleByOldUrl($url);
        } else {
            $article = $articleEntity->getArticle($articleSlug, $categorySlug);
        }

        // headers
        if ($url) {
            $articleSlug = $articleEntity->getField('slug');
            $categorySlug = $articleEntity->getField('category_slug');
            
            Logger::logStandardRequest('redirects');

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('article').'/'.$categorySlug.'/'.$articleSlug, TRUE, 301);
        }

        // title
        $this->_renderer->assign('title', 'Squarezone - Gry - '.$articleEntity->getField('category_name').' - '.$articleEntity->getField('title'));
        
        $article['id'] = $article['id_article'];

        if (!isset($article['template'])) {
            $article['template'] = 'text';
            if (strpos($articleSlug, 'recenzja') !== false) {
                $article['template'] = 'review';
            }
            if (strpos($articleSlug, 'wstep') !== false) {
                $article['template'] = 'intro';
            }
        }
        $this->_renderer->assign('article', $article);

        // breadcrumbs
        $item = [
            'url' => ValueMapper::getUrl('article').'/'.$categorySlug,
            'text' => $articleEntity->getField('category_name')
        ];
        Breadcrumbs::add($item);

        // self url
        $selfUrl = BASE_URL . '/' . $item['url'] . '/' . $articleSlug;
        $this->_renderer->assign('encodedSelfUrl', urlencode($selfUrl));

        // fragments
        $fragmentsCollection = Dao::collection('object-fragment');
        $fragmentsCollection->getFragments($article['id_article'], 'article');

        $fragments = [];
        foreach ($fragmentsCollection->getRows() as $fragment) {
            $fragments[$fragment['type']][] = $fragment;
        }

        // $this->_renderer->assign('fragments', $fragments);

        if (isset($fragments['logo-image'])) {
            $this->_renderer->assign('gameLogo', $fragments['logo-image']);
        }
        if (isset($fragments['cover-image'])) {
            $this->_renderer->assign('mainImage', $fragments['cover-image']);
        }
        if (isset($fragments['game-info'])) {
            $gameInfo = Yaml::parse($fragments['game-info'][0]['fragment']);
            $this->_renderer->assign('gameInfo', $gameInfo);
        }
        if (isset($fragments['music-info'])) {
            $musicInfo = Yaml::parse($fragments['music-info'][0]['fragment']);
            $this->_renderer->assign('musicInfo', $musicInfo);
        }

        // intro article
        if ($articleSlug == 'wstep') {
            $sPath = WEB_DIR . '/assets/games/'.$articleEntity->getField('category_abbr').'/imgs';

            $aDirContent = Folder::getContent($sPath, false, ['.DS_Store', 'thumbs.db']);

            if (is_array($aDirContent)) {
                if (isset($aDirContent['files'])) {
                    if (count($aDirContent['files']) >= $this->_iScreensLimit) {
                        $aScreens = array_slice($aDirContent['files'], 0, $this->_iScreensLimit);
                    } else {
                        $aScreens = $aDirContent['files'];
                    }

                    $this->_renderer->assign('aScreens', $aScreens);

                    // $aGallery['class'] = 'full';
                    $aGallery['size'] = '288x162';
                    $aGallery['show_link'] = true;
                    $aGallery['category_abbr'] = $articleEntity->getField('category_abbr');

                    $this->_renderer->assign('aGallery', $aGallery);
                }
            }

            $articleCollection = Dao::collection('article');

            $this->_renderer->assign('articles', $articleCollection->getArticlesByCategory($categorySlug));
            $this->_renderer->assign('navigator', $articleCollection->getNavigator());
        }

        // review article
        if (strpos($articleSlug, 'recenzja') !== false) {
            // ratings
            $ratingsCollection = Dao::collection('article-verdict');
            $ratingsCollection->getVerdicts($articleEntity->getField('id_article'));

            // article's author rating is a verdict
            $ratings = [];
            foreach ($ratingsCollection->getRows() as $rk => $rating) {
                if ($rating['id_author'] == $article['id_author']) {
                    $verdict = $rating;
                } else {
                    $ratings[$rk] = $rating;
                }
            }
            $this->_renderer->assign('ratings', $ratings);

            if (isset($verdict)) {
                // verdict's features is a JSON
                $features = json_decode(stripslashes($verdict['features']), true);
                $verdict['plus'] = $features['plus'];
                $verdict['minus'] = $features['minus'];

                $this->_renderer->assign('verdict', $verdict);
            }
        }
        // echo 'aaaa';
        // print_r(\Aya\Core\User::atLeast('moderator'));

        // update views counter
        $articleEntity->increaseField('views');

        // comments form
        $this->_renderer->assign('commentsForm', Comments::getFormParams('article', $articleEntity));
        $this->_renderer->assign('commentPrimaryKey', 'id_article_comment');

        // comments
        $commentCollection = Dao::collection('comment');

        $this->_renderer->assign('comments', $commentCollection->getCommentsById('article', $articleEntity->getField('id_article')));
        $this->_renderer->assign('navigator', $commentCollection->getNavigator());
    }
}