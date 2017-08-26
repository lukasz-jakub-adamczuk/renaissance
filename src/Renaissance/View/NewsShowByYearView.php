<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class NewsShowByYearView extends View {

    public function fill() {
        $year = $_GET['year'];

        $newsCollection = Dao::collection('news');
        
        $this->_renderer->assign('entries', $newsCollection->getNewsByYear($year));
        $this->_renderer->assign('navigator', $newsCollection->getNavigator());
    }
}