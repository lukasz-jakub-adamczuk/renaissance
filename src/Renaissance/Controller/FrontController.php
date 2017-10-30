<?php
namespace Renaissance\Controller;

use Aya\Core\Dao;
use Aya\Core\Debug;
use Aya\Core\User;
use Aya\Helper\AuthManager;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;
use Aya\Mvc\CrudController;

class FrontController extends CrudController {
    
    public function indexAction() {}

    public function infoAction() {}

    public function beforeAction() {
        parent::beforeAction();
        // decide when to show and hide
        if ($this->_ctrlName != 'home') {
            $item = array(
                'name' => 'ctrl',
                'url' => ValueMapper::getUrl($this->getCtrlName()),
                'text' => ValueMapper::getName($this->getCtrlName()),
            );
            Breadcrumbs::add($item);
        }

        print_r(ValueMapper::allValues());

        $this->_renderer->assign('datetimeFormat', '%Y-%m-%dT%H:%M');

        // title
        $this->_renderer->assign('title', 'Squarezone - '.ValueMapper::getName($this->getCtrlName()));

        // self url used in few places
        $selfUrl = '';
        if (isset($_SERVER['REDIRECT_URL'])) {
            $selfUrl = $_SERVER['REDIRECT_URL'];
        }
        $this->_renderer->assign('self', $selfUrl);

        
        $cosplays = Dao::collection('gallery-image')->getGalleryCosplays();
        $this->_renderer->assign('cosplays', $cosplays);

        $wallpapers = Dao::collection('gallery-image')->getGalleryWallpapers();
        $this->_renderer->assign('wallpapers', $wallpapers);

        $fanarts = Dao::collection('gallery-image')->getGalleryFanarts();
        $this->_renderer->assign('fanarts', $fanarts);

        $this->loginAction();
    }
    
    // TODO should name init()
    public function afterAction() {
        parent::afterAction();
    }

    public function loginAction() {
        AuthManager::login();
        // $this->actionForward('login', 'auth', true);
    }

    public function logoutAction() {
        AuthManager::logout();
        $this->actionForward('logout', 'auth', true);
    }
}
