<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class ArticleShowByCategoryView extends View {

    public function fill() {
        $category = isset($_GET['category']) ? $_GET['category'] : null;

        if ($category) {
            $sql = 'SELECT a.*, c.slug category_slug, c.name category_name
                    FROM article a 
                    LEFT JOIN article_category c ON(c.id_article_category=a.id_article_category) 
                    WHERE c.slug="'.$category.'" 
                    ORDER BY a.idx';
            
            $oArticleCollection = Dao::collection('article');
            $oArticleCollection->query($sql);

            $articles = $oArticleCollection->getRows();

            $this->_renderer->assign('articles', $articles);
            $this->_renderer->assign('navigator', $oArticleCollection->getNavigator());

            // category name
            $aFirstItem = current($articles);
            $this->_renderer->assign('category', $aFirstItem['category_name']);

            // title
            $this->_renderer->assign('title', 'Squarezone - Gry - '.$aFirstItem['category_name']);
        }
    }
}