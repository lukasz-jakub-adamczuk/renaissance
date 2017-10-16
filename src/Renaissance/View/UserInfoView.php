<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\Db;
use Aya\Core\View;
use Aya\Helper\AvatarManager;

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

        $newsCollection = Dao::collection('news');
        
        // $aStats = [];
        $counters = [];
        $counters['news']       = Dao::collection('news')->howManyNewsWroteUser($id);
        $counters['article']    = Dao::collection('article')->howManyArticlesWroteUser($id);
        $counters['story']      = Dao::collection('story')->howManyArticlesWroteUser($id);
        $counters['shout']      = Dao::collection('shout')->howManyShoutsWroteUser($id);

        // comments
        $comments = [];
        $comments['news']       = Dao::collection('comment')->howManyCommentsWroteUser('news', $id);
        $comments['article']    = Dao::collection('comment')->howManyCommentsWroteUser('article', $id);
        $comments['story']      = Dao::collection('comment')->howManyCommentsWroteUser('story', $id);
        $comments['gallery']    = Dao::collection('comment')->howManyCommentsWroteUser('gallery', $id);
        $comments['user']       = Dao::collection('comment')->howManyCommentsWroteUser('user', $id);
        
        $user['counters'] = $counters;
        $user['comments'] = $comments;

        $this->_renderer->assign('siteUser', $user);

        // comments form
        $this->_renderer->assign('commentsForm', Comments::getFormParams('user', $userEntity));

        // comments
        $commentCollection = Dao::collection('comment');

        $this->_renderer->assign('comments', $commentCollection->getCommentsById('user', $id));
        $this->_renderer->assign('navigator', $commentCollection->getNavigator());
    }
}
