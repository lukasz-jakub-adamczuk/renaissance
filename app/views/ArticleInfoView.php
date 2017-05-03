<?php
require_once AYA_DIR.'/Core/View.php';
require_once AYA_DIR.'/Core/Folder.php';

require_once APP_DIR.'/helpers/Comments.php';

class ArticleInfoView extends View {

    private $_iScreensLimit = 12;

    private $_iEntityId = 0;

    public function fill() {
        // old page urls
        $sUrl = isset($_GET['url']) ? $_GET['url'].',articles.html' : null;

        // new page urls
        $sSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        $sCategory = isset($_GET['category']) ? $_GET['category'] : null;


        if ($sUrl) {
            // article
            $sql = 'SELECT a.*, c.name category_name, c.slug category_slug, c.abbr category_abbr, t.slug template, u.slug author_slug, u.name author_name 
                    FROM article a 
                    LEFT JOIN article_category c ON(c.id_article_category=a.id_article_category) 
                    LEFT JOIN article_template t ON(t.id_article_template=a.id_article_template) 
                    LEFT JOIN user u ON(u.id_user=a.id_author) 
                    WHERE a.old_url="'.$sUrl.'" ';
        } else {
            // article
            $sql = 'SELECT a.*, c.name category_name, c.slug category_slug, c.abbr category_abbr, t.slug template, u.slug author_slug, u.name author_name 
                    FROM article a 
                    LEFT JOIN article_category c ON(c.id_article_category=a.id_article_category) 
                    LEFT JOIN article_template t ON(t.id_article_template=a.id_article_template) 
                    LEFT JOIN user u ON(u.id_user=a.id_author) 
                    WHERE c.slug="'.$sCategory.'" AND a.slug="'.$sSlug.'" ';
        }

        $oEntity = Dao::entity('article');
        $oEntity->query($sql);
        $aArticle = $oEntity->getFields();

        // print_r($aArticle);

        // headers
        if ($sUrl) {
            $sCategorySlug = $oEntity->getField('category_slug');
            $sArticleSlug = $oEntity->getField('slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('article').'/'.$sCategorySlug.'/'.$sArticleSlug, TRUE, 301);
        }

        // gallery workaround
        if ($sSlug == 'galeria') {
            // $aGallery['template'] == 'gallery';

            $sql = 'SELECT c.abbr
                    FROM article_category c
                    WHERE c.slug="'.$sCategory.'"';

                    // echo $sCategory;

            $oEntity = Dao::entity('article');
            $oEntity->query($sql);
            // $aCategory = $oEntity->getFields();

            // screens
            $sPath = ROOT_DIR . '/pub/assets/games/'.$oEntity->getField('abbr').'/imgs';

            $aDirContent = Folder::getContent($sPath, false, array('.DS_Store', 'thumbs.db'));

            if (is_array($aDirContent)) {
                if (isset($aDirContent['files'])) {
                    $aScreens = $aDirContent['files'];

                    $this->_renderer->assign('aScreens', $aScreens);

                    $aGallery['class'] = 'full';
                    $aGallery['size'] = '288x162';
                    // $aGallery['size'] = '';
                    $aGallery['show_link'] = false;
                    $aGallery['category_abbr'] = $oEntity->getField('abbr');

                    $this->_renderer->assign('aGallery', $aGallery);
                }
            }
        }

        // article
        if ($aArticle) {
            // title
            $this->_renderer->assign('sTitle', 'Squarezone - Gry - '.$oEntity->getField('category_name').' - '.$oEntity->getField('title'));

            $mId = $aArticle['id_article'];
            $this->_iEntityId = $aArticle['id_article'];
            
            $sCategorySlug = $oEntity->getField('category_slug');
            $sArticleSlug = $oEntity->getField('slug');

            $aArticle['id'] = $mId;

            if (isset($aArticle['template'])) {
                // ...
            } else {
                $aArticle['template'] = 'text';
                if (strpos($sArticleSlug, 'recenzja') !== false) {
                    $aArticle['template'] = 'review';
                }
                if (strpos($sArticleSlug, 'wstep') !== false) {
                    $aArticle['template'] = 'intro';
                }
            }
            $this->_renderer->assign('aArticle', $aArticle);

            // breadcrumbs
            $aItem = array(
                'url' => ValueMapper::getUrl('article').'/'.$oEntity->getField('category_slug'),
                'text' => $oEntity->getField('category_name')
            );
            Breadcrumbs::add($aItem);

            // self url
            $sSelfUrl = BASE_URL . '/' . $aItem['url'] . '/' . $sArticleSlug;
            $this->_renderer->assign('sSelfUrlEncode', urlencode($sSelfUrl));


            // article types
            if ($sArticleSlug == 'wstep') {
                // screens
                $sPath = ROOT_DIR . '/pub/assets/games/'.$oEntity->getField('category_abbr').'/imgs';

                $aDirContent = Folder::getContent($sPath, false, array('.DS_Store', 'thumbs.db'));

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
                        $aGallery['category_abbr'] = $oEntity->getField('category_abbr');

                        $this->_renderer->assign('aGallery', $aGallery);
                    }
                }

                // articles for this category
                // $sCategorySlug = $_GET['category'];

                $sql = 'SELECT a.*, c.slug category_slug 
                        FROM article a 
                        LEFT JOIN article_category c ON(c.id_article_category=a.id_article_category) 
                        WHERE c.slug="'.$sCategorySlug.'" 
                        ORDER BY a.idx';
                
                $oArticleCollection = Dao::collection('article');
                $oArticleCollection->query($sql);

                $this->_renderer->assign('aArticles', $oArticleCollection->getRows());
                $this->_renderer->assign('aNavigator', $oArticleCollection->getNavigator());
            }
            if (strpos($sArticleSlug, 'recenzja') !== false) {
                // ratings
                $sql = 'SELECT av.*, u.name author_name, u.slug author_slug
                        FROM article_verdict av 
                        LEFT JOIN user u ON(u.id_user=av.id_author) 
                        WHERE av.id_article='.$oEntity->getField('id_article').'';
                
                $oRatingsCollection = Dao::collection('article-verdict');
                $oRatingsCollection->query($sql);

                // article's author rating is a verdict
                $aRatings = array();
                foreach ($oRatingsCollection->getRows() as $rk => $rating) {
                    if ($rating['id_author'] == $aArticle['id_author']) {
                        $aVerdict = $rating;
                    } else {
                        $aRatings[$rk] = $rating;
                    }
                }
                $this->_renderer->assign('aRatings', $aRatings);

                if (isset($aVerdict)) {
                    // verdict's features is a JSON
                    $aFeatures = json_decode(stripslashes($aVerdict['features']), true);
                    $aVerdict['plus'] = $aFeatures['plus'];
                    $aVerdict['minus'] = $aFeatures['minus'];

                    $this->_renderer->assign('aVerdict', $aVerdict);
                }
            }

            // fragments
            $sql = 'SELECT of.*, f.*, ft.name type
                    FROM object_fragment of 
                    LEFT JOIN fragment f ON(f.id_fragment=of.id_fragment) 
                    LEFT JOIN fragment_type ft ON(ft.id_fragment_type=f.id_fragment_type) 
                    WHERE of.object="article" AND of.id_object="'.$oEntity->getField('id_article').'" ';

            $oFragmentsCollection = Dao::collection('object-fragment');
            $oFragmentsCollection->query($sql);

            $aFragments = array();
            foreach ($oFragmentsCollection->getRows() as $fragment) {
                $aFragments[$fragment['type']][] = $fragment;
            }

            // print_r($aFragments);
            $this->_renderer->assign('aFragments', $aFragments);

            if (isset($aFragments['logo-image'])) {
                $this->_renderer->assign('aLogoImage', $aFragments['logo-image']);
            }

            if (isset($aFragments['cover-image'])) {
                $this->_renderer->assign('aCoverImage', $aFragments['cover-image']);
            }

            if (isset($aFragments['game-info'])) {
                $sYamlParserPath = __DIR__ . '/../../../XhtmlTable/Aya/Yaml/AyaYamlLoader.php';

                require_once $sYamlParserPath;

                $aGameInfo = AyaYamlLoader::parseContent($aFragments['game-info'][0]['fragment']);
                // print_r($aGameInfo);

                $this->_renderer->assign('aGameInfo', $aGameInfo);
            }

            // music info
            if (isset($aFragments['music-info'])) {
                // info
                // FIX somehow
                $sYamlParserPath = __DIR__ . '/../../../XhtmlTable/Aya/Yaml/AyaYamlLoader.php';
                // echo $sYamlParserPath;
                require_once $sYamlParserPath;

                    $aMusicInfo = AyaYamlLoader::parseContent($aFragments['music-info'][0]['fragment']);

                    $this->_renderer->assign('aMusicInfo', $aMusicInfo);
                // }
                // print_r($aMusicInfo);
            }

            // comments form
            $this->_renderer->assign('aCommentsForm', Comments::getFormParams('article', $oEntity));
            $this->_renderer->assign('sCommentPrimaryKey', 'id_article_comment');

            // comments
            $oCommentsCollection = Dao::collection('article-comment');

            $this->_renderer->assign('aComments', $oCommentsCollection->getCommentsById($oEntity->getField('id_article')));
            $this->_renderer->assign('aNavigator', $oCommentsCollection->getNavigator());
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);
        }
    }

    public function afterFill() {
        // update article
        // does we really need this value
        $sql = 'UPDATE article SET views = views + 1 WHERE id_article="'.$this->_iEntityId.'"';

        // $this->_aParams = unserialize(DB_SOURCE);

        $this->_db = Db::getInstance();
        $this->_db->execute($sql);

    }
}