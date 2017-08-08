<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\Folder;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

use Renaissance\Helper\Comments;

class StoryInfoView extends View {

    private $_iEntityId = 0;

    public function fill() {
        $redirected = false;

        // old page urls
        $url = isset($_GET['url']) ? $_GET['url'].',articles,pub.html' : null;

        // category redirect
        if ($url == '0,articles,pub.html') {
            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/fanfiki', TRUE, 301);
            $redirected = true;
        }
        if ($url == '1,articles,pub.html') {
            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/artykuly', TRUE, 301);
            $redirected = true;
        }

        $storyEntity = Dao::entity('story');

        if ($url) {
            $aArticle = $storyEntity->getStoryByOldUrl($url);
        } else {
            $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
            $aArticle = $storyEntity->getStory($slug);
        }

        // headers
        if ($url && !$redirected) {
            $categorySlug = $storyEntity->getField('category_slug');
            $slug = $storyEntity->getField('slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/'.$categorySlug.'/'.$slug, TRUE, 301);
        }

        // title
        $this->_renderer->assign('title', 'Squarezone - Publicystyka - '.$storyEntity->getField('category_name').' - '.$storyEntity->getField('title'));

        $mId = $aArticle['id_story'];
        $this->_iEntityId = $aArticle['id_story'];

        $categorySlug = $storyEntity->getField('category_slug');
        $sArticleSlug = $storyEntity->getField('slug');

        $aArticle['id'] = $mId;
        $aArticle['template'] = 'story text';

        $this->_renderer->assign('aArticle', $aArticle);

        // breadcrumbs
        $aItem = array(
            'url' => ValueMapper::getUrl('story').'/'.$storyEntity->getField('category_slug'),
            'text' => $storyEntity->getField('category_name')
        );
        Breadcrumbs::add($aItem);

        // self url
        $sSelfUrl = BASE_URL . '/' . $aItem['url'] . '/' . $sArticleSlug;
        $this->_renderer->assign('sSelfUrlEncode', urlencode($sSelfUrl));

        // fragments
        $sql = 'SELECT of.*, f.*, ft.name type
                FROM object_fragment of 
                LEFT JOIN fragment f ON(f.id_fragment=of.id_fragment) 
                LEFT JOIN fragment_type ft ON(ft.id_fragment_type=f.id_fragment_type) 
                WHERE of.object="story" AND of.id_object="'.$aArticle['id_story'].'" ';

        $oFragmentsCollection = Dao::collection('object-fragment');
        $oFragmentsCollection->query($sql);

        $aFragments = array();
        foreach ($oFragmentsCollection->getRows() as $fragment) {
            $aFragments[$fragment['type']][] = $fragment;
        }
        
        // print_r($aFragments);
        $this->_renderer->assign('aFragments', $aFragments);

        if (isset($aFragments['cover-image'])) {
            $this->_renderer->assign('aCoverImage', $aFragments['cover-image']);
        }

        // comments form
        $this->_renderer->assign('aCommentsForm', Comments::getFormParams('story', $storyEntity));
        $this->_renderer->assign('sCommentPrimaryKey', 'id_story_comment');

        // comments
        $oCommentsCollection = Dao::collection('story-comment');

        $this->_renderer->assign('aComments', $oCommentsCollection->getCommentsById($storyEntity->getField('id_story')));
        $this->_renderer->assign('navigator', $oCommentsCollection->getNavigator());
    }

    public function afterFill() {
        // update article
        // does we really need this value
        /*$sql = 'UPDATE story SET views = views + 1 WHERE id_story="'.$this->_iEntityId.'"';

        // $this->_aParams = unserialize(DB_SOURCE);

        $this->_db = Db::getInstance();
        $this->_db->execute($sql);*/
    }
}