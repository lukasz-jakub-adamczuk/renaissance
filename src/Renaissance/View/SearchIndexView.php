<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class SearchIndexView extends View {

    public function fill() {
        $search = isset($_GET['search']) ? $_GET['search'] : null;
        
        if ($search) {
            $newsCollection = Dao::collection('news');
            
            $this->_renderer->assign('total', count($newsCollection->getNewsForSearch($search)));

            $this->_renderer->assign('entries', $newsCollection->getNewsForSearch($search));
            $this->_renderer->assign('navigator', $newsCollection->getNavigator());
        }
    }
}
