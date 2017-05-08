<?php

class CupManager {

    private $db;
    
    private $cupCachePath;
    
    private $currentBattleDate;
    
    private $lastBattleDate;
    
    private $sqlQueries;
    
    public function __construct() {
        $this->db = Db::getInstance();
        
        // current battle
        $this->currentBattleDate = date('Y-m-d');

        $oDate = date_create($this->currentBattleDate);
        date_modify($oDate, '-1day');

        // last battle
        $this->lastBattleDate = date_format($oDate, 'Y-m-d');
        
        $this->sqlQueries = [];

        // tournament
        if (date('Y') % 2 == 0) {
            $tournamentSlug = '/heroine-cup-' . date('Y');
        } else {
            $tournamentSlug = '/hero-cup-' . date('Y');
        }

        // cup paths
        $this->cupCachePath = CACHE_DIR . '/cup' . $tournamentSlug;

        // directories
        $sStatsFile = $this->cupCachePath . '/stats';
        if (!file_exists($sStatsFile)) {
            mkdir($sStatsFile, 0777, true);
        }
        $battlesFile = $this->cupCachePath . '/battles';
        if (!file_exists($battlesFile)) {
            mkdir($battlesFile, 0777, true);
        }
        $sWinnersFile = $this->cupCachePath . '/winners';
        if (!file_exists($sWinnersFile)) {
            mkdir($sWinnersFile, 0777, true);
        }
        $sPlayersFile = $this->cupCachePath . '/players';
        if (!file_exists($sPlayersFile)) {
            mkdir($sPlayersFile, 0777, true);
        }
    }
    
    public function manageCalculationProcess() {
        $allBattlesKeys = $this->getAllBattlesKeys();
        
        $allBattlesKeysFlipped = array_flip($allBattlesKeys);
        
        if ($allBattlesKeysFlipped) {
            $battleDetails = $this->getBattleDetails($this->lastBattleDate);
            
            if (isset($battleDetails)) {
                $aPlayers = current($battleDetails);

                $player1 = $aPlayers['player1'];
                $player2 = $aPlayers['player2'];
            }
            
            $player1Stats = $this->getPlayerStats($player1, $this->currentBattleDate);
            $this->updatePlayerStats($player1, $player1Stats);
            
            $player2Stats = $this->getPlayerStats($player2, $this->currentBattleDate);
            $this->updatePlayerStats($player2, $player2Stats);
        }
        
        // cup phase
        $winnersFile = $this->cupCachePath . '/winners/' . $this->lastBattleDate;
        if (file_exists($winnersFile)) {
            // nothing
            // $aStats = unserialize(file_get_contents($sStatsFile));
        } else {
            $oCollection = Dao::collection('cup-player');
            $players = $oCollection->getPlayersFromLatestCup();
            
            $groups = array();

            // analyze players
            foreach ($players as $pk => $player) {
                if ($player['battles'] == 3) {
                    $groups[$player['group']][] = $player;
                }
            }

            $winners = array();
            
            // analyze groups
            foreach ($groups as $group) {
                if (count($group) == 4) {
                    foreach ($group as $pk => $player) {
                        if ($pk == 0 || $pk == 1) {
                            $winners[($pk + 1).strtoupper($player['group'])] = $player['id_cup_player'];
                        }
                    }
                }
            }
            
            $oCollection = Dao::collection('cup-battle');

            $battles = $oCollection->getCupPhaseBattles();
            
            // process battles
            foreach ($battles as $bk =>$battle) {
                if (date_create($battle['id_cup_battle']) < date_create($this->currentBattleDate)) {
                    if ($battle['score1'] > $battle['score2']) {
                        $winners['W'.($allBattlesKeysFlipped[$bk]+1)] = $battle['player1'];
                        $winners['L'.($allBattlesKeysFlipped[$bk]+1)] = $battle['player2'];
                    }
                    if ($battle['score1'] < $battle['score2']) {
                        $winners['W'.($allBattlesKeysFlipped[$bk]+1)] = $battle['player2'];
                        $winners['L'.($allBattlesKeysFlipped[$bk]+1)] = $battle['player1'];
                    }
                }
            }
            
            // defaults for matches
            $defalutBattles = array(
                '48' => array('1A', '2B'),
                '49' => array('1C', '2D'),
                '50' => array('1B', '2A'),
                '51' => array('1D', '2C'),
                '52' => array('1E', '2F'),
                '53' => array('1G', '2H'),
                '54' => array('1F', '2E'),
                '55' => array('1H', '2G'),

                '56' => array('W49', 'W50'),
                '57' => array('W53', 'W54'),
                '58' => array('W51', 'W52'),
                '59' => array('W55', 'W56'),
                
                '60' => array('W57', 'W58'),
                '61' => array('W59', 'W60'),

                '62' => array('L61', 'L62'),
                '63' => array('W61', 'W62')
            );
            
            // check all cup phase winners and set if needed
            foreach ($defalutBattles as $bk => $battle) {
                $fields = array();

                foreach ($battle as $pk => $player) {
                    $playersFile = $this->cupCachePath . '/players/' . $player;
                    if (file_exists($playersFile)) {
                        // nothing
                    } else {
                        if (isset($winners[$player])) {
                            $fields[] = 'player'.($pk+1).'='.$winners[$player];
                            file_put_contents($playersFile, serialize($player));
                        }
                    }
                }
                if (count($fields)) {
                    $sql = 'UPDATE cup_battle
                            SET '.implode(', ', $fields).'
                            WHERE id_cup_battle="'.$allBattlesKeys[$bk].'"';

                    $this->sqlQueries[] = $sql;
                }
            }
            
            $this->commit();
            
            $this->clearAllBattlesCache();
            
            file_put_contents($winnersFile, serialize($winners));
            
            
        }
        
    }
    
    public function manageVotingProcess($userId, $player1, $player2, $vote) {
        $allBattlesKeys = $this->getAllBattlesKeys();
        
        $allBattlesKeysFlipped = array_flip($allBattlesKeys);
        
        $this->registerUserVote($userId, $this->currentBattleDate);
        
        // only during group phase
        if ($allBattlesKeysFlipped[$this->currentBattleDate] < 48) {
            $this->updatePlayersStats($player1, $player2, $vote);
        }

        $this->updateBattleResult($player1, $player2, $vote);

        $this->commit();
        
        $this->clearCurrentBattleCache();
        $this->clearAllBattlesCache();
    }
    
    public function getAllBattlesKeys() {
        $allBattlesKeysFile = $this->cupCachePath . '/all-battles-keys';
        
        if (file_exists($allBattlesKeysFile)) {
            $allBattlesKeys = unserialize(file_get_contents($allBattlesKeysFile));
        } else {
            $oCollection = Dao::collection('cup-battle');
            $allBattles = $oCollection->getBattles();
            
            $allBattlesKeys = array_keys($allBattles);

            file_put_contents($allBattlesKeysFile, serialize($allBattlesKeys));
        }
        
        return $allBattlesKeys;
    }
    
    public function getCurrentBattle() {
        $currentBattleFile = $this->cupCachePath . '/battles/' . $this->currentBattleDate;
        
        if (file_exists($currentBattleFile)) {
            $currentBattle = unserialize(file_get_contents($currentBattleFile));
        } else {
            $oCollection = Dao::collection('cup-battle');
            $currentBattle = $oCollection->getCurrentBattle($this->currentBattleDate);

            file_put_contents($currentBattleFile, serialize($currentBattle));
        }

        if (count($currentBattle) === 1) {
            return current($currentBattle);
        }
        
        return false;
    }
    
    public function canUserVote() {
        // voting access
        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {

            $sUserId = $_SESSION['user']['id'];
                
            $mYourVote = $this->db->getOne('SELECT * FROM cup_vote WHERE id_user='.$sUserId.' AND voting_date="'.$this->currentBattleDate.'"');

            if ($mYourVote) {
                // user vote exists in db
                return false;
            } else {
                return true;
            }
        }
        return false;
    }
    
    private function getBattleDetails($battleDate) {
        $battleFile = $this->cupCachePath . '/battles/' . $battleDate;
        if (file_exists($battleFile)) {
            $battleDetails = unserialize(file_get_contents($battleFile));
        } else {
            $sql = 'SELECT id_cup_battle, player1, player2 FROM cup_battle WHERE id_cup_battle = "'.$battleDate.'"';
        
            $oCollection = Dao::collection('cup-battle');
            $oCollection->query($sql);
            $battleDetails = $oCollection->getRows();
        }
        
        return $battleDetails;
    }
    
    private function registerUserVote($userId, $BattleDate) {
        $this->sqlQueries[] = 'INSERT INTO cup_vote(id_cup_vote, id_user, voting_date) VALUES (NULL, '.$userId.', "'.$BattleDate.'")';
    }
    
    private function getPlayerStats($player, $battleDate) {
        $sql = '';
        
        $oCollection = Dao::collection('cup-battle');
        $oCollection->query($sql);
        $aResult = $oCollection->getRows();

        $playerStats = current($aResult);
        
        return $playerStats;
    }
    
    private function updatePlayerStats($player, $stats) {
        $playerStatsFile = $this->cupCachePath . '/stats/' . $this->lastBattleDate;
        if (isset($stats['matches']) && isset($stats['wins']) && isset($stats['draws'])) {
            $sql = 'UPDATE cup_player
                    SET battles='.$stats['matches'].', points='.($stats['wins'] + $stats['draws']).'
                    WHERE id_cup_player='.$player.'
                    ';

            if ($this->db->execute($sql)) {
                $sStatsInfo = 'Stats for player#'.$player.' were updated'."\n";
                file_put_contents($playerStatsFile, $sStatsInfo);
            }
        }
    }
    
    private function updatePlayersStats($player1, $player2, $vote) {
        // add point to winning player
        $this->sqlQueries[] = 'UPDATE cup_player SET `won` = `won` + 1 WHERE id_cup_player='.$vote.'';

        // add point to losing player
        if ($player1 == $vote) {
            $this->sqlQueries[] = 'UPDATE cup_player SET `lost` = `lost` + 1 WHERE id_cup_player='.$player2.'';
        }
        if ($player2 == $vote) {
            $this->sqlQueries[] = 'UPDATE cup_player SET `lost` = `lost` + 1 WHERE id_cup_player='.$player1.'';
        }
    }
    
    private function updateBattleResult($player1, $player2, $vote) {
        if ($player1 == $vote) {
            $this->sqlQueries[] = 'UPDATE cup_battle SET `score1` = `score1` + 1 WHERE id_cup_battle="'.$this->currentBattleDate.'"';
        }
        if ($player2 == $vote) {
            $this->sqlQueries[] = 'UPDATE cup_battle SET `score2` = `score2` + 1 WHERE id_cup_battle="'.$this->currentBattleDate.'"';
        }
    }
    
    private function commit() {
        foreach ($this->sqlQueries as $sql) {
            $this->db->execute($sql);
        }
    }
    
    private function clearCurrentBattleCache() {
        $currentBattleFile = $this->cupCachePath . '/battles/' . $this->currentBattleDate;
        if (file_exists($currentBattleFile)) {
            unlink($currentBattleFile);
        }
    }

    private function clearAllBattlesCache() {
        $allBattlesFile = $this->cupCachePath . '/all-battles';
        if (file_exists($allBattlesFile)) {
            unlink($allBattlesFile);
        }
    }
}

