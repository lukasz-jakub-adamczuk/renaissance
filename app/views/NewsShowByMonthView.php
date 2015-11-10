<?php
require_once AYA_DIR.'/Core/View.php';

class NewsShowByMonthView extends View {

	public function fill() {
		// breadcrumbs
		$aItem = array(
			'url' => ValueMapper::getUrl('news').'/'.$_GET['year'],
			'text' => $_GET['year']
		);
		Breadcrumbs::add($aItem);

		$sYear = $_GET['year'];
		$sMonth = $_GET['month'];

		$sql = 'SELECT n.*, COUNT(n.id_news) items, u.name user, COUNT(nc.id_news_comment) comments 
				FROM news n 
				LEFT JOIN user u ON(u.id_user=n.id_author) 
				LEFT JOIN news_comment nc ON(nc.id_news=n.id_news) 
				WHERE YEAR(n.creation_date)="'.$sYear.'" AND MONTH(n.creation_date)="'.$sMonth.'" 
				GROUP BY n.id_news 
				ORDER BY n.id_news';
		
		$oNewsCollection = Dao::collection('news');
		$oNewsCollection->query($sql);

		$this->_oRenderer->assign('aActivities', $oNewsCollection->getRows());
		$this->_oRenderer->assign('aNavigator', $oNewsCollection->getNavigator());
	}
}