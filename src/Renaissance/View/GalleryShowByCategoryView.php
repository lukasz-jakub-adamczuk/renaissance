<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class GalleryShowByCategoryView extends View {

    public function fill() {
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        
        $collection = Dao::collection('gallery');
        
        $articles = $collection->getGalleriesForCategory($category);

        $firstItem = current($articles);

        $this->_renderer->assign('articles', $articles);
        $this->_renderer->assign('category', $firstItem['category_name']);

        // title
        $this->_renderer->assign('title', 'Squarezone - Galerie - '.$firstItem['category_name']);
    }
}