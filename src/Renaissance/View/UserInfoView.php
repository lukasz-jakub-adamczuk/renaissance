<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\Db;
use Aya\Core\View;

use Renaissance\Helper\AvatarManager;
use Renaissance\Helper\Comments;

class UserInfoView extends View {

    public function fill() {
        // old page urls
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        // new page urls
        $userSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

        $userEntity = Dao::entity('user');

        if ($id) {
            $user = $userEntity->getUserById($id);
        } else {
            $user = $userEntity->getUser($userSlug);
        }

        // headers
        if ($id) {
            $userSlug = $userEntity->getField('slug');

            Logger::logStandardRequest('redirects');

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('user').'/'.$userSlug, TRUE, 301);
        }

        $id = $user['id_user'];

        $user['avatar'] = AvatarManager::getAvatar($userSlug);

        // fetch other stats
        // TODO move to entities;
        $db = Db::getInstance();

        $newsCollection = Dao::collection('news');
        
        // $aStats = [];
        $counters = [];
        $counters['news']       = Dao::collection('news')->howManyNewsWroteUser($id);
        $counters['article']    = Dao::collection('article')->howManyArticlesWroteUser($id);
        $counters['story']      = Dao::collection('story')->howManyStoriesWroteUser($id);
        $counters['shout']      = Dao::collection('shout')->howManyShoutsWroteUser($id);

        // comments
        $comments = [];
        $comments['news']       = Dao::collection('news-comment')->howManyCommentsWroteUser($id);
        $comments['article']    = Dao::collection('article-comment')->howManyCommentsWroteUser($id);
        $comments['story']      = Dao::collection('story-comment')->howManyCommentsWroteUser($id);
        $comments['gallery']    = Dao::collection('gallery-comment')->howManyCommentsWroteUser($id);
        $comments['user']       = Dao::collection('user-comment')->howManyCommentsWroteUser($id);
        
        $user['counters'] = $counters;
        $user['comments'] = $comments;

        $this->_renderer->assign('siteUser', $user);

        // comments form
        $this->_renderer->assign('commentsForm', Comments::getFormParams('user', $userEntity));

        // comments
        
        
        $oCommentsCollection = Dao::collection('user-comment');

        $this->_renderer->assign('comments', $oCommentsCollection->getCommentsById($id));
        $this->_renderer->assign('navigator', $oCommentsCollection->getNavigator());
    }
}
