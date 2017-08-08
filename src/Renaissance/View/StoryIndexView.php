<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class StoryIndexView extends View {

    public function fill() {
        $collection = Dao::collection('story-category');

        $this->_renderer->assign('categories', $collection->getCategoriesWithCounters());
    }
}