<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

// grupy

class CupShowByCategoryView extends View {

    public function fill() {
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));

        $sql = 'SELECT c.*
                FROM cup c
                WHERE c.slug="'.$categorySlug.'"';

        $collection = Dao::collection('cup');
        $collection->query($sql);

        $aRows = $collection->getRows();

        echo $categorySlug;
        print_r($aRows);
        
        if ($aRows) {
            // cup
            $aObject = current($aRows);
            $this->_renderer->assign('aObject', current($aRows));


            $sql = 'SELECT cp.*
                    FROM cup_player cp
                    LEFT JOIN cup c ON (c.id_cup=cp.id_cup)
                    WHERE c.slug="'.$categorySlug.'"';

            $collection = Dao::collection('cup-player');
            $collection->query($sql);

            // category name
            $this->_renderer->assign('categoryName', $categoryName);

            // title
            $this->_renderer->assign('title', 'Squarezone - Mistrzostwa - '.$categoryName);

            $this->_renderer->assign('aGroups', $collection->getRows());
            $this->_renderer->assign('navigator', $collection->getNavigator());
        } else {
            // log 404
        }
    }
}