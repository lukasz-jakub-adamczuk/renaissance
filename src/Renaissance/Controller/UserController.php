<?php

namespace Renaissance\Controller;

use Aya\Core\Dao;
use Aya\Helper\Text;
use Aya\Helper\MessageList;

use Renaissance\Controller\FrontController;

use Aya\Exception\MissingEntityException;

class UserController extends FrontController {

    public function indexAction() {}

    public function infoAction() {}

    public function registerAction() {
        // think about sanitize data
        $aPost = isset($_POST['register']) ? $_POST['register'] : null;

        $aErrors = [];

        if ($aPost) {
            // name
            if (empty($aPost['name'])) {
                $aErrors['name'][] = 'Nazwa jest pusta.';
            }
            // email
            if (empty($aPost['email'])) {
                $aErrors['email'][] = 'Adres email jest pusty.';
            }
            // password
            if (empty($aPost['password'])) {
                $aErrors['password'][] = 'Hasło jest puste.';
            }
            if (strlen($aPost['password']) < 8) {
                $aErrors['password'][] = 'Hasło zbyt krótkie.';
            }
            if (strlen($aPost['password']) > 16) {
                $aErrors['password'][] = 'Hasło za długie.';
            }
            // retype-password
            if ($aPost['password_retype'] !== $aPost['password']) {
                $aErrors['password_retype'][] = 'Powtórzone hasło jest nieprawidłowe.';
            }
            // challenge
            if ($aPost['challenge'] !== date('n')) {
                $aErrors['challenge'][] = 'Nieprawidłowa odpowiedź.';
            }

            

            // start proccess for right conditions only
            if (count($aErrors) == 0) {
                $name = strip_tags($aPost['name']);
                $pass = strip_tags($aPost['password']);
                $email = strip_tags($aPost['email']);

                $slug = Text::slugify($name);

                try {
                    $userNameExists = Dao::entity('user')->doesUserNameExists($name);
                } catch (MissingEntityException $e) {
                    $userNameExists = false;
                }
                try {
                    $userSlugExists = Dao::entity('user')->doesUserSlugExists($slug);
                } catch (MissingEntityException $e) {
                    $userSlugExists = false;
                }
                try {
                    $userEmailExists = Dao::entity('user')->doesUserEmailExists($email);
                } catch (MissingEntityException $e) {
                    $userEmailExists = false;
                }
                
                if ($userNameExists || $userSlugExists) {
                    $aErrors['name'][] = 'Podana nazwa użytkownika jest zajęta.';
                }

                if ($userEmailExists) {
                    $aErrors['email'][] = 'Podany adres email jest zajęty.';
                }

                // here we should send a verification email
                if (count($aErrors) == 0) {
                    $userEntity = Dao::entity('user');

                    $userEntity->setField('name', $name);
                    $userEntity->setField('slug', $slug);
                    $userEntity->setField('hash', sha1(addslashes(strtolower($name)).addslashes($pass)));
                    $userEntity->setField('email', $email);
                    $userEntity->setField('register_date', date('Y-m-d H:i:s'));
                    $userEntity->setField('secret', 'secret');

                    // if ($userEntity->insert(true)) {
                    if (true) {
                        MessageList::raiseInfo('Konto '.(isset($name) ? '<strong>'.$name.'</strong>' : '').' zostało utworzone.');

                        $this->actionForward('index', 'home', true);
                    } else {
                        MessageList::raiseError('Utworzenie konta zakończone niepowodzeniem.');
                    }
                }
            }
        }

        $this->_renderer->assign('errors', $aErrors);
    }
}