<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class StoryShowByCategoryView extends View {

    public function fill() {
        $category = $_GET['category'];

        

        $collection = Dao::collection('story');
        // $collection->query($sql);

        $articles = $collection->getStoriesForCategory($category);

        $aCurrent = current($articles);

        $this->_renderer->assign('articles', $articles);

        $this->_renderer->assign('category', $aCurrent['category']);
    }
}