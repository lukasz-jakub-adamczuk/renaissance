<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class GalleryIndexView extends View {

    public function fill() {
        $collection = Dao::collection('gallery-category');

        $this->_renderer->assign('categories', $collection->getCategoriesWithCounters());
        // $this->_renderer->assign('navigator', $collection->getNavigator());
    }
}