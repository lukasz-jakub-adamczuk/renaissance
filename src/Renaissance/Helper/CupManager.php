<?php

namespace Renaissance\Helper;

use Aya\Core\Dao;
use Aya\Core\Db;

class CupManager {

    private $db;
    
    private $cupCachePath;

    private $tournamentSlug;
    
    private $currentBattleDate;
    
    private $lastBattleDate;

    private $allBattlesKeys;

    private $allBattlesKeysFlipped;
    
    private $sqlQueries;
    
    public function __construct() {
        $this->db = Db::getInstance();
        
        $this->currentBattleDate = date('Y-m-d');

        $oDate = date_create($this->currentBattleDate);
        date_modify($oDate, '-1day');

        $this->lastBattleDate = date_format($oDate, 'Y-m-d');

        if (date('Y') % 2 == 0) {
            $this->tournamentSlug = 'heroine-cup-' . date('Y');
        } else {
            $this->tournamentSlug = 'hero-cup-' . date('Y');
        }

        $this->cupCachePath = CACHE_DIR . '/cup/' . $this->tournamentSlug;

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

        $this->allBattlesKeys = $this->getAllBattlesKeys();
        $this->allBattlesKeysFlipped = array_flip($this->allBattlesKeys);

        $this->sqlQueries = [];
    }

    public function validatePlayersStats($validationDate = null) {
        $date = $this->currentBattleDate;
        if ($validationDate) {
            $date = $validationDate;
        }
        // stats should be validated for group phase only
        $collection = Dao::collection('cup-player');
        $players = $collection->getPlayersFromLatestCup();

        foreach ($players as $player) {
            $computedStats = $this->getPlayerStats($player['id_cup_player'], $date);

            echo '<h2>'.$player['id_cup_player'].'</h2>';
            echo '<img src="http://squarezone.pl/assets/cup/'.$this->tournamentSlug.'/'.$player['id_cup_player'].'m.jpg" width="50" height="50">';

            $fields = [];
            if ($player['battles'] != $computedStats['matches']) {
                $bg = 'red';
                $fields[] = 'battles='.$computedStats['matches'];
            } else {
                $bg = '#080';
            }
            echo '<p style="width: 320px; background: '.$bg.';">Battles: is '.$player['battles'].', should be '.$computedStats['matches'].'</p>';

            $points = $computedStats['wins'] + $computedStats['draws'];
            if ($player['points'] != $points) {
                $bg = 'red';
                $fields[] = 'points='.$points;
            } else {
                $bg = '#080';
            }
            echo '<p style="width: 320px; background: '.$bg.';">Points: is '.$player['points'].', should be '.$points.'</p>';

            if ($player['won'] != $computedStats['won']) {
                $bg = 'red';
                $fields[] = 'won='.$computedStats['won'];
            } else {
                $bg = '#080';
            }
            echo '<p style="width: 320px; background: '.$bg.';">Won: is '.$player['won'].', should be '.$computedStats['won'].'</p>';

            if ($player['lost'] != $computedStats['lost']) {
                $bg = 'red';
                $fields[] = 'lost='.$computedStats['lost'];
            } else {
                $bg = '#080';
            }
            echo '<p style="width: 320px; background: '.$bg.';">Lost: is '.$player['lost'].', should be '.$computedStats['lost'].'</p>';

            if (count($fields)) {
                $sql = 'UPDATE cup_player
                        SET '.implode(', ', $fields).'
                        WHERE id_cup_player="'.$player['id_cup_player'].'"';

                $this->sqlQueries[] = $sql;
            }
        }
        
        $this->commit();
        
        $this->clearAllBattlesCache();
    }
    
    public function manageCalculationProcess() {
        if ($this->isTournamentFinished()) {
            $this->setTournamentWinner();
            return false;
        }
        if ($this->isGroupPhaseMatch()) {
            $battleDetails = $this->getBattleDetails($this->lastBattleDate);
            
            if (isset($battleDetails)) {
                $aPlayers = current($battleDetails);

                $player1 = $aPlayers['player1'];
                $player2 = $aPlayers['player2'];
            
                $player1Stats = $this->getPlayerStats($player1, $this->currentBattleDate);
                $this->updatePlayerStats($player1, $player1Stats);
                
                $player2Stats = $this->getPlayerStats($player2, $this->currentBattleDate);
                $this->updatePlayerStats($player2, $player2Stats);
            }
        }
        
        // cup phase
        $winnersFile = $this->cupCachePath . '/winners/' . $this->lastBattleDate;

        $winners = [];
        if (!file_exists($winnersFile)) {
            $collection = Dao::collection('cup-player');
            $players = $collection->getPlayersFromLatestCup();
            
            $groups = [];

            // grouping players
            foreach ($players as $pk => $player) {
                if ($player['battles'] == 3) {
                    $groups[$player['group']][] = $player;
                }
            }

            // only 1st and 2nd player are winners
            foreach ($groups as $group) {
                if (count($group) == 4) {
                    foreach ($group as $pk => $player) {
                        if ($pk == 0 || $pk == 1) {
                            $winners[($pk + 1).strtoupper($player['group'])] = $player['id_cup_player'];
                        }
                    }
                }
            }
            
            $collection = Dao::collection('cup-battle');

            $battles = $collection->getCupPhaseBattles();

            // extend winners by cup phase players
            foreach ($battles as $bk =>$battle) {
                if (date_create($battle['id_cup_battle']) < date_create($this->currentBattleDate)) {
                    if ($battle['score1'] > $battle['score2']) {
                        $winners['W'.($this->allBattlesKeysFlipped[$bk]+1)] = $battle['player1'];
                        $winners['L'.($this->allBattlesKeysFlipped[$bk]+1)] = $battle['player2'];
                    }
                    if ($battle['score1'] < $battle['score2']) {
                        $winners['W'.($this->allBattlesKeysFlipped[$bk]+1)] = $battle['player2'];
                        $winners['L'.($this->allBattlesKeysFlipped[$bk]+1)] = $battle['player1'];
                    }
                }
            }

            // defaults for cup phase battles
            $defaultBattles = $this->getCupPhaseDefaults();
            
            // check all cup phase winners and set if needed
            foreach ($defaultBattles as $bk => $battle) {
                $fields = [];

                foreach ($battle as $pk => $player) {
                    $playersFile = $this->cupCachePath . '/players/' . $player;
                    if (file_exists($playersFile)) {
                        if (isset($winners[$player])) {
                            // winner for cup phase battle
                            $fields[] = 'player'.($pk+1).'='.$winners[$player];
                            file_put_contents($playersFile, serialize($player));
                        }
                        
                    }
                }
                if (count($fields)) {
                    $sql = 'UPDATE cup_battle
                            SET '.implode(', ', $fields).'
                            WHERE id_cup_battle="'.$this->allBattlesKeys[$bk].'"';

                    $this->sqlQueries[] = $sql;
                }
            }
            
            $this->commit();
            
            $this->clearAllBattlesCache();
            
            file_put_contents($winnersFile, serialize($winners));
        }
    }
    
    public function manageVotingProcess($userId, $player1, $player2, $vote) {
        $this->registerUserVote($userId, $this->currentBattleDate);
        
        if ($this->isGroupPhaseMatch()) {
            $this->updatePlayersStats($player1, $player2, $vote);
        }

        $this->updateBattleResult($player1, $player2, $vote);

        $this->commit();
        
        $this->clearCurrentBattleCache();
        $this->clearAllBattlesCache();
    }

    public function getAllBattles() {
        $allBattlesFile = $this->cupCachePath . '/all-battles';
        
        if (file_exists($allBattlesFile)) {
            $allBattles = unserialize(file_get_contents($allBattlesFile));
        } else {
            $collection = Dao::collection('cup-battle');
            $allBattles = $collection->getBattles($this->tournamentSlug);
            
            file_put_contents($allBattlesFile, serialize($allBattles));
        }
        
        return $allBattles;
    }
    
    public function getAllBattlesKeys() {
        $allBattlesKeysFile = $this->cupCachePath . '/all-battles-keys';
        
        if (file_exists($allBattlesKeysFile)) {
            $allBattlesKeys = unserialize(file_get_contents($allBattlesKeysFile));
        } else {
            $allBattles = $this->getAllBattles();
            
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
            $collection = Dao::collection('cup-battle');
            $currentBattle = $collection->getCupBattle($this->currentBattleDate);

            file_put_contents($currentBattleFile, serialize($currentBattle));
        }

        if (count($currentBattle) === 1) {
            return current($currentBattle);
        }
        
        return false;
    }

    public function setTournamentWinner() {
        $tournamentWinnerFile = $this->cupCachePath . '/cup-winner-set';
        if (file_exists($tournamentWinnerFile)) {
            return false;
        }

        $finalBattle = $this->getBattleDetails(end($this->allBattlesKeys));
        if (is_array($finalBattle) && count($finalBattle) == 1) {
            $details = current($finalBattle);
            
            if ($details['score1'] > $details['score2']) {
                $winner = $details['player1'];
            }
            if ($details['score1'] < $details['score2']) {
                $winner = $details['player2'];
            }
            if (isset($winner)) {
                $description = '/assets/cup/'.$this->tournamentSlug.'/'.$winner.'.jpg';

                // $entity = Dao::entity('cup', 12);
                // $entity->setField('description', $description);
                // $entity->update();
                
                $sql = 'UPDATE cup
                        SET description="'.$description.'"
                        WHERE slug="'.$this->tournamentSlug.'"';
                $this->sqlQueries[] = $sql;

                $this->commit();

                // winner set
                file_put_contents($tournamentWinnerFile, '');

                // finish tournament
                $tournamentFinishedFile = $this->cupCachePath . '/cup-finished';
                file_put_contents($tournamentFinishedFile, '');
            }
        }
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

    public function getCupPhaseDefaults() {
        $defaultBattles = array(
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
        return $defaultBattles;
    }

    public function isTournamentFinished() {
        $tournamentFinishedFile = $this->cupCachePath . '/cup-finished';
        if (file_exists($tournamentFinishedFile)) {
            return true;
        }
        if ($this->currentBattleDate > end($this->allBattlesKeys)) {
            file_put_contents($tournamentFinishedFile, '');
            return true;
        }
        return false;
    }
    
    private function getBattleDetails($battleDate) {
        $battleFile = $this->cupCachePath . '/battles/' . $battleDate;
        if (file_exists($battleFile)) {
            $battleDetails = unserialize(file_get_contents($battleFile));
        } else {
            $collection = Dao::collection('cup-battle');
            $battleDetails = $collection->getCupBattle($battleDate);
        }
        
        return $battleDetails;
    }
    
    private function registerUserVote($userId, $BattleDate) {
        $this->sqlQueries[] = 'INSERT INTO cup_vote(id_cup_vote, id_user, voting_date) VALUES (NULL, '.$userId.', "'.$BattleDate.'")';
    }
    
    private function getPlayerStats($player, $battleDate) {
        $collection = Dao::collection('cup-battle');
        $stats = $collection->getPlayerRecentStats($player, $battleDate);
        
        return current($stats);
    }
    
    private function updatePlayerStats($player, $stats) {
        $playerStatsFile = $this->cupCachePath . '/stats/' . $this->lastBattleDate;
        if (isset($stats['matches']) && isset($stats['wins']) && isset($stats['draws'])) {
            $sql = 'UPDATE cup_player
                    SET battles='.$stats['matches'].', points='.($stats['wins'] + $stats['draws']).'
                    WHERE id_cup_player='.$player.'
                    ';

            if ($this->db->execute($sql)) {
                $statsInfo = 'Stats for player#'.$player.' were updated'."\n";
                file_put_contents($playerStatsFile, $statsInfo);
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
            // echo $sql;
            $this->db->execute($sql);
        }
    }

    private function isGroupPhaseMatch() {
        return (isset($this->allBattlesKeysFlipped[$this->currentBattleDate])
                && $this->allBattlesKeysFlipped[$this->currentBattleDate] < 48);
    }
    
    private function clearCurrentBattleCache() {
        $currentBattleFile = $this->cupCachePath . '/battles/' . $this->currentBattleDate;
        if (file_exists($currentBattleFile)) {
            unlink($currentBattleFile);
        }
    }

    private function clearAllBattlesCache() {
        // NOTICE always delete both files
        // keys are defined by all battles
        $allBattlesFile = $this->cupCachePath . '/all-battles';
        if (file_exists($allBattlesFile)) {
            unlink($allBattlesFile);
        }
        $allBattlesFile = $this->cupCachePath . '/all-battles-keys';
        if (file_exists($allBattlesFile)) {
            unlink($allBattlesFile);
        }
    }
}

