<?php
require_once AYA_DIR.'/Management/IndexView.php';

class StoryIndexView extends IndexView {

    public function fill() {
        $sql = 'SELECT c.*, COUNT(s.id_story) items
                FROM story s 
                LEFT JOIN story_category c ON(c.id_story_category=s.id_story_category)
                GROUP BY s.id_story_category';

        $oCollection = Dao::collection('story-category');
        $oCollection->query($sql);

        $this->_renderer->assign('aCategories', $oCollection->getRows());
        $this->_renderer->assign('aNavigator', $oCollection->getNavigator());
    }
}