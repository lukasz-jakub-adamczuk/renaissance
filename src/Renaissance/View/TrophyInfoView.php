<?php
require_once AYA_DIR.'/Core/View.php';

class TrophyInfoView extends View {

    public function fill() {
        $slug = $_GET['slug'];

        $sql = 'SELECT t.*
                FROM trophy t 
                WHERE t.slug="'.$slug.'" ';

        $oEntity = Dao::entity('trophy');
        $oEntity->query($sql);

        $this->_renderer->assign('aTrophy', $oEntity->getFields());

        $aUser = $oEntity->getFields();

        // trophies
        // echo 'aaa';
        // echo $oUserEntity->getField('id_user');
        // echo $aUser['id_user'];

        // comments
        // $sql = 'SELECT uc.*, u.name author_name 
        //         FROM user_comment uc 
        //         LEFT JOIN user u ON(u.id_user=uc.id_author) 
        //         WHERE uc.id_user='.$oUserEntity->getField('id_user').'';
        
        // $oCommentsCollection = Dao::collection('user-comment');
        // $oCommentsCollection->query($sql);

        // $this->_renderer->assign('aComments', $oCommentsCollection->getRows());
        // $this->_renderer->assign('navigator', $oCommentsCollection->getNavigator());
    }
}