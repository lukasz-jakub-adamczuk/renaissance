<?php
require_once AYA_DIR.'/Core/View.php';

require_once APP_DIR.'/helpers/Comments.php';

class UserInfoView extends View {

    public function fill() {
        // old page urls
        $sId = isset($_GET['id']) ? $_GET['id'] : null;

        // new page urls
        $sSlug = isset($_GET['slug']) ? $_GET['slug'] : null;


        if ($sId) {
            // article
            $sql = 'SELECT u.*, u.slug
                    FROM user u 
                    WHERE u.id_user="'.$sId.'" ';
        } else {
            // article
            $sql = 'SELECT u.*, u.slug
                    FROM user u 
                    WHERE u.slug="'.$sSlug.'" ';
        }

        $oEntity = Dao::entity('user');
        $oEntity->query($sql);
        $aUser = $oEntity->getFields();

        // headers
        if ($sId) {
            $sUserSlug = $oEntity->getField('slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('user').'/'.$sUserSlug, TRUE, 301);
        }

        if ($aUser) {
            $iId = $aUser['id_user'];

            // avatar for editor
            $sAvatarFile = '/assets/site/redaction/'.$sSlug.'.png';
            if (file_exists(PUB_DIR . $sAvatarFile)) {
                $aUser['avatar'] = $sAvatarFile;
            }
            

            // fetch other stats

            $db = Db::getInstance();

            // $aStats = array();
            $aStatsCounters = array();
            $aStatsCounters['news'] = $db->getOne('SELECT COUNT(id_news) FROM news WHERE id_author="'.$iId.'"');
            $aStatsCounters['article'] = $db->getOne('SELECT COUNT(id_article) FROM article WHERE id_author="'.$iId.'"');
            $aStatsCounters['story'] = $db->getOne('SELECT COUNT(id_story) FROM story WHERE id_author="'.$iId.'"');
            // $aStatsCounters['gallery'] = $db->getOne('SELECT COUNT(id_gallery) FROM gallery WHERE id_author="'.$iId.'"');
            // $aStatsCounters['user'] = $db->getOne('SELECT COUNT(id_user) FROM user WHERE id_author="'.$iId.'"');
            $aStatsCounters['shout'] = $db->getOne('SELECT COUNT(id_shout) FROM shout WHERE id_author="'.$iId.'"');

            // comments
            $aStatsComments = array();
            $aStatsComments['news']         = $db->getOne('SELECT COUNT(id_news_comment) FROM news_comment WHERE id_author="'.$iId.'"');
            $aStatsComments['article']         = $db->getOne('SELECT COUNT(id_article_comment) FROM article_comment WHERE id_author="'.$iId.'"');
            $aStatsComments['story']         = $db->getOne('SELECT COUNT(id_story_comment) FROM story_comment WHERE id_author="'.$iId.'"');
            $aStatsComments['gallery']         = $db->getOne('SELECT COUNT(id_gallery_comment) FROM gallery_comment WHERE id_author="'.$iId.'"');
            $aStatsComments['user']         = $db->getOne('SELECT COUNT(id_user_comment) FROM user_comment WHERE id_author="'.$iId.'"');
            // $aUser['stats']['pubs'] = $db->getOne('SELECT COUNT(id_story) FROM story WHERE id_author="'.$iId.'"');

            $aUser['counters'] = $aStatsCounters;
            $aUser['comments'] = $aStatsComments;

            $this->_renderer->assign('aUser', $aUser);

            // comments form
            $this->_renderer->assign('aCommentsForm', Comments::getFormParams('user', $oEntity));

            // comments
            $sql = 'SELECT uc.*, u.name author_name 
                    FROM user_comment uc 
                    LEFT JOIN user u ON(u.id_user=uc.id_author) 
                    WHERE uc.id_user='.$oEntity->getField('id_user').' AND uc.visible=1';
            
            $oCommentsCollection = Dao::collection('user-comment');
            $oCommentsCollection->query($sql);

            $this->_renderer->assign('aComments', $oCommentsCollection->getRows());
            // $this->_renderer->assign('aNavigator', $oCommentsCollection->getNavigator());
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);
        }
    }
}