<?php
require_once AYA_DIR.'/Core/View.php';

class PageInfoView extends View {

    public function fill() {
        $sUrl = isset($_GET['url']) ? $_GET['url'] : null;

        // mappings
        $aRedirections = array(
            'redaction' => ValueMapper::getUrl('page').'/redakcja',
            'redaction_details' => ValueMapper::getUrl('user'),
            'redaction_co_details' => ValueMapper::getUrl('user'),
            'about_us' => ValueMapper::getUrl('page').'/kontakt',
            'copyright' => ValueMapper::getUrl('page').'/polityka-prywatnosci',
            'konkurs' => ValueMapper::getUrl('page').'/konkurs/cenega-the-last-remnant',
            'konkurs_final_fantasy_xiii' => ValueMapper::getUrl('page').'/konkurs/final-fantasy-xiii',
        );
    
        // headers
        if ($sUrl && isset($aRedirections[$sUrl])) {
            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.$aRedirections[$sUrl].'', TRUE, 301);
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);
        }
    }
}