<?php

class CommentController extends CrudController {

	public function removeAction() {
		if (isset($_GET['id'])) {
			$aIds = array($_GET['id']);
		}
		if (isset($_POST['ids'])) {
			$aIds = $_POST['ids'];
		}
		
		if (isset($aIds)) {
			$aNames = array();
			foreach ($aIds as $id) {
				$oEntity = Dao::entity($this->_sCtrlName, $id, 'id_'.$this->_sCtrlName);

				$aPossibleNameKeys = array('title', 'name');
				foreach ($aPossibleNameKeys as $key) {
					if ($oEntity->hasField($key)) {
						$sName = $oEntity->getField($key);
					} else {
						$sName = $id;
					}
				}
				
				if ($oEntity->delete()) {
					$this->addHistoryLog('remove', $this->_sCtrlName, $id);
					$aNames[] = $sName;
				}
			}

			// msg
			if (count($aNames) == 1) {
				$this->raiseInfo('Wpis <strong>'.$aNames[0].'</strong> został usunięty.');
			} elseif (count($aNames) > 1) {
				$this->raiseInfo('Wpisy <strong>'.implode(', ', $aNames).'</strong> zostały usunięte.');
			} else {
				$this->raiseError('Wystąpił nieoczekiwany wyjątek.');
			}
			// 
			$aParams = array();
			$aParams['get:category'] = 'tomb-raider';
			$aParams['get:slug'] = 'recenzja';

			// print_r($aParams);

			$this->actionForward('info', 'article', true, $aParams);
		}
	}
}