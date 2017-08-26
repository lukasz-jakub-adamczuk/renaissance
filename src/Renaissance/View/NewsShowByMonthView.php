<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\ValueMapper;
use Aya\Helper\Breadcrumbs;

class NewsShowByMonthView extends View {

    public function fill() {
        $year = $_GET['year'];
        $month = $_GET['month'];

        // breadcrumbs
        $item = [
            'url' => ValueMapper::getUrl('news').'/'.$year,
            'text' => $year
        ];
        Breadcrumbs::add($item);

        // print_r($_SERVER['REQEST_']);

        // collection
        $newsCollection = Dao::collection('news');

        $this->_renderer->assign('entries', $newsCollection->getNewsByMonth($year, $month));
        $this->_renderer->assign('navigator', $newsCollection->getNavigator());
    }
}