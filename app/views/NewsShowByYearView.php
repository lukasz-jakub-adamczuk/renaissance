<?php
require_once AYA_DIR.'/Core/View.php';

class NewsShowByYearView extends View {

    public function fill() {
        $sYear = $_GET['year'];

        $sql = 'SELECT n.*, COUNT(n.id_news) items, YEAR(n.creation_date) year, MONTH(n.creation_date) month 
                FROM news n 
                WHERE YEAR(n.creation_date)='.$sYear.' 
                GROUP BY MONTH(n.creation_date)';
        
        $oNewsCollection = Dao::collection('news');
        $oNewsCollection->query($sql);

        $this->_renderer->assign('aActivities', $oNewsCollection->getRows());
        $this->_renderer->assign('aNavigator', $oNewsCollection->getNavigator());
    }
}