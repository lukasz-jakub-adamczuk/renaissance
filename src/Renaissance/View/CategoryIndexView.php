<?php
require_once AYA_DIR.'/Core/View.php';

class CategoryIndexView extends View {

    // public function fill() {
    //     $this->_runBeforeFill();
    //     $this->_runAfterFill();
    // }
    
    public function beforeFill() {
        // dla potomnych
        $collection = Dao::collection($this->_sDaoName);
        $collection->orderby('idx');
        $collection->where('visible', '1');
        $collection->load(-1);

        $this->_renderer->assign('categories', $collection->getRows());
    }
}