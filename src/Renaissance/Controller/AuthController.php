<?php

namespace Renaissance\Controller;

use Aya\Helper\AuthManager;
// use Aya\Core\Dao;
// use Aya\Core\Debug;
// use Aya\Helper\Text;
// use Aya\Core\User;

use Renaissance\Controller\FrontController;

class AuthController extends FrontController {

    public function loginAction() {
        AuthManager::login();
    }

    public function logoutAction() {
        AuthManager::logout();
    }
}
