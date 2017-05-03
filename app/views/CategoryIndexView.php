<?php
require_once AYA_DIR.'/Core/View.php';

class CategoryIndexView extends View {

    // public function fill() {
    //     $this->_runBeforeFill();
    //     $this->_runAfterFill();
    // }
    
    public function beforeFill() {
        // dla potomnych
        $oCollection = Dao::collection($this->_sDaoName);
        $oCollection->orderby('idx');
        $oCollection->where('visible', '1');
        $oCollection->load(-1);

        $this->_renderer->assign('aCategories', $oCollection->getRows());
    }
}