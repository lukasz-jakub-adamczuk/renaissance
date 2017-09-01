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
        $gallerySlug = isset($_GET['slug']) ? $_GET['slug'] : null;

        $galleryEntity = Dao::entity('gallery');

        if ($url) {
            $article = $galleryEntity->getGalleryByOldUrl();
        } else {
            $article = $galleryEntity->getGallery($gallerySlug, $categorySlug);
        }

        // headers
        if ($url) {
            $gallerySlug = $galleryEntity->getField('slug');
            $categorySlug = $galleryEntity->getField('category_slug');
            
            Logger::logStandardRequest('redirects');

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('gallery').'/'.$categorySlug.'/'.$gallerySlug, TRUE, 301);
        }

        // title
        $this->_renderer->assign('title', 'Squarezone - Galerie - '.$galleryEntity->getField('category_name').' - '.$galleryEntity->getField('title'));
        
        $article['id'] = $article['id_gallery'];
        $article['template'] = 'gallery';

        $this->_renderer->assign('article', $article);

        // breadcrumbs
        $item = array(
            'url' => ValueMapper::getUrl('gallery').'/'.$categorySlug,
            'text' => $galleryEntity->getField('category_name')
        );
        Breadcrumbs::add($item);

        // images
        $imagesCollection = Dao::collection('gallery-image');
        $images = $imagesCollection->getGalleryImagesById($galleryEntity->getField('id_gallery'));

        $this->_renderer->assign('images', $images);

        // comments form
        $this->_renderer->assign('commentsForm', Comments::getFormParams('gallery', $galleryEntity));

        // comments
        $commentCollection = Dao::collection('comment');

        $this->_renderer->assign('comments', $commentCollection->getCommentsById('gallery', $galleryEntity->getField('id_gallery')));
        $this->_renderer->assign('navigator', $commentCollection->getNavigator());
    }
}