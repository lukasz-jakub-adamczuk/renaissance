<?php

class AuthController extends FrontController {

	public function indexAction() {
		if (!isset($_SESSION['user'])) {
			Debug::show('unauthorized', 'user', 'warning');
			$this->setTemplateName('auth');
			Debug::show($this->_sTemplateName, 'indexAction() in ' . $this->getCtrlName() . ' ctrl');
		} else {
			Debug::show('authorized', 'user', 'info');
			$this->actionForward('index', 'home', true);
		}	
	}

	public function loginAction() {
		Debug::show('login');

		// initial error message
		// changed when success
		$aMsg['text'] = 'Nieprawidłowe dane logowania.';
		$aMsg['type'] = 'warning';

		$this->setTemplateName('auth');

		if (isset($_POST['auth'])) {
			$sUser = isset($_POST['auth']['user']) ? $_POST['auth']['user'] : '';
			$sPass = isset($_POST['auth']['pass']) ? $_POST['auth']['pass'] : '';
			if (!empty($sUser) && !empty($sPass)) {
				$sql = 'SELECT * 
						FROM user u
						WHERE name="'.addslashes($sUser).'" AND hash="'.sha1(addslashes(strtolower($sUser)).addslashes($sPass)).'"';
				$oEntity = Dao::entity('user');
				$oEntity->query($sql);

				$oEntity->load();

				$aUser = $oEntity->getFields();

				if ($aUser) {
					$_SESSION['user']['id'] = $aUser['id_user'];
					$_SESSION['user']['name'] = $aUser['name'];
					$_SESSION['user']['slug'] = $aUser['slug'];
					$_SESSION['user']['active'] = $aUser['active'];
					$_SESSION['user']['group'] = isset($aUser['group_slug']) ? $aUser['group_slug'] : '';
					$_SESSION['user']['perm'] = isset($aUser['sz_perm']) ? $aUser['sz_perm'] : '';
					$_SESSION['user']['avatar'] = $aUser['avatar'];
					// print_r($aUser);

					// avatar for editor
					$sAvatarFile = '/assets/site/redaction/'.$aUser['slug'].'.png';
					if (file_exists(PUB_DIR . $sAvatarFile)) {
						$_SESSION['user']['avatar'] = $sAvatarFile;
					}

					// set user container after login
					User::set($_SESSION['user']);

					$this->actionForward('index', 'home', true);

					$aMsg['text'] = 'Logowanie zakończone sukcesem.';
					$aMsg['type'] = 'info';
				}
			}
		}
		$this->_oRenderer->assign('aMsgs', array($aMsg));
	}

	public function logoutAction() {
		Debug::show('logoutAction()');

		if (isset($_SESSION['user'])) {
			// $this->_oRenderer->display('login.tpl');
			unset($_SESSION['user']);
		}
			// die();
			// $this->setTemplateName('auth');
			Debug::show($this->_sTemplateName, 'logoutAction() in ' . $this->getCtrlName() . ' ctrl');
			// teoretically should be possible to fetch ctrl and act from url for redirection
			$this->actionForward('index', 'home', true);
		// }
	}
}