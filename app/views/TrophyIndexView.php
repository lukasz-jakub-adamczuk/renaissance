<?php
require_once AYA_DIR.'/Core/View.php';

class TrophyIndexView extends View {

	public function fill() {
		$sql = 'SELECT t.*
				FROM trophy t';
				// GROUP BY s.id_type';

		$oCollection = Dao::collection('trophy');
		$oCollection->query($sql);

		$this->_oRenderer->assign('aTypes', $oCollection->getRows());
		$this->_oRenderer->assign('aNavigator', $oCollection->getNavigator());
	}
}