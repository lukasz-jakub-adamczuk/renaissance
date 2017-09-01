<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\AvatarManager;

class ShoutboxIndexView extends View {

    public function fill() {
        // last 30 shouts
        $shoutsCollection = Dao::collection('shout');
        $recentShouts = $shoutsCollection->getRecentShouts();
        
        $aShouts = [];
        $sPrevAuthor = '';
        $sClass = '';
        foreach ($recentShouts as $sk => &$shout) {
            
            $shout['avatar'] = AvatarManager::getAvatar($shout['user_slug']);
            // avatar from db
            if (!empty($shout['user_avatar'])) {
                $sAvatarFile = $shout['user_avatar'];
                if (file_exists(WEB_DIR . $sAvatarFile)) {
                    $shout['avatar'] = $sAvatarFile;
                }
            }

            if ($shout['id_author'] == $sPrevAuthor) {
                $aShouts[$sPrevKey][] = $shout;
            } else {
                $sClass = $sClass == 'left' ? 'right' : 'left';
                $shout['class'] = $sClass;
                $aShouts[$sk][] = $shout;
                $sPrevKey = $sk;
            }
            $sPrevAuthor = $shout['id_author'];
        }

        $this->_renderer->assign('aShouts', $aShouts);

        // $this->_renderer->assign('navigator', $oAllAuthorsCollection->getNavigator());
    }
}