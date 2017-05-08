<?php
require_once AYA_DIR.'/Core/View.php';

// klasyfikacja

class CupShowGroupsView extends View {

    public function fill() {
        // old page urls
        $sId = isset($_GET['id']) ? $_GET['id'] : null;

        // new page urls
        $sNameSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        $sCategorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $sCategoryName = ucwords(str_replace('-', ' ', $sCategorySlug));

        if ($sId) {
            $oEntity = Dao::entity('cup', $sId);
            
            $aObject = $oEntity->getFields();

            $sCategorySlug = $oEntity->getField('slug');
            $sCategoryName = $oEntity->getField('name');
        }
        
        $cupSlug = $sCategorySlug;

        // headers
        if ($sId) {
            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('cup').'/'.$cupSlug.'/klasyfikacja', TRUE, 301);
        }

        // players
        $oCollection = Dao::collection('cup-player');

        $aPlayers = $oCollection->getPlayersForRanking($cupSlug);

        if ($aPlayers) {
            // category name
            $this->_renderer->assign('sCategoryName', $sCategoryName);

            // title
            $this->_renderer->assign('sTitle', 'Squarezone - Mistrzostwa - '.$sCategoryName.' - Klasyfikacja');

            // breadcrumbs
            $aItem = array(
                'url' => ValueMapper::getUrl('cup').'/'.$sCategorySlug,
                'text' => $sCategoryName
            );
            Breadcrumbs::add($aItem);

            // groups
            $aGroups = array();
            foreach ($aPlayers as $player) {
                $aGroups[$player['group']][$player['id_cup_player']] = $player;
            }

            // print_r($aGroups);

            $this->_renderer->assign('aGroups', $aGroups);
            // $this->_renderer->assign('aNavigator', $oCollection->getNavigator());
        }
    }
}
