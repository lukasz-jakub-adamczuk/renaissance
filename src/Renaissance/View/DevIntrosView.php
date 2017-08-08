<?php
require_once AYA_DIR.'/Core/View.php';

class DevIntrosView extends View {

    public function fill() {
        // $category = $_GET['category'];

        $sql = 'SELECT a.*, c.slug category_slug 
                FROM article a 
                LEFT JOIN category c ON(c.id_category=a.id_category) 
                WHERE a.slug LIKE "wstep" 
                ORDER BY a.idx';
        
        $oArticleCollection = Dao::collection('article');
        $oArticleCollection->query($sql);

        // print_r($oArticleCollection->getRows());

        $this->_renderer->assign('articles', $oArticleCollection->getRows());
        $this->_renderer->assign('navigator', $oArticleCollection->getNavigator());
    }
}