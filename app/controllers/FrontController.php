<?php
require_once AYA_DIR.'/Core/Controller.php';

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
        $selfUrl = BASE_URL;
        if (isset($_SERVER['REDIRECT_URI'])) {
            $selfUrl = $_SERVER['REDIRECT_URI'];
        }
        $this->_renderer->assign('self', $selfUrl);

        // resources
        $aResources = array();

        // css
        $sCssFile = PUB_DIR . '/config/resources/css';
        if (file_exists($sCssFile)) {
            $config = file_get_contents($sCssFile);
            $aResources['css'] = explode("\n", $config);
        }

        // js
        $sJsFile = PUB_DIR . '/config/resources/js';
        if (file_exists($sJsFile)) {
            $config = file_get_contents($sJsFile);
            $aResources['js'] = explode("\n", $config);
        }

        $this->_renderer->assign('aResources', $aResources);

        // cosplays
        $sCosplaysFile = CACHE_DIR . '/cosplays';
        if (file_exists($sCosplaysFile)) {
            $aCosplays = unserialize(file_get_contents($sCosplaysFile));
        } else {
            $sql = 'SELECT gi.*
                    FROM gallery_image gi 
                    -- LEFT JOIN gallery_category gc ON(gc.id_gallery_category=gi.id_gallery_category)
                    WHERE gi.id_gallery=4
                    -- GROUP BY a.id_article_category
                    ORDER BY gi.id_gallery_image DESC
                    LIMIT 0,8
                    ';

            $oCollection = Dao::collection('gallery-image');
            $oCollection->query($sql);

            $aCosplays = $oCollection->getRows();

            file_put_contents($sCosplaysFile, serialize($aCosplays));
        }
        $this->_renderer->assign('aCosplays', $aCosplays);

        // wallpapers
        $sWallpapersFile = CACHE_DIR . '/wallpapers';
        if (file_exists($sWallpapersFile)) {
            $aWallpapers = unserialize(file_get_contents($sWallpapersFile));
        } else {
            $sql = 'SELECT gi.*, g.slug, gc.slug AS category_slug
                    FROM gallery_image gi 
                    LEFT JOIN gallery g ON(g.id_gallery=gi.id_gallery)
                    LEFT JOIN gallery_category gc ON(gc.id_gallery_category=g.id_gallery_category)
                    WHERE gc.id_gallery_category=1
                    GROUP BY gi.id_gallery
                    ORDER BY gi.id_gallery_image DESC
                    LIMIT 0,8
                    ';

            $oCollection = Dao::collection('gallery-image');
            $oCollection->query($sql);

            $aWallpapers = $oCollection->getRows();

            file_put_contents($sWallpapersFile, serialize($aWallpapers));
        }
        $this->_renderer->assign('aWallpapers', $aWallpapers);

        // fanarts
        $sFanartsFile = CACHE_DIR . '/fanarts';
        if (file_exists($sFanartsFile)) {
            $aFanarts = unserialize(file_get_contents($sFanartsFile));
        } else {
            $sql = 'SELECT gi.*, g.slug, gc.slug AS category_slug
                    FROM gallery_image gi 
                    LEFT JOIN gallery g ON(g.id_gallery=gi.id_gallery)
                    LEFT JOIN gallery_category gc ON(gc.id_gallery_category=g.id_gallery_category)
                    WHERE gc.id_gallery_category=2
                    GROUP BY gi.id_gallery
                    ORDER BY gi.id_gallery_image DESC
                    LIMIT 0,8
                    ';

            $oCollection = Dao::collection('gallery-image');
            $oCollection->query($sql);

            $aFanarts = $oCollection->getRows();

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
