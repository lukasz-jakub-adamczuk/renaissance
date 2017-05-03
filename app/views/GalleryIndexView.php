<?php
require_once AYA_DIR.'/Management/IndexView.php';

class GalleryIndexView extends IndexView {

    public function fill() {
        $sql = 'SELECT c.*, COUNT(g.id_gallery) items
                FROM gallery g 
                LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category)
                GROUP BY g.id_gallery_category';

        $oCollection = Dao::collection('gallery-category');
        $oCollection->query($sql);

        $this->_renderer->assign('aCategories', $oCollection->getRows());
        $this->_renderer->assign('aNavigator', $oCollection->getNavigator());
    }
}