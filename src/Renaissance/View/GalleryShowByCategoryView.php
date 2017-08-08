<?php
require_once AYA_DIR.'/Management/IndexView.php';

class GalleryShowByCategoryView extends IndexView {

    public function fill() {
        $category = $_GET['category'];

        $sql = 'SELECT g.*, c.name category, c.slug category_slug
                FROM gallery g 
                LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category) 
                WHERE c.slug="'.$category.'" 
                ORDER BY g.name';

        $collection = Dao::collection('gallery');
        $collection->query($sql);

        $articles = $collection->getRows();

        $aCurrent = current($articles);

        $this->_renderer->assign('articles', $articles);

        $this->_renderer->assign('sCategory', $aCurrent['category']);
    }
}