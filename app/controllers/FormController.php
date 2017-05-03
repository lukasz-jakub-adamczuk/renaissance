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
                    $this->raiseInfo('Komentarz '.(isset($sName) ? '<strong>'.$sName.'</strong>' : '').' czeka na moderację.');
                }

                // clear stream, but not for all
                $sStreamFile = CACHE_DIR . '/stream';

                // verify by file_exists()
                unlink($sStreamFile);

                // clear stream
                if (file_exists($sStreamFile.'-'.$aPost['request']['ctrl'])) {
                    unlink($sStreamFile.'-'.$aPost['request']['ctrl']);
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
        // echo 'voteAction';
        // cup handling
        if (isset($_POST['match']['player1']) && isset($_POST['match']['player2']) && isset($_POST['match']['vote'])) {
            if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {

                // echo 'glosowanie';

                $aPost = $this->preInsert();

                // print_r($aPost);

                $sUserId = $_SESSION['user']['id'];
                $sVote = $aPost['match']['vote'];
                $sMatchDate = date('Y-m-d');
                // $sMatchDate = '2015-05-05';

                $sPlayer1 = $aPost['match']['player1'];
                $sPlayer2 = $aPost['match']['player2'];

                $oDb = Db::getInstance();
                
                $mYourVote = $oDb->getOne('SELECT * FROM cup_vote WHERE id_user='.$sUserId.' AND voting_date="'.$sMatchDate.'"');

                // var_dump($mYourVote);

                if (!empty($mYourVote)) {
                    // echo 'Tylko jeden głos';
                    $this->raiseError('Głosowanie możliwe tylko raz dziennie.');
                } else {
                    $aSql = array();

                    // echo 'glosujesz';
                    
                    // register user 
                    $aSql[] = 'INSERT INTO cup_vote(id_cup_vote, id_user, voting_date) VALUES (NULL, '.$sUserId.', "'.$sMatchDate.'")';

                    // what tournament
                    if (date('Y') % 2 == 0) {
                        $sTournamentSlug = '/heroine-cup-' . date('Y');
                    } else {
                        $sTournamentSlug = '/hero-cup-' . date('Y');
                    }

                    $sCupCachePath = CACHE_DIR . '/cup' . $sTournamentSlug;
                    if (!file_exists($sCupDirectory)) {
                        mkdir($sCupDirectory, 0777, true);
                    }

                    // all battles
                    $sAllBattlesKeysFile = $sCupCachePath . '/all-battles-keys';
                    if (file_exists($sAllBattlesKeysFile)) {
                        $aBattlesKeys = unserialize(file_get_contents($sAllBattlesKeysFile));
                    } else {
                        $sql = 'SELECT id_cup_battle, player1, player2 FROM cup_battle WHERE id_cup = (SELECT MAX(id_cup) FROM cup) ORDER BY id_cup_battle';
        
                        $oCollection = Dao::collection('cup-battle');
                        $oCollection->query($sql);
                        $aBattles = $oCollection->getRows();

                        $aBattlesKeys = array_keys($aBattles);

                        file_put_contents($sAllBattlesFileKeys, serialize($aBattlesKeys));
                    }
                    
                    $aBattlesKeysFlipped = array_flip($aBattlesKeys);

                    // only group phase
                    if ($aBattlesKeysFlipped[$sMatchDate] < 48) {
                        // add winning vote to player
                        $aSql[] = 'UPDATE cup_player SET `won` = `won` + 1 WHERE id_cup_player='.$sVote.'';

                        // add lossing points to opponent
                        if ($sPlayer1 == $sVote) {
                            $aSql[] = 'UPDATE cup_player SET `lost` = `lost` + 1 WHERE id_cup_player='.$sPlayer2.'';
                        }
                        if ($sPlayer2 == $sVote) {
                            $aSql[] = 'UPDATE cup_player SET `lost` = `lost` + 1 WHERE id_cup_player='.$sPlayer1.'';
                        }
                    }

                    if ($sPlayer1 == $sVote) {
                        $aSql[] = 'UPDATE cup_battle SET `score1` = `score1` + 1 WHERE id_cup_battle="'.$sMatchDate.'"';
                    }
                    if ($sPlayer2 == $sVote) {
                        $aSql[] = 'UPDATE cup_battle SET `score2` = `score2` + 1 WHERE id_cup_battle="'.$sMatchDate.'"';
                    }

                    // echo 'Twój głos zaliczony';

                    // print_r($aSql);
                    foreach ($aSql as $sql) {
                        $oDb->execute($sql);
                    }
                    
                    // run all queries
                    // $oDb->execute(implode(';', $aSql));
                    $this->raiseInfo('Dziękujemy za Twój głos!');

                    // clear cache
                    $sMatchDate = date('Y-m-d');
                    $sMatchFile = $sCupCachePath . '/matches/' . $sMatchDate;
                    if (file_exists($sMatchFile)) {
                        unlink($sMatchFile);
                    }

                    // clear cup battles cache
                    $sAllBattlesFile = $sCupCachePath . '/all-battles';
                    if (file_exists($sAllBattlesFile)) {
                        unlink($sAllBattlesFile);
                    }
                }
            }

            $this->actionForward('index', 'home', true);
        } else {
            // take care
            $this->actionForward('index', 'home');
        }
    }
}