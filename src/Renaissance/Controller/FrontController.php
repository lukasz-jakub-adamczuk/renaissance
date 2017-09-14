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
        if ($this->_ctrlName != 'home' ) {
            $item = array(
                'name' => 'ctrl',
                'url' => ValueMapper::getUrl($this->getCtrlName()),
                'text' => ValueMapper::getName($this->getCtrlName()),
            );
            Breadcrumbs::add($item);
        }

        $this->_renderer->assign('datetimeFormat', '%Y-%m-%dT%H:%M');

        // title
        $this->_renderer->assign('title', 'Squarezone - '.ValueMapper::getName($this->getCtrlName()));

        // self url used in few places
        $selfUrl = '';
        if (isset($_SERVER['REDIRECT_URL'])) {
            $selfUrl = $_SERVER['REDIRECT_URL'];
        }
        $this->_renderer->assign('self', $selfUrl);


        // cosplays
        $sCosplaysFile = CACHE_DIR . '/cosplays';
        if (file_exists($sCosplaysFile)) {
            $aCosplays = unserialize(file_get_contents($sCosplaysFile));
        } else {
            $collection = Dao::collection('gallery-image');
            
            $aCosplays = $collection->getGalleryCosplays();

            file_put_contents($sCosplaysFile, serialize($aCosplays));
        }
        $this->_renderer->assign('aCosplays', $aCosplays);

        // wallpapers
        // CacheManager::restore('front-wallpapers', Dao::collection('gallery-image')->getGalleryWallpapers());
        
        // if (CacheManager::has('front-wallpapers')) {
        //     CacheManager::restore('front-wallpapers');
        // } else {
        //     CacheManager::save('front-wallpapers', Dao::collection('gallery-image')->getGalleryWallpapers());
        // }
        
        $sWallpapersFile = CACHE_DIR . '/wallpapers';
        if (!file_exists($sWallpapersFile)) {
            $aWallpapers = unserialize(file_get_contents($sWallpapersFile));
        } else {
            // echo 'wallpapers from db';
            // $collection = Dao::collection('gallery-image');
            
            // $aWallpapers = $collection->getGalleryWallpapers();
            $aWallpapers = Dao::collection('gallery-image')->getGalleryWallpapers();

            file_put_contents($sWallpapersFile, serialize($aWallpapers));
        }
        $this->_renderer->assign('aWallpapers', $aWallpapers);

        // fanarts
        $sFanartsFile = CACHE_DIR . '/fanarts';
        if (!file_exists($sFanartsFile)) {
            // echo 'fanarts from cache';
            $aFanarts = unserialize(file_get_contents($sFanartsFile));
        } else {
            // echo 'fanarts from db';

            $collection = Dao::collection('gallery-image');

            $aFanarts = $collection->getGalleryFanarts();

            file_put_contents($sFanartsFile, serialize($aFanarts));
        }
        $this->_renderer->assign('aFanarts', $aFanarts);

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
