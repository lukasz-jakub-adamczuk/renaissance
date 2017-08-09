<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

use Renaissance\Helper\Comments;
use Renaissance\Helper\GalleryConverter;

class GalleryInfoView extends View {

    public function fill() {
        // old page urls
        $url = isset($_GET['url']) ? $_GET['url'].',gallery.html' : null;

        // new page urls
        $categorySlug = isset($_GET['category']) ? $_GET['category'] : null;
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;

        if ($url) {
            // gallery
            // $sql = 'SELECT s.*, c.name category_name, c.slug category_slug, u.name author_name 
            //         FROM gallery s 
            //         LEFT JOIN gallery_category c ON(c.id_gallery_category=s.id_gallery_category) 
            //         LEFT JOIN user u ON(u.id_user=s.id_author) 
            //         WHERE s.old_url="'.$url.'" ';
            $sql = 'SELECT gi.*, c.name category_name, c.slug category_slug, u.name author_name 
                    FROM gallery_image gi 
                    LEFT JOIN gallery g ON(g.id_gallery=gi.id_gallery) 
                    LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category) 
                    LEFT JOIN user u ON(u.id_user=g.id_author) 
                    WHERE g.old_url="'.$url.'" ';
        } else {
            // gallery
            $sql = 'SELECT gi.*, g.name name, c.name category_name, c.slug category_slug, u.name author_name 
                    FROM gallery_image gi 
                    LEFT JOIN gallery g ON(g.id_gallery=gi.id_gallery) 
                    LEFT JOIN gallery_category c ON(c.id_gallery_category=g.id_gallery_category) 
                    LEFT JOIN user u ON(u.id_user=g.id_author) 
                    WHERE g.slug="'.$slug.'" ';
        }

        $oEntity = Dao::entity('gallery');
        $oEntity->query($sql);
        $article = $oEntity->getFields();


        // print_r($article);

        // headers
        if ($url) {
            $categorySlug = $oEntity->getField('category_slug');
            $slug = $oEntity->getField('slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('gallery').'/'.$categorySlug.'/'.$slug, TRUE, 301);
        }

        // var_dump($oEntity->getQuery());
        // echo $article['title'];

        // news details
        $iId = $article['id_gallery'];

        if ($article) {
            // title
            $this->_renderer->assign('title', 'Squarezone - Galerie - '.$oEntity->getField('category_name').' - '.$oEntity->getField('title'));

            $id = $article['id_gallery'];

            $article['id'] = $id;
            $article['template'] = 'gallery';

            $this->_renderer->assign('article', $article);

            // breadcrumbs
            $item = array(
                'url' => ValueMapper::getUrl('gallery').'/'.$oEntity->getField('category_slug'),
                'text' => $oEntity->getField('category_name')
            );
            Breadcrumbs::add($item);

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
                $aAssets = GalleryConverter::check($iId, $categorySlug, $aImages);

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
                        //     // ChangeLog::add('create', $this->_ctrlName, $id);
                        }
                    }
                }
            }

            $this->_renderer->assign('aImages', $aImages);

            // comments form
            $this->_renderer->assign('commentsForm', Comments::getFormParams('gallery', $oEntity));

            // comments
            $oCommentsCollection = Dao::collection('gallery-comment');

            $this->_renderer->assign('comments', $oCommentsCollection->getCommentsById($oEntity->getField('id_gallery')));
            $this->_renderer->assign('navigator', $oCommentsCollection->getNavigator());
        } else {
            // log 404
            $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);
        }
    }
}