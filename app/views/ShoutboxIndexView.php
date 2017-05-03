<?php
require_once AYA_DIR.'/Core/View.php';

class ShoutboxIndexView extends View {

    public function fill() {
        // last 30 shouts
        $sql = 'SELECT s.*, u.name user_name, u.slug user_slug 
                FROM shout s
                LEFT JOIN user u ON(u.id_user=s.id_author) 
                GROUP BY s.id_shout 
                ORDER BY creation_date DESC 
                LIMIT 0, 30';
        
        $oShoutsCollection = Dao::collection('shout');
        $oShoutsCollection->query($sql);

        $aShoutsResult = $oShoutsCollection->getRows();
        
        $aShouts = array();
        $sPrevAuthor = '';
        $sClass = '';
        foreach ($aShoutsResult as $sk => &$shout) {
            // avatar for editor
            $sAvatarFile = '/assets/site/redaction/'.$shout['user_slug'].'.png';
            if (file_exists(PUB_DIR . $sAvatarFile)) {
                $shout['avatar'] = $sAvatarFile;
            }

            if ($shout['id_author'] == $sPrevAuthor) {
                $aShouts[$sPrevKey][] = $shout;
            } else {
                $sClass = $sClass == 'left' ? 'right' : 'left';
                $shout['class'] = $sClass;
                $aShouts[$sk][] = $shout;
                $sPrevKey = $sk;
            }
            // $sPrevKey = $sk;
            $sPrevAuthor = $shout['id_author'];
        }

        // print_r($aShouts);

        $this->_renderer->assign('aShouts', $aShouts);

        // $this->_renderer->assign('aNavigator', $oAllAuthorsCollection->getNavigator());
    }
}