<?php
require_once AYA_DIR.'/Management/IndexView.php';

class GalleryIndexView extends IndexView {

    public function fill() {
        $sql = 'SELECT c.*, COUNT(g.id_gallery) items
                FROM gallery g 
                LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category)
                GROUP BY g.id_gallery_category';

        $collection = Dao::collection('gallery-category');
        $collection->query($sql);

        $this->_renderer->assign('categories', $collection->getRows());
        $this->_renderer->assign('navigator', $collection->getNavigator());
    }
}