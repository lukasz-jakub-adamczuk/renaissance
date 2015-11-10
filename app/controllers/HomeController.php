<?php

class HomeController extends FrontController {

	public function indexAction() {
		require_once APP_DIR.'/helpers/CupManagement.php';
	}
}