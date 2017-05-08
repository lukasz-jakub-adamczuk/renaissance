<?php
require_once AYA_DIR.'/Core/View.php';

class SearchIndexView extends View {

    public function fill() {
        $sSearch = isset($_GET['search']) ? $_GET['search'] : null;
        
        if ($sSearch) {
            $sql = 'SELECT n.*, COUNT(n.id_news) items, u.name user, COUNT(nc.id_news_comment) comments 
                    FROM news n 
                    LEFT JOIN user u ON(u.id_user=n.id_author) 
                    LEFT JOIN news_comment nc ON(nc.id_news=n.id_news) 
                    WHERE n.title LIKE "%'.$sSearch.'%" 
                    GROUP BY n.id_news 
                    ORDER BY n.id_news DESC
                    LIMIT 0,30';
            
            $oNewsCollection = Dao::collection('news');
            $oNewsCollection->query($sql);
            
            $this->_renderer->assign('iTotal', count($oNewsCollection->getRows()));

            $this->_renderer->assign('aActivities', $oNewsCollection->getRows());
            $this->_renderer->assign('aNavigator', $oNewsCollection->getNavigator());
        }
    }
}
