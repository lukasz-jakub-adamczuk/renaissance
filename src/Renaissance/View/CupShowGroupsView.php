<?php
require_once AYA_DIR.'/Core/View.php';

// klasyfikacja

class CupShowGroupsView extends View {

    public function fill() {
        // old page urls
        $sId = isset($_GET['id']) ? $_GET['id'] : null;

        // new page urls
        $nameSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));

        if ($sId) {
            $oEntity = Dao::entity('cup', $sId);
            
            $aObject = $oEntity->getFields();

            $categorySlug = $oEntity->getField('slug');
            $categoryName = $oEntity->getField('name');
        }
        
        $cupSlug = $categorySlug;

        // headers
        if ($sId) {
            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('cup').'/'.$cupSlug.'/klasyfikacja', TRUE, 301);
        }

        // players
        $collection = Dao::collection('cup-player');

        $aPlayers = $collection->getPlayersForRanking($cupSlug);

        if ($aPlayers) {
            // category name
            $this->_renderer->assign('sCategoryName', $categoryName);

            // title
            $this->_renderer->assign('title', 'Squarezone - Mistrzostwa - '.$categoryName.' - Klasyfikacja');

            // breadcrumbs
            $aItem = array(
                'url' => ValueMapper::getUrl('cup').'/'.$categorySlug,
                'text' => $categoryName
            );
            Breadcrumbs::add($aItem);

            // groups
            $aGroups = array();
            foreach ($aPlayers as $player) {
                $aGroups[$player['group']][$player['id_cup_player']] = $player;
            }

            // print_r($aGroups);

            $this->_renderer->assign('aGroups', $aGroups);
            // $this->_renderer->assign('navigator', $collection->getNavigator());
        }
    }
}
