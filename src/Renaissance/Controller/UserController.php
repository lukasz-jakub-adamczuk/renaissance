<?php

namespace Renaissance\Controller;

use Aya\Core\Dao;
use Aya\Helper\Text;
use Aya\Helper\MessageList;

use Renaissance\Controller\FrontController;

class UserController extends FrontController {

    public function indexAction() {}

    public function infoAction() {}

    public function registerAction() {
        // think about sanitize data
        $aPost = isset($_POST['register']) ? $_POST['register'] : null;

        die('regisrarion is disabled now...');

        if ($aPost) {
            // MessageList::raiseError('register post data...');

            $aErrors = [];
            // start checking

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

            // start proccess for right conditions only
            if (count($aErrors) == 0) {
                // MessageList::raiseError('valid data...');

                $name = $aPost['name'];
                $sPass = $aPost['password'];
                $sEmail = $aPost['email'];

                $slug = Text::slugify($aPost['name']);

                // be sure the account can be created
                $db = Db::getInstance();

                $sql = 'SELECT email
                        FROM user
                        WHERE name="'.$name.'" OR slug="'.$slug.'" OR email="'.$sEmail.'"';
                
                // if exists a record then account can not be created
                $aUser = $db->getRow($sql);

                // var_dump($aUser);
                // MessageList::raiseError(sha1(addslashes(strtolower($name)).addslashes($sPass)));

                // here we should send a verification email
                if ($aUser === false) {
                    // MessageList::raiseError('can create account...');

                    $oEntity = Dao::entity('user');

                    $oEntity->setField('name', $name);
                    $oEntity->setField('slug', $slug);
                    $oEntity->setField('hash', sha1(addslashes(strtolower($name)).addslashes($sPass)));
                    $oEntity->setField('email', $sEmail);
                    $oEntity->setField('register_date', date('Y-m-d H:i:s'));

                    // $oEntity->setField('activation', sha1(strtolower($name)));

                    // print_r($oEntity);

                    if ($oEntity->insert(true)) {
                        MessageList::raiseInfo('Konto '.(isset($name) ? '<strong>'.$name.'</strong>' : '').' zostało utworzone.');
                    } else {
                        MessageList::raiseError('Utworzenie konta zakończone niepowodzeniem.');
                    }
                } else {
                    MessageList::raiseError('Istnieje konto dla tego użytkownika.');
                }
            } else {
                MessageList::raiseError('Wystąpiły następujące błędy: ' + implode(', ', $aErrors) + '.');
            }


        } else {
            MessageList::raiseError('Błędy... Coś kombinujesz...');
        }
    }
}