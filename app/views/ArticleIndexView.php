<?php
require_once AYA_DIR.'/Core/View.php';

class ArticleIndexView extends View {

    public function fill() {
        $collection = Dao::collection('article-category');

        $this->_renderer->assign('aCategories', $collection->getArticleCategories());
    }
}