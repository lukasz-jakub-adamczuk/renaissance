<?php
// require_once AYA_DIR.'/Management/InfoView.php';
require_once AYA_DIR.'/Core/View.php';

require_once APP_DIR.'/helpers/Comments.php';

// temporary
require_once APP_DIR.'/helpers/GalleryConverter.php';

class GalleryInfoView extends View {

    public function fill() {
        // old page urls
        $sUrl = isset($_GET['url']) ? $_GET['url'].',gallery.html' : null;

        // new page urls
        $sCategorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $sSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

        if ($sUrl) {
            // gallery
            // $sql = 'SELECT s.*, c.name category_name, c.slug category_slug, u.name author_name 
            //         FROM gallery s 
            //         LEFT JOIN gallery_category c ON(c.id_gallery_category=s.id_gallery_category) 
            //         LEFT JOIN user u ON(u.id_user=s.id_author) 
            //         WHERE s.old_url="'.$sUrl.'" ';
            $sql = 'SELECT gi.*, c.name category_name, c.slug category_slug, u.name author_name 
                    FROM gallery_image gi 
                    LEFT JOIN gallery g ON(g.id_gallery=gi.id_gallery) 
                    LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category) 
                    LEFT JOIN user u ON(u.id_user=g.id_author) 
                    WHERE g.old_url="'.$sUrl.'" ';
        } else {
            // gallery
            $sql = 'SELECT gi.*, g.name name, c.name category_name, c.slug category_slug, u.name author_name 
                    FROM gallery_image gi 
                    LEFT JOIN gallery g ON(g.id_gallery=gi.id_gallery) 
                    LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category) 
                    LEFT JOIN user u ON(u.id_user=g.id_author) 
                    WHERE g.slug="'.$sSlug.'" ';
        }

        $oEntity = Dao::entity('gallery');
        $oEntity->query($sql);
        $aArticle = $oEntity->getFields();


        // print_r($aArticle);

        // headers
        if ($sUrl) {
            $sCategorySlug = $oEntity->getField('category_slug');
            $sSlug = $oEntity->getField('slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('gallery').'/'.$sCategorySlug.'/'.$sSlug, TRUE, 301);
        }

        // var_dump($oEntity->getQuery());
        // echo $aArticle['title'];

        // news details
        $iId = $aArticle['id_gallery'];

        if ($aArticle) {
            // title
            $this->_renderer->assign('sTitle', 'Squarezone - Galerie - '.$oEntity->getField('category_name').' - '.$oEntity->getField('title'));

            $mId = $aArticle['id_gallery'];

            $aArticle['id'] = $mId;
            $aArticle['template'] = 'gallery';

            $this->_renderer->assign('aArticle', $aArticle);

            // breadcrumbs
            $aItem = array(
                'url' => ValueMapper::getUrl('gallery').'/'.$oEntity->getField('category_slug'),
                'text' => $oEntity->getField('category_name')
            );
            Breadcrumbs::add($aItem);

            // echo $oEntity->getField('id_gallery');

            $oImagesCollection = Dao::collection('gallery-image');
            $aImages = $oImagesCollection->getGalleryImagesById($oEntity->getField('id_gallery'));


            // gallery conversion
            $bValidGallery = true;
            if (count($aImages)) {
                foreach ($aImages as $img) {
                    if ($img['name'] == '') {
                        $bValidGallery = false;
                    }
                }
            }
            // $bValidGallery = false;
            if ($bValidGallery == false) {
                $aAssets = GalleryConverter::check($iId, $sCategorySlug, $aImages);

                if ($aAssets) {
                    foreach ($aAssets as $ak => $asset) {
                        $aImages[$ak]['name'] = $asset;

                        $oGalleryImageEntity = Dao::entity('gallery-image', $ak);
                        // print_r($oGalleryImageEntity);
                        $oGalleryImageEntity->setField('name', $asset);
                        // echo $oGalleryImageEntity->getQuery();
                        // print_r($oGalleryImageEntity);
                        if ($oGalleryImageEntity->update()) {
                            // echo $oGalleryEntity->getQuery();
                        //     // ChangeLog::add('create', $this->_ctrlName, $mId);
                        }
                    }
                }
            }

            $this->_renderer->assign('aImages', $aImages);

            // comments form
            $this->_renderer->assign('aCommentsForm', Comments::getFormParams('gallery', $oEntity));

            // comments
            $oCommentsCollection = Dao::collection('gallery-comment');

            $this->_renderer->assign('aComments', $oCommentsCollection->getCommentsById($oEntity->getField('id_gallery')));
            $this->_renderer->assign('aNavigator', $oCommentsCollection->getNavigator());
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);
        }
    }
}