<?php
require_once AYA_DIR.'/Core/View.php';

class CupInfoView extends View {

    public function fill() {
        // old page urls
        $sId = isset($_GET['id']) ? $_GET['id'] : null;

        // old page urls
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));
        $nameSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

        if ($sId) {
            $sql = 'SELECT cp.*, c.name category_name, c.slug category_slug
                    FROM cup_player cp
                    LEFT JOIN cup c ON (c.id_cup=cp.id_cup)
                    WHERE cp.id_cup_player="'.$sId.'"';
        } else {
            $sql = 'SELECT cp.*
                    FROM cup_player cp
                    LEFT JOIN cup c ON (c.id_cup=cp.id_cup)
                    WHERE c.slug="'.$categorySlug.'" AND cp.slug="'.$nameSlug.'"';
        }


        $oEntity = Dao::entity('cup-player');
        $oEntity->query($sql);

        $aObject = $oEntity->getFields();

        // headers
        if ($sId) {
            $categorySlug = $oEntity->getField('category_slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('cup').'/'.$categorySlug.'/'.$oEntity->getField('slug'), TRUE, 301);
        }

        if ($aObject) {
            // category name
            $this->_renderer->assign('sCategoryName', $categoryName);

            // title
            $this->_renderer->assign('title', 'Squarezone - Mistrzostwa - '.$categoryName.' - '.$oEntity->getField('name'));

            // breadcrumbs
            $aItem = array(
                'url' => ValueMapper::getUrl('cup').'/'.$categorySlug,
                'text' => $categoryName
            );
            Breadcrumbs::add($aItem);

            $this->_renderer->assign('aPlayer', $aObject);
            // $this->_renderer->assign('navigator', $oEntity->getNavigator());
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);
        }
    }
}