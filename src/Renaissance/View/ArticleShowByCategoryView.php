<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class ArticleShowByCategoryView extends View {

    public function fill() {
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        
        $collection = Dao::collection('article');
        
        $articles = $collection->getArticlesForCategory($category);

        $firstItem = current($articles);

        $this->_renderer->assign('articles', $articles);
        $this->_renderer->assign('category', $firstItem['category_name']);

        // title
        $this->_renderer->assign('title', 'Squarezone - Gry - '.$firstItem['category_name']);
    }
}