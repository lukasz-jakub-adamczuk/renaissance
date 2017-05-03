<?php
require_once AYA_DIR.'/Core/View.php';

class NewsIndexView extends View {

    public function fill() {
        $sql = 'SELECT n.*, COUNT(n.id_news) items, YEAR(n.creation_date) year 
                FROM news n 
                GROUP BY YEAR(n.creation_date) 
                ORDER BY n.id_news';
        
        $oNewsCollection = Dao::collection('news');
        $oNewsCollection->query($sql);

        $this->_renderer->assign('aActivities', $oNewsCollection->getRows());
        $this->_renderer->assign('aNavigator', $oNewsCollection->getNavigator());
    }
}