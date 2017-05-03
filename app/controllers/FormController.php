<?php

class FormController extends CrudController {

    public function preInsert() {
        // print_r($_POST);
        $aPost = array();
        if (isset($_POST)) {
            foreach ($_POST as $key => $val) {
                foreach ($val as $k => $v) {
                    $aPost[$key][$k] = strip_tags($v);
                }
            }
        }
        return $aPost;
    }

    public function postUpdate($iId) {

    }

    public function insertAction() {
        $iId = 0;

        if (isset($_POST['request'])) {
            $aPost = $this->preInsert($_POST);

            if (isset($aPost['dataset']['check']) && $aPost['dataset']['check'] !== date('Y')) {
                $sLogFile = LOG_DIR.'/issues/'.date('Y-m-d').'.log';
                Logger::logStandardRequest($sLogFile);

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
                    $sName = $aPost['dataset'][$key];
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
                // $this->postInsert($iId);

                if (isset($aPost['dataset']['id_author'])) {
                    // authorized
                    $this->raiseInfo('Komentarz '.(isset($sName) ? '<strong>'.$sName.'</strong>' : '').' został utworzony.');
                } else {
                    $this->raiseInfo('Komentarz '.(isset($sName) ? '<strong>'.$sName.'</strong>' : '').' czeka na moderację. Nie dodawaj kolejnego takiego samego, tylko zaczekaj aż ten zostanie zaakceptowany.');
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

                // clear comments
                // $sStreamFile = CACHE_DIR . '/sql/all-';
                // unlink($sCacheFile.'-'.$aPost['request']['ctrl']);

                $this->actionForward('index', $this->_ctrlName, true);
            } else {
                $this->raiseError('Wystąpił nieoczekiwany wyjątek.');
                $this->actionForward('info', $this->_ctrlName);
            }

            // params to override request
            // print_r($aPost['request']);
            $aParams = array();
            foreach ($aPost['request'] as $key => $value) {
                $aParams['get:'.$key] = $value;
            }
            // $aParams['get:ctrl'] = $aPost['request']['ctrl'];
            // $aParams['get:act'] = 'info';
            // $aParams['get:slug'] = $aPost['request']['object_slug'];
            // if (isset($aPost['request']['category_slug'])) {
            //     $aParams['get:category'] = $aPost['request']['category_slug'];
            // }

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

                $aPost = $this->preInsert();

                // print_r($aPost);

                $sUserId = $_SESSION['user']['id'];
                $vote = $aPost['match']['vote'];
                $currentMatchDate = date('Y-m-d');
                // $sMatchDate = '2015-05-05';

                $player1 = $aPost['match']['player1'];
                $player2 = $aPost['match']['player2'];
                
                require_once APP_DIR.'/helpers/CupManager.php';
                
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
