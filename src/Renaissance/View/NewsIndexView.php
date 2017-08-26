<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class NewsIndexView extends View {

    public function fill() {
        $newsCollection = Dao::collection('news');
        
        $this->_renderer->assign('entries', $newsCollection->getNews());
        $this->_renderer->assign('navigator', $newsCollection->getNavigator());
    }
}