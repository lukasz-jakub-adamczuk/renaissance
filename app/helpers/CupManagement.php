<?php
// $oDb = Db::getInstance();
$oDb = null;

// current match
$sMatchDate = date('Y-m-d');
// $sMatchDate = '2015-07-05';

$oDate = date_create($sMatchDate);
date_modify($oDate, '-1day');

$sLastDate = date_format($oDate, 'Y-m-d');

// what tournament
if (date('Y') % 2 == 0) {
    $sTournamentSlug = '/heroine-cup-' . date('Y');
} else {
    $sTournamentSlug = '/hero-cup-' . date('Y');
}

$sCupCachePath = CACHE_DIR . '/cup' . $sTournamentSlug;

// directories
$sStatsFile = $sCupCachePath . '/stats';
if (!file_exists($sStatsFile)) {
    mkdir($sStatsFile, 0777, true);
}
$sMatchesFile = $sCupCachePath . '/matches';
if (!file_exists($sMatchesFile)) {
    mkdir($sMatchesFile, 0777, true);
}
$sWinnersFile = $sCupCachePath . '/winners';
if (!file_exists($sWinnersFile)) {
    mkdir($sWinnersFile, 0777, true);
}
$sPlayersFile = $sCupCachePath . '/players';
if (!file_exists($sPlayersFile)) {
    mkdir($sPlayersFile, 0777, true);
}

// broken matches and points fix
/*
$sql = 'SELECT cp.id_cup_player, cp.battles
        FROM cup_player cp
        WHERE cp.id_cup="10"
            AND cp.battles > 3';

$oCollection = Dao::collection('cup-player');
$oCollection->query($sql);
$aResult = $oCollection->getRows();

foreach ($aResult as $pk => $player) {
    $iPlayer1 = $pk;

    $sql = 'SELECT 
                id_cup_battle,
                SUM(IF(id_cup_battle, 1, 0)) AS matches,
                SUM(IF((player1 = '.$iPlayer1.' AND score1 > score2) OR (player2 = '.$iPlayer1.' AND score1 < score2), 3, 0)) AS wins, 
                SUM(IF(score1 = score2, 1, 0)) AS draws
            FROM cup_battle
            WHERE (player1 = '.$iPlayer1.'
                OR player2 = '.$iPlayer1.')
            AND id_cup_battle < "2015-06-18"';

    $oCollection = Dao::collection('cup-battle');
    $oCollection->query($sql);
    $aResult = $oCollection->getRows();

    $aStats = current($aResult);

    // update player1 stats
    if (isset($aStats['matches']) && isset($aStats['wins']) && isset($aStats['draws'])) {
        $sql = 'UPDATE cup_player
                SET battles='.$aStats['matches'].', points='.($aStats['wins'] + $aStats['draws']).'
                WHERE id_cup_player='.$iPlayer1.'
                ';

        if ($oDb->execute($sql)) {
            $sStatsInfo = 'Stats for Player1 were updated'."\n";
        }
    }
}
*/

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

    file_put_contents($sAllBattlesKeysFile, serialize($aBattlesKeys));
}

$aBattlesKeysFlipped = array_flip($aBattlesKeys);

if ($aBattlesKeysFlipped) {
    // last match
    $sStatsFile = $sCupCachePath . '/stats/' . $sLastDate;
    if (file_exists($sStatsFile)) {
        // nothing
    } else {
        // players can be find in cache for last match
        $sPlayersFile = $sCupCachePath . '/matches/' . $sLastDate;
        if (file_exists($sPlayersFile)) {
            $aResult = unserialize(file_get_contents($sPlayersFile));
        } else {
            $sql = 'SELECT id_cup_battle, player1, player2 FROM cup_battle WHERE id_cup_battle = "'.$sLastDate.'"';
        
            $oCollection = Dao::collection('cup-battle');
            $oCollection->query($sql);
            $aResult = $oCollection->getRows();
        }

        // players
        if (isset($aResult)) {
            $aPlayers = current($aResult);

            $iPlayer1 = $aPlayers['player1'];
            $iPlayer2 = $aPlayers['player2'];
        }

        $sStatsInfo = '';

        // $aBattlesKeysFlipped[$sLastDate];

        // only group phase
        if (isset($aBattlesKeysFlipped[$sLastDate]) && $aBattlesKeysFlipped[$sLastDate] < 48) {
            // player1 stats
            $sql = 'SELECT 
                        id_cup_battle,
                        SUM(IF(id_cup_battle, 1, 0)) AS matches,
                        SUM(IF((player1 = '.$iPlayer1.' AND score1 > score2) OR (player2 = '.$iPlayer1.' AND score1 < score2), 3, 0)) AS wins, 
                        SUM(IF(score1 = score2, 1, 0)) AS draws
                    FROM cup_battle
                    WHERE (player1 = '.$iPlayer1.'
                        OR player2 = '.$iPlayer1.')
                    AND id_cup_battle < "'.$sMatchDate.'"';
            
            $oCollection = Dao::collection('cup-battle');
            $oCollection->query($sql);
            $aResult = $oCollection->getRows();

            $aStats = current($aResult);

            // update player1 stats
            if (isset($aStats['matches']) && isset($aStats['wins']) && isset($aStats['draws'])) {
                $sql = 'UPDATE cup_player
                        SET battles='.$aStats['matches'].', points='.($aStats['wins'] + $aStats['draws']).'
                        WHERE id_cup_player='.$iPlayer1.'
                        ';

                if ($oDb->execute($sql)) {
                    $sStatsInfo = 'Stats for Player1 were updated'."\n";
                }
            }

            // player2 stats
            $sql = 'SELECT 
                        id_cup_battle,
                        SUM(IF(id_cup_battle, 1, 0)) AS matches,
                        SUM(IF((player2 = '.$iPlayer2.' AND score1 < score2) OR (player1 = '.$iPlayer2.' AND score1 > score2), 3, 0)) AS wins, 
                        SUM(IF(score1 = score2, 1, 0)) AS draws
                    FROM cup_battle
                    WHERE (player2 = '.$iPlayer2.'
                        OR player1 = '.$iPlayer2.')
                    AND id_cup_battle < "'.$sMatchDate.'"';
            
            $oCollection = Dao::collection('cup-battle');
            $oCollection->query($sql);
            $aResult = $oCollection->getRows();

            $aStats = current($aResult);

            // update player2 stats
            if (isset($aStats['matches']) && isset($aStats['wins']) && isset($aStats['draws'])) {
                $sql = 'UPDATE cup_player
                        SET battles='.$aStats['matches'].', points='.($aStats['wins'] + $aStats['draws']).'
                        WHERE id_cup_player='.$iPlayer2.'
                        ';

                if ($oDb->execute($sql)) {
                    $sStatsInfo = 'Stats for Player2 were updated'."\n";
                }
            }
        }

        file_put_contents($sStatsFile, $sStatsInfo);
    }

    // current match
    $sMatchFile = $sCupCachePath . '/matches/' . $sMatchDate;
    if (file_exists($sMatchFile)) {
        $aMatch = unserialize(file_get_contents($sMatchFile));
    } else {
        $sql = 'SELECT cb.*, c.slug cup_slug, cp1.name as player1_name, cp2.name AS player2_name, cp1.slug as player1_slug, cp2.slug AS player2_slug
                FROM cup_battle cb 
                LEFT JOIN cup c ON(c.id_cup=cb.id_cup)
                LEFT JOIN cup_player cp1 ON(cp1.id_cup_player=cb.player1)
                LEFT JOIN cup_player cp2 ON(cp2.id_cup_player=cb.player2)
                WHERE cb.id_cup_battle="'.$sMatchDate.'"
                ';

        $oCollection = Dao::collection('cup-battle');
        $oCollection->query($sql);

        $aMatch = $oCollection->getRows();

        file_put_contents($sMatchFile, serialize($aMatch));
    }

    // assign match details to templates
    if (count($aMatch) == 1) {
        $this->_renderer->assign('aMatch', current($aMatch));
    }

    // voting access
    if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {

        $sUserId = $_SESSION['user']['id'];
            
        $mYourVote = $oDb->getOne('SELECT * FROM cup_vote WHERE id_user='.$sUserId.' AND voting_date="'.$sMatchDate.'"');

        // print_r($mYourVote);

        if ($mYourVote) {
            $this->_renderer->assign('canVote', false);
        } else {
            $this->_renderer->assign('canVote', true);
        }
        // $this->_renderer->assign('canVote', true);
    }

    // cup phase
    $sWinnersFile = $sCupCachePath . '/winners/' . $sLastDate;
    if (file_exists($sWinnersFile)) {
        // nothing
        // $aStats = unserialize(file_get_contents($sStatsFile));
    } else {
        $sql = 'SELECT id_cup_player, `group`, battles, points, won, lost
                FROM `cup_player`
                WHERE id_cup=(SELECT MAX(id_cup) FROM cup)
                ORDER BY `group` ASC, battles DESC, points DESC, won DESC, lost ASC
                ';

        $oCollection = Dao::collection('cup-player');
        $oCollection->query($sql);

        $aPlayers = $oCollection->getRows();

        // print_r($aPlayers);

        $aGroups = array();

        // analyze players
        foreach ($aPlayers as $pk => $player) {
            if ($player['battles'] == 3) {
                $aGroups[$player['group']][] = $player;
            }
        }

        $aWinners = array();
        
        // analyze groups
        foreach ($aGroups as $group) {
            if (count($group) == 4) {
                foreach ($group as $pk => $player) {
                    if ($pk == 0 || $pk == 1) {
                        $aWinners[($pk + 1).strtoupper($player['group'])] = $player['id_cup_player'];
                    }
                }
            }
        }

        // find cup phase winners
        $sql = 'SELECT *
                FROM `cup_battle`
                WHERE id_cup=(SELECT MAX(id_cup) FROM cup)
                ORDER BY id_cup_battle
                LIMIT 48,64
                ';

        $oCollection = Dao::collection('cup-battle');
        $oCollection->query($sql);

        $aBattles = $oCollection->getRows();

        foreach ($aBattles as $bk =>$battle) {
            if (date_create($battle['id_cup_battle']) < date_create($sMatchDate)) {
                if ($battle['score1'] > $battle['score2']) {
                    $aWinners['W'.($aBattlesKeysFlipped[$bk]+1)] = $battle['player1'];
                    $aWinners['L'.($aBattlesKeysFlipped[$bk]+1)] = $battle['player2'];
                }
                if ($battle['score1'] < $battle['score2']) {
                    $aWinners['W'.($aBattlesKeysFlipped[$bk]+1)] = $battle['player2'];
                    $aWinners['L'.($aBattlesKeysFlipped[$bk]+1)] = $battle['player1'];
                }
            }
        }

        // print_r($aWinners);
        file_put_contents($sWinnersFile, serialize($aWinners));    

        // defaults for matches
        $aDefaults = array(
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

        $aSql = array();

        // set winner asset to cup description
        if (isset($aWinners['W63'])) {
            $sql = 'SELECT *
                    FROM `cup`
                    WHERE id_cup=(SELECT MAX(id_cup) FROM cup)
                    ';

            $oCollection = Dao::collection('cup');
            $oCollection->query($sql);

            $aCupDetails = $oCollection->getRows();
            
            // prepare sql
            if (count($aCupDetails) == 1) {
                $aCupInfo = current($aCupDetails);
                
                $sDescription = '/assets/cup/'.$aCupInfo['slug'].'/'.$aWinners['W63'].'.jpg';
                $aSql[] =  'UPDATE cup SET `description`="'.$sDescription.'" WHERE id_cup='.$aCupInfo['id_cup'].'';
            }
        }

        
        // check all cup phase winners and set if needed
        foreach ($aDefaults as $bk => $battle) {
            $aFields = array();

            foreach ($battle as $pk => $player) {
                $sPlayersFile = $sCupCachePath . '/players/' . $player;
                if (file_exists($sPlayersFile)) {
                    // nothing
                } else {
                    if (isset($aWinners[$player])) {
                        $aFields[] = 'player'.($pk+1).'='.$aWinners[$player];
                        file_put_contents($sPlayersFile, serialize($player));
                    }
                }
            }
            if (count($aFields)) {
                $sql = 'UPDATE cup_battle
                        SET '.implode(', ', $aFields).'
                        WHERE id_cup_battle="'.$aBattlesKeys[$bk].'"';

                $aSql[] = $sql;
            }
        }
        // print_r($aSql);


        // execute quaries
        $Db = Db::getInstance();

        // print_r($aSql);
        // foreach ($aSql as $sql) {
        //     $oDb->execute($sql);
        // }

        // clear cup battles cache
        $sAllBattlesFile = $sCupCachePath . '/all-battles';
        if (file_exists($sAllBattlesFile)) {
            unlink($sAllBattlesFile);
        }
    }

}