<?php
require_once AYA_DIR.'/Core/View.php';

// grupy

class CupShowByCategoryView extends View {

	public function fill() {
		$sCategorySlug = isset($_GET['category']) ? $_GET['category'] : null;
		$sCategoryName = ucwords(str_replace('-', ' ', $sCategorySlug));

		$sql = 'SELECT c.*
				FROM cup c
				WHERE c.slug="'.$sCategorySlug.'"';

		$oCollection = Dao::collection('cup');
		$oCollection->query($sql);

		$aRows = $oCollection->getRows();
		
		if ($aRows) {
			// cup
			$aObject = current($aRows);
			$this->_oRenderer->assign('aObject', current($aRows));


			$sql = 'SELECT cp.*
					FROM cup_player cp
					LEFT JOIN cup c ON (c.id_cup=cp.id_cup)
					WHERE c.slug="'.$sCategorySlug.'"';

			$oCollection = Dao::collection('cup-player');
			$oCollection->query($sql);

			// category name
			$this->_oRenderer->assign('sCategoryName', $sCategoryName);

			// title
			$this->_oRenderer->assign('sTitle', 'Squarezone - Mistrzostwa - '.$sCategoryName);

			$this->_oRenderer->assign('aGroups', $oCollection->getRows());
			$this->_oRenderer->assign('aNavigator', $oCollection->getNavigator());
		} else {
			// log 404
		}
	}
}