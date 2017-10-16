<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

class CupInfoView extends View {

    public function fill() {
        // old page urls
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        // old page urls
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));
        $nameSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

        $cupPlayerEntity = Dao::entity('cup-player');

        if ($id) {
            $cupPlayer = $cupPlayerEntity->getCupPlayerByOldUrl($id);
        } else {
            $cupPlayer = $cupPlayerEntity->getCupPlayer($categorySlug, $nameSlug);
        }

        // headers
        if ($id) {
            $categorySlug = $cupPlayerEntity->getField('category_slug');

            $this->redirect(BASE_URL.'/'.ValueMapper::getUrl('cup').'/'.$categorySlug.'/'.$cupPlayerEntity->getField('slug'));
        }

        // category name
        $this->_renderer->assign('categoryName', $categoryName);

        // title
        $this->_renderer->assign('title', 'Squarezone - Mistrzostwa - '.$categoryName.' - '.$cupPlayerEntity->getField('name'));

        // breadcrumbs
        $item = array(
            'url' => ValueMapper::getUrl('cup').'/'.$categorySlug,
            'text' => $categoryName
        );
        Breadcrumbs::add($item);

        $this->_renderer->assign('aPlayer', $cupPlayer);
        // $this->_renderer->assign('navigator', $cupPlayerEntity->getNavigator());
    }
}