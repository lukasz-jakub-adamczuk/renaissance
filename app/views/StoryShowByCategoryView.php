<?php
require_once AYA_DIR.'/Management/IndexView.php';

class StoryShowByCategoryView extends IndexView {

	public function defaultOrdering() {
		// $this->_oCollection->navDefault('sort', 'creation-date');
		// $this->_oCollection->navDefault('order', 'asc');
	}

	public function fill() {
		$sCategory = $_GET['category'];

		$sql = 'SELECT s.*, c.name category, c.slug category_slug
				FROM story s 
				LEFT JOIN story_category c ON(c.id_story_category=s.id_story_category) 
				WHERE c.slug="'.$sCategory.'" 
				ORDER BY s.creation_date DESC';

		$oCollection = Dao::collection('story');
		$oCollection->query($sql);

		$aArticles = $oCollection->getRows();

		$aCurrent = current($aArticles);

		$this->_oRenderer->assign('aArticles', $aArticles);

		$this->_oRenderer->assign('sCategory', $aCurrent['category']);
	}
}