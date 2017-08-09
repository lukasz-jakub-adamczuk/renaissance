<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

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
            $this->_renderer->assign('categoryName', $categoryName);

            // title
            $this->_renderer->assign('title', 'Squarezone - Mistrzostwa - '.$categoryName.' - Klasyfikacja');

            // breadcrumbs
            $item = array(
                'url' => ValueMapper::getUrl('cup').'/'.$categorySlug,
                'text' => $categoryName
            );
            Breadcrumbs::add($item);

            // groups
            $aGroups = [];
            foreach ($aPlayers as $player) {
                $aGroups[$player['group']][$player['id_cup_player']] = $player;
            }

            // print_r($aGroups);

            $this->_renderer->assign('aGroups', $aGroups);
            // $this->_renderer->assign('navigator', $collection->getNavigator());
        }
    }
}
