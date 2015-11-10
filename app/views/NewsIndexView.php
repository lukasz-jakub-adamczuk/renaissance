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

		$this->_oRenderer->assign('aActivities', $oNewsCollection->getRows());
		$this->_oRenderer->assign('aNavigator', $oNewsCollection->getNavigator());
	}
}