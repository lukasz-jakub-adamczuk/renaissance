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
        // old page urls
        $url = isset($_GET['url']) ? $_GET['url'].',articles,pub.html' : null;

        // new page urls
        $articleSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;

        // category redirect
        if ($url === '0,articles,pub.html') {
            $this->redirect(BASE_URL.'/'.ValueMapper::getUrl('story').'/fanfiki');
        }
        if ($url === '1,articles,pub.html') {
            $this->redirect(BASE_URL.'/'.ValueMapper::getUrl('story').'/artykuly');
        }

        $storyEntity = Dao::entity('story');

        if ($url) {
            $article = $storyEntity->getStoryByOldUrl($url);
        } else {
            $article = $storyEntity->getStory($articleSlug, $categorySlug);
        }

        // headers
        if ($url) {
            $articleSlug = $storyEntity->getField('slug');
            $categorySlug = $storyEntity->getField('category_slug');

            $this->redirect(BASE_URL.'/'.ValueMapper::getUrl('story').'/'.$categorySlug.'/'.$articleSlug);
        }

        // title
        $this->_renderer->assign('title', 'Squarezone - Publicystyka - '.$storyEntity->getField('category_name').' - '.$storyEntity->getField('title'));

        $article['id'] = $article['id_story'];
        $article['template'] = 'text';

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