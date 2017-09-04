<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class PageIndexView extends View {

    public function fill() {
        $items = [
            'redakcja' => [
                'slug' => 'redakcja',
                'name' => 'Redakcja'
            ],
            'polityka-prywatnosci' => [
                'slug' => 'polityka-prywatnosci',
                'name' => 'Polityka prywatności'
            ],
            'zasady-oceniania' => [
                'slug' => 'zasady-oceniania',
                'name' => 'Zasady oceniania'
            ],
            'kontakt' => [
                'slug' => 'kontakt',
                'name' => 'Kontakt'
            ]
            ];
        
        $this->_renderer->assign('items', $items);
    }
}