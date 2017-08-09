<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

class PageInfoView extends View {

    public function fill() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;

        // mappings
        $redirects = array(
            'redaction' => ValueMapper::getUrl('page').'/redakcja',
            'redaction_details' => ValueMapper::getUrl('user'),
            'redaction_co_details' => ValueMapper::getUrl('user'),
            'about_us' => ValueMapper::getUrl('page').'/kontakt',
            'copyright' => ValueMapper::getUrl('page').'/polityka-prywatnosci',
            'konkurs' => ValueMapper::getUrl('page').'/konkurs/cenega-the-last-remnant',
            'konkurs_final_fantasy_xiii' => ValueMapper::getUrl('page').'/konkurs/final-fantasy-xiii',
        );
    
        // headers
        if ($url && isset($redirects[$url])) {
            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            // Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.$redirects[$url].'', TRUE, 301);
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            // Logger::logStandardRequest($sLogFile);
        }
    }
}