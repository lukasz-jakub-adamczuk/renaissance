<?php
namespace Aya\Core;

// require_once AYA_DIR.'/Core/Controller.php';
use Aya\Core\Controller;

class FrontController extends Controller {

    protected function _afterInit() {}

    public function runBeforeMethod() {
        // decide when to show and hide
        if ($this->_ctrlName != 'home' ) {
            $aItem = array(
                'name' => 'ctrl',
                'url' => ValueMapper::getUrl($this->getCtrlName()),
                'text' => ValueMapper::getName($this->getCtrlName()),
            );
            Breadcrumbs::add($aItem);
        }

        $this->_renderer->assign('datetimeFormat', '%Y-%m-%dT%H:%M');

        // title
        $this->_renderer->assign('sTitle', 'Squarezone - '.ValueMapper::getName($this->getCtrlName()));

        // top nav
        $aNavTop = array(
            'article' => array(
                'name' => ValueMapper::getName('article'),
                'url' => ValueMapper::getUrl('article')
            ),
            'story' => array(
                'name' => ValueMapper::getName('story'),
                'url' => ValueMapper::getUrl('story')
            ),
            'gallery' => array(
                'name' => ValueMapper::getName('gallery'),
                'url' => ValueMapper::getUrl('gallery')
            ),
            'user' => array(
                'name' => ValueMapper::getName('user'),
                'url' => ValueMapper::getUrl('user')
            ),
            // 'trophy' => array(
            //     'name' => ValueMapper::getName('trophy'),
            //     'url' => ValueMapper::getUrl('trophy')
            // ),
            'cup' => array(
                'name' => ValueMapper::getName('cup'),
                'url' => ValueMapper::getUrl('cup')
            ),
            'forum' => array(
                'name' => ValueMapper::getName('forum'),
                'url' => FORUM_URL,
                'external' => true
            )
        );

        $this->_renderer->assign('aNavTop', $aNavTop);

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
        if (file_exists($sWallpapersFile)) {
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
        if (file_exists($sFanartsFile)) {
            // echo 'fanarts from cache';
            $aFanarts = unserialize(file_get_contents($sFanartsFile));
        } else {
            // echo 'fanarts from db';

            $collection = Dao::collection('gallery-image');

            $aFanarts = $collection->getGalleryFanarts();

            file_put_contents($sFanartsFile, serialize($aFanarts));
        }
        $this->_renderer->assign('aFanarts', $aFanarts);

    }
    
    // TODO should name init()
    public function runAfterMethod() {
        parent::runAfterMethod();

        if (isset($_SESSION['user'])) {
            $this->_renderer->assign('user', User::get());
        }

        $this->_renderer->assign('aBreadcrumbs', Breadcrumbs::get());
        
        // vars in templates
        $this->_renderer->assign('base', BASE_URL);
        if (defined('SITE_URL')) {
            $this->_renderer->assign('site', SITE_URL);
        }
    }
    
    public function indexAction() {}

    public function infoAction() {}

}
