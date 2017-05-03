<?php
require_once AYA_DIR.'/Core/View.php';

class CupInfoView extends View {

    public function fill() {
        // old page urls
        $sId = isset($_GET['id']) ? $_GET['id'] : null;

        // old page urls
        $sCategorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $sCategoryName = ucwords(str_replace('-', ' ', $sCategorySlug));
        $sNameSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

        if ($sId) {
            $sql = 'SELECT cp.*, c.name category_name, c.slug category_slug
                    FROM cup_player cp
                    LEFT JOIN cup c ON (c.id_cup=cp.id_cup)
                    WHERE cp.id_cup_player="'.$sId.'"';
        } else {
            $sql = 'SELECT cp.*
                    FROM cup_player cp
                    LEFT JOIN cup c ON (c.id_cup=cp.id_cup)
                    WHERE c.slug="'.$sCategorySlug.'" AND cp.slug="'.$sNameSlug.'"';
        }


        $oEntity = Dao::entity('cup-player');
        $oEntity->query($sql);

        $aObject = $oEntity->getFields();

        // headers
        if ($sId) {
            $sCategorySlug = $oEntity->getField('category_slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('cup').'/'.$sCategorySlug.'/'.$oEntity->getField('slug'), TRUE, 301);
        }

        if ($aObject) {
            // category name
            $this->_renderer->assign('sCategoryName', $sCategoryName);

            // title
            $this->_renderer->assign('sTitle', 'Squarezone - Mistrzostwa - '.$sCategoryName.' - '.$oEntity->getField('name'));

            // breadcrumbs
            $aItem = array(
                'url' => ValueMapper::getUrl('cup').'/'.$sCategorySlug,
                'text' => $sCategoryName
            );
            Breadcrumbs::add($aItem);

            $this->_renderer->assign('aPlayer', $aObject);
            // $this->_renderer->assign('aNavigator', $oEntity->getNavigator());
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);
        }
    }
}