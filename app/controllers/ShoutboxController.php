<?php

class ShoutboxController extends CrudController {

	public function insertAction() {
		$oEntity = Dao::entity('shout');

		$this->_oRenderer->assign('shout', $_POST['shout']);

		$aShout = array();
		$aShout['shout'] = $_POST['shout'];
		$aShout['id_author'] = isset($_POST['id_user']) ? $_POST['id_user'] : $_SESSION['user']['id'];
		$aShout['creation_date'] = date('Y-m-d H:i:s');

		$oEntity->setFields($aShout);

		if ($oEntity->insert(true)) {
			// put shout to file
			$sFile = ROOT_DIR . '/../renaissance/app/cache/shouts';
			if (file_exists($sFile)) {
				$aShouts = json_decode(file_get_contents($sFile), true);
				// print_r($aShouts);
			} else {
				$aShouts = array();
			}
			// TODO be sure it will be disabled on production
			$aShout['name'] = isset($_POST['name']) ? $_POST['name'] : $_SESSION['user']['name'];
			$aShout['slug'] = isset($_POST['slug']) ? $_POST['slug'] : $_SESSION['user']['slug'];
			

			$aShouts[strtotime($aShout['creation_date'])] = $aShout;
			file_put_contents($sFile, json_encode($aShouts));
		} else {
			echo 'some error';
		}

		$this->actionForward('index', $this->_sCtrlName, true);
	}

	public function getAction() {
		$this->setContentType('json');

		$iTimestamp = isset($_GET['timestamp']) ? (int)$_GET['timestamp'] : null;
		$sFile = ROOT_DIR . '/../renaissance/app/cache/shouts';
		if (file_exists($sFile)) {
			if ($iTimestamp) {
				$aShouts = json_decode(file_get_contents($sFile), true);
				// print_r($aShouts);
				$aJsonContent = array();
				foreach ($aShouts as $sk => $shout) {
					if ($iTimestamp < (int)$sk) {
						$aJsonContent[$sk] = $shout;
					}
				}
				$this->_oRenderer->assign('sJsonContent', json_encode(array_reverse($aJsonContent)));
			} else {
				$this->_oRenderer->assign('sJsonContent', file_get_contents($sFile));
			}
		} else {
			$aShouts = array();
			$aShouts[] = $aShout;
			file_put_contents($sFile, json_encode($aShouts));
		}
	}
}