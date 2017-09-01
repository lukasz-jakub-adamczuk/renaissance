<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\Folder;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

use Renaissance\Helper\Comments;

class StoryInfoView extends View {

    public function fill() {
        $redirected = false;

        // old page urls
        $url = isset($_GET['url']) ? $_GET['url'].',articles,pub.html' : null;

        // new page urls
        $articleSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;

        // category redirect
        if ($url === '0,articles,pub.html') {
            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/fanfiki', TRUE, 301);
            $redirected = true;
        }
        if ($url === '1,articles,pub.html') {
            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/artykuly', TRUE, 301);
            $redirected = true;
        }

        $storyEntity = Dao::entity('story');

        if ($url) {
            $article = $storyEntity->getStoryByOldUrl($url);
        } else {
            $article = $storyEntity->getStory($articleSlug, $categorySlug);
        }

        // headers
        if ($url && !$redirected) {
            $articleSlug = $storyEntity->getField('slug');
            $categorySlug = $storyEntity->getField('category_slug');
            
            Logger::logStandardRequest('redirects');

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/'.$categorySlug.'/'.$articleSlug, TRUE, 301);
        }

        // title
        $this->_renderer->assign('title', 'Squarezone - Publicystyka - '.$storyEntity->getField('category_name').' - '.$storyEntity->getField('title'));

        $article['id'] = $article['id_story'];
        $article['template'] = null;

        $this->_renderer->assign('article', $article);

        // breadcrumbs
        $item = [
            'url' => ValueMapper::getUrl('story').'/'.$categorySlug,
            'text' => $storyEntity->getField('category_name')
        ];
        Breadcrumbs::add($item);

        // self url
        $selfUrl = BASE_URL . '/' . $item['url'] . '/' . $articleSlug;
        $this->_renderer->assign('encodedSelfUrl', urlencode($selfUrl));

        // fragments
        $fragmentsCollection = Dao::collection('object-fragment');
        $fragmentsCollection->getFragments($article['id_story'], 'story');

        $fragments = [];
        foreach ($fragmentsCollection->getRows() as $fragment) {
            $fragments[$fragment['type']][] = $fragment;
        }
        
        // $this->_renderer->assign('fragments', $fragments);

        if (isset($fragments['cover-image'])) {
            $this->_renderer->assign('mainImage', $fragments['cover-image']);
        }

        // update views counter
        $storyEntity->increaseField('views');

        // comments form
        $this->_renderer->assign('commentsForm', Comments::getFormParams('story', $storyEntity));
        $this->_renderer->assign('commentPrimaryKey', 'id_story_comment');

        // comments
        $commentCollection = Dao::collection('comment');

        $this->_renderer->assign('comments', $commentCollection->getCommentsById('story', $storyEntity->getField('id_story')));
        $this->_renderer->assign('navigator', $commentCollection->getNavigator());
    }
}