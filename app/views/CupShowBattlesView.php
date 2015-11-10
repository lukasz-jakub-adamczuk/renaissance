<?php
require_once AYA_DIR.'/Core/View.php';

// terminarz

class CupShowBattlesView extends View {

	public function fill() {
		// old page urls
		$sId = isset($_GET['id']) ? $_GET['id'] : null;

		// new page urls
		$sNameSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
		$sCategorySlug = isset($_GET['category']) ? $_GET['category'] : null;
		$sCategoryName = ucwords(str_replace('-', ' ', $sCategorySlug));

		if ($sId) {
			$oEntity = Dao::entity('cup', $sId);
			
			$aObject = $oEntity->getFields();

			$sCategorySlug = $oEntity->getField('slug');
			$sCategoryName = $oEntity->getField('name');
		}

		if ($sCategorySlug) {
			$sCupDirectory = CACHE_DIR . '/cup/' . $sCategorySlug;
			if (!file_exists($sCupDirectory)) {
				mkdir($sCupDirectory, 0777, true);
			}

			// all battles
			$sAllBattlesFile = $sCupDirectory . '/all-battles';
			if (file_exists($sAllBattlesFile)) {
				$aBattles = unserialize(file_get_contents($sAllBattlesFile));
			} else {
				$sql = 'SELECT cb.*, cp1.name name1, cp2.name name2, cp1.slug slug1, cp2.slug slug2
						FROM cup_battle cb
						LEFT JOIN cup c ON (c.id_cup=cb.id_cup)
						LEFT JOIN cup_player cp1 ON (cp1.id_cup_player=cb.player1)
						LEFT JOIN cup_player cp2 ON (cp2.id_cup_player=cb.player2)
						WHERE c.slug="'.$sCategorySlug.'"
						ORDER BY cb.id_cup_battle';

				// fetch battles
				$oCollection = Dao::collection('cup-battle');
				$oCollection->query($sql);

				$aBattles = $oCollection->getRows();

				file_put_contents($sAllBattlesFile, serialize($aBattles));
			}

			$sAllBattlesKeysFile = $sCupDirectory . '/all-battles-keys';
			if (file_exists($sAllBattlesKeysFile)) {
				$aBattlesKeys = unserialize(file_get_contents($sAllBattlesKeysFile));
			} else {
				$aBattlesKeys = array_keys($aBattles);

				file_put_contents($sAllBattlesKeysFile, serialize($aBattlesKeys));
			}

			// print_r($aBattles);
			// print_r($aBattlesKeys);

			// headers
			if ($sId) {
				header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('cup').'/'.$sCategorySlug.'/terminarz', TRUE, 301);
			}

			// category name
			$this->_oRenderer->assign('sCategoryName', $sCategoryName);

			// title
			$this->_oRenderer->assign('sTitle', 'Squarezone - Mistrzostwa - '.$sCategoryName.' - Terminarz');

			// breadcrumbs
			$aItem = array(
				'url' => ValueMapper::getUrl('cup').'/'.$sCategorySlug,
				'text' => $sCategoryName
			);
			Breadcrumbs::add($aItem);

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

			$this->_oRenderer->assign('aBattles', $aBattles);
			// $this->_oRenderer->assign('aNavigator', $oCollection->getNavigator());

			$this->_oRenderer->assign('aDefaults', $aDefaults);
			$this->_oRenderer->assign('aBattlesKeysFlipped', array_flip($aBattlesKeys));
		}
	}
}