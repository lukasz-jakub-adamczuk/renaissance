<?php
require_once AYA_DIR.'/Management/IndexView.php';

class GalleryShowByCategoryView extends IndexView {

    public function fill() {
        $sCategory = $_GET['category'];

        $sql = 'SELECT g.*, c.name category, c.slug category_slug
                FROM gallery g 
                LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category) 
                WHERE c.slug="'.$sCategory.'" 
                ORDER BY g.name';

        $oCollection = Dao::collection('gallery');
        $oCollection->query($sql);

        $aArticles = $oCollection->getRows();

        $aCurrent = current($aArticles);

        $this->_renderer->assign('aArticles', $aArticles);

        $this->_renderer->assign('sCategory', $aCurrent['category']);
    }
}