<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\Logger;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\Text;
use Aya\Helper\ValueMapper;

class PageInfoView extends View {

    public function fill() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $slug = isset($_GET['slug']) ? strip_tags($_GET['slug']) : null;

        $titles = [
            'redakcja' => 'Redakcja',
            'kontakt' => 'Kontakt',
            'polityka-prywatnosci' => 'Polityka prywatności',
            'zasady-oceniania' => 'Zasady oceniania',
            'konkurs-cenega-the-last-remnant' => 'Konkurs Cenega The Last Remnant',
            'konkurs-cenega-final-fantasy-xiii' => 'Konkurs Cenega Final Fantasy XIII'
        ];

        // mappings
        $redirects = array(
            'redaction' => ValueMapper::getUrl('page').'/redakcja',
            'redaction_details' => ValueMapper::getUrl('user'),
            'redaction_co_details' => ValueMapper::getUrl('user'),
            'about_us' => ValueMapper::getUrl('page').'/kontakt',
            'copyright' => ValueMapper::getUrl('page').'/polityka-prywatnosci',
            'konkurs' => ValueMapper::getUrl('page').'/konkurs-cenega-the-last-remnant',
            'konkurs_final_fantasy_xiii' => ValueMapper::getUrl('page').'/konkurs-cenega-final-fantasy-xiii',
        );
    
        // headers
        if ($url && isset($redirects[$url])) {
            Logger::logStandardRequest('redirects');

            header('Location: '.BASE_URL.'/'.$redirects[$url].'', TRUE, 301);
        } else {
            // log 404
            Logger::logStandardRequest('404');
        }

        if ($slug) {
            // title
            $this->_renderer->assign('title', 'Squarezone - Serwis - ' . $titles[$slug]);

            $page = [];
            $page['title'] = $titles[$slug];

            $pageTemplate = 'page/' . $slug . '.tpl';
            if ($this->_renderer->templateExists($pageTemplate)) {
                $page['content'] = $this->_renderer->fetch($pageTemplate);
            }
            

            $this->_renderer->assign('page', $page);
        }
    }
}