<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class ArticleIndexView extends View {

    public function fill() {
        $collection = Dao::collection('article-category');

        $this->_renderer->assign('categories', $collection->getCategoriesWithCounters());
    }
}