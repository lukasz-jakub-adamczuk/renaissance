<?php
require_once AYA_DIR.'/Core/View.php';

// terminarz

class CupShowBattlesView extends View {

    public function fill() {
        // old page urls
        $sId = isset($_GET['id']) ? $_GET['id'] : null;

        // new page urls
        $nameSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));

        if ($sId) {
            $oEntity = Dao::entity('cup', $sId);
            
            $aObject = $oEntity->getFields();

            $categorySlug = $oEntity->getField('slug');
            $categoryName = $oEntity->getField('name');
        }

        if ($categorySlug) {
            $sCupDirectory = CACHE_DIR . '/cup/' . $categorySlug;
            if (!file_exists($sCupDirectory)) {
                mkdir($sCupDirectory, 0777, true);
            }

            // require_once APP_DIR.'/helpers/CupManager.php';
                
            // $cupManager = new CupManager(array('slug' => ));

            // $aBattles = $cupManager->getAllBattles();

            // all battles
            $sAllBattlesFile = $sCupDirectory . '/all-battles';
            if (file_exists($sAllBattlesFile)) {
                $aBattles = unserialize(file_get_contents($sAllBattlesFile));
            } else {
                // fetch battles
                $collection = Dao::collection('cup-battle');
                $aBattles = $collection->getBattles($categorySlug);

                file_put_contents($sAllBattlesFile, serialize($aBattles));
            }

            // $sAllBattlesKeysFile = $sCupDirectory . '/all-battles-keys';
            // if (file_exists($sAllBattlesKeysFile)) {
            //     $aBattlesKeys = unserialize(file_get_contents($sAllBattlesKeysFile));
            // } else {
            //     $aBattlesKeys = array_keys($aBattles);

            //     file_put_contents($sAllBattlesKeysFile, serialize($aBattlesKeys));
            // }

            // echo '<pre>';
            // print_r($aBattles);
            // echo '</pre>';
            // print_r($aBattlesKeys);

            // headers
            if ($sId) {
                header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('cup').'/'.$categorySlug.'/terminarz', TRUE, 301);
            }

            // category name
            $this->_renderer->assign('sCategoryName', $categoryName);

            // title
            $this->_renderer->assign('title', 'Squarezone - Mistrzostwa - '.$categoryName.' - Terminarz');

            // breadcrumbs
            $aItem = array(
                'url' => ValueMapper::getUrl('cup').'/'.$categorySlug,
                'text' => $categoryName
            );
            Breadcrumbs::add($aItem);

            // defaults for matches
            // $aDefaults = array(
            //     '48' => array('1A', '2B'),
            //     '49' => array('1C', '2D'),
            //     '50' => array('1B', '2A'),
            //     '51' => array('1D', '2C'),
            //     '52' => array('1E', '2F'),
            //     '53' => array('1G', '2H'),
            //     '54' => array('1F', '2E'),
            //     '55' => array('1H', '2G'),

            //     '56' => array('W49', 'W50'),
            //     '57' => array('W53', 'W54'),
            //     '58' => array('W51', 'W52'),
            //     '59' => array('W55', 'W56'),
                
            //     '60' => array('W57', 'W58'),
            //     '61' => array('W59', 'W60'),

            //     '62' => array('L61', 'L62'),
            //     '63' => array('W61', 'W62')
            // );

            // if ($_SERVER['REMOTE_ADDR'] == '89.64.24.64') {
            //     echo '<pre>battles';
            //     echo $sAllBattlesFile;
            //     print_r($aBattles);
                
            //     if (file_exists($sAllBattlesFile)) {
            //         echo 'file exists';
            //         $aBattles = unserialize(file_get_contents($sAllBattlesFile));
            //     }
            //     echo 'from cache';
            //     print_r($aBattles);
                
            //     print_r($aBattles);
            //     // print_r($aDefaults);
            //     // print_r(array_flip($aBattlesKeys));
            //     echo '</pre>';
            // }

            require_once APP_DIR.'/helpers/CupManager.php';
                
            $cupManager = new CupManager();

            $this->_renderer->assign('aDefaults', $cupManager->getCupPhaseDefaults());

            $this->_renderer->assign('aBattles', $aBattles);
            // $this->_renderer->assign('aBattles', array_reverse($aBattles));
            // $this->_renderer->assign('navigator', $collection->getNavigator());

            // $this->_renderer->assign('aDefaults', $aDefaults);
            // $this->_renderer->assign('aBattlesKeysFlipped', array_flip($aBattlesKeys));
        }
    }
}