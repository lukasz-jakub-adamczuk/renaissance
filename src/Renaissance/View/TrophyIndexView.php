<?php
require_once AYA_DIR.'/Core/View.php';

class TrophyIndexView extends View {

    public function fill() {
        $sql = 'SELECT t.*
                FROM trophy t';
                // GROUP BY s.id_type';

        $collection = Dao::collection('trophy');
        $collection->query($sql);

        $this->_renderer->assign('aTypes', $collection->getRows());
        $this->_renderer->assign('navigator', $collection->getNavigator());
    }
}