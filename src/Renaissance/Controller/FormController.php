<?php

namespace Renaissance\Controller;

use Aya\Core\Dao;
use Aya\Core\Logger;
use Aya\Helper\ValueMapper;
use Renaissance\Helper\CupManager;

class FormController extends FrontController {

    public function beforeInsert() {
        // print_r($_POST);
        $aPost = [];
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                foreach ($val as $k => $v) {
                    $aPost[$key][$k] = strip_tags($v);
                }
            }
        }
        return $aPost;
    }

    public function afterUpdate($iId) {

    }

    public function commentAction() {
        $iId = 0;

        if (isset($_POST['request'])) {
            $aPost = $this->beforeInsert($_POST);

            if (isset($aPost['dataset']['check']) && $aPost['dataset']['check'] !== date('Y')) {
                Logger::logStandardRequest('issues');

                die('You are robot!');

                // $this->actionForward('index', 'home', true);
            }

            $sEnitityName = $aPost['request']['ctrl'].'-comment';

            $oEntity = Dao::entity($sEnitityName, $iId);

            // $oEntity->setFields($aPost['dataset']);
            $sComment = $aPost['dataset']['comment'];
            $sObjectIdName = 'id_'.str_replace('-', '_', $aPost['request']['ctrl']);

            if (isset($aPost['dataset']['id_author'])) {
                $oEntity->setField('id_author', $aPost['dataset']['id_author']);
                $oEntity->setField('visible', 1);
            } else {
                $oEntity->setField('id_author', 0);
                $oEntity->setField('visible', 0);
                $sComment = htmlentities($sComment)."\n\n".$aPost['dataset']['author'];
            }
            $oEntity->setField($sObjectIdName, $aPost['dataset'][$sObjectIdName]);
            $oEntity->setField('comment', $sComment);

            $aPossibleNameKeys = array('title', 'name');
            foreach ($aPossibleNameKeys as $key) {
                if (isset($aPost['dataset'][$key])) {
                    $name = $aPost['dataset'][$key];
                    break;
                }
            }

            // no creation date
            // TODO or creation date invalid
            if (empty($aPost['dataset']['creation_date'])) {
                $oEntity->setField('creation_date', date('Y-m-d H:i:s'));
            }

            // print_r($oEntity);
            
            if ($iId = $oEntity->insert(true)) {
                // $this->afterInsert($iId);

                if (isset($aPost['dataset']['id_author'])) {
                    // authorized
                    $this->raiseInfo('Komentarz '.(isset($name) ? '<strong>'.$name.'</strong>' : '').' został utworzony.');
                } else {
                    $this->raiseInfo('Komentarz '.(isset($name) ? '<strong>'.$name.'</strong>' : '').' czeka na moderację. Nie dodawaj kolejnego takiego samego, tylko zaczekaj aż ten zostanie zaakceptowany.');
                }                
                
                // clear right stream
                $sStreamFile = CACHE_DIR . '/stream-' . $aPost['request']['ctrl'];
                if (file_exists($sStreamFile)) {
                    unlink($sStreamFile);
                }

                // clear main stream
                $sStreamFile = CACHE_DIR . '/stream';
                if (file_exists($sStreamFile)) {
                    unlink($sStreamFile);
                }

                // clearing stream even could not be affected :D

                // clear unauthorized comments when such created
                if (!isset($aPost['dataset']['id_author'])) {
                    $storageKey = CACHE_DIR . '/sql/unauthorized-'.$aPost['request']['ctrl'].'-comments';
                    if (file_exists($storageKey)) {
                        unlink($storageKey);
                    }
                    $storageKey = CACHE_DIR . '/sql/all-unauthorized-comments';
                    if (file_exists($storageKey)) {
                        unlink($storageKey);
                    }
                }

                $this->actionForward('index', $this->_ctrlName, true);
            } else {
                $this->raiseError('Wystąpił nieoczekiwany wyjątek.');
                $this->actionForward('info', $this->_ctrlName);
            }


            // params to override request
            // print_r($aPost['request']);
            $aParams = [];
            foreach ($aPost['request'] as $key => $value) {
                $aParams['get:'.$key] = $value;
            }

            // redirect to right page after comment
            $redirectParams = [];

            foreach ($aPost['request'] as $pk => $param) {
                if ($pk === 'ctrl') {
                    $redirectParams[] = ValueMapper::getUrl($param);
                } elseif ($pk === 'act') {
                    // ignore
                } else {
                    $redirectParams[] = $param;
                }
            }

            header('Location: '.BASE_URL.'/'.implode('/', $redirectParams).'#komentarze', TRUE, 303);

            $this->actionForward('info', $aPost['request']['ctrl'], true, $aParams);
        } else {
            // take care
            $this->actionForward('index', 'home');
        }
    }

    public function voteAction() {
        // cup handling
        if (isset($_POST['match']['player1']) && isset($_POST['match']['player2']) && isset($_POST['match']['vote'])) {
            if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {

                // echo 'glosowanie';

                $aPost = $this->beforeInsert();

                // print_r($aPost);

                $sUserId = $_SESSION['user']['id'];
                $vote = $aPost['match']['vote'];
                $currentMatchDate = date('Y-m-d');
                // $sMatchDate = '2015-05-05';

                $player1 = $aPost['match']['player1'];
                $player2 = $aPost['match']['player2'];
                
                $cupManager = new CupManager();
                
                if (!$cupManager->canUserVote()) {
                    // echo 'Tylko jeden głos';
                    $this->raiseError('Głosowanie możliwe tylko raz dziennie.');
                } else {
                    // echo 'glosujesz';
                    $cupManager->manageVotingProcess($sUserId, $player1, $player2, $vote);
                    
                    $this->raiseInfo('Dziękujemy za Twój głos!');
                }
            }

            $this->actionForward('index', 'home', true);
        } else {
            // take care
            $this->actionForward('index', 'home');
        }
    }
}
