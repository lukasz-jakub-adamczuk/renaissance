<?php

class ArticleController extends FrontController {

    public function indexAction() {
        $this->setTemplateName('article-categories');
    }

    public function showByCategoryAction() {
        // $this->setTemplateName('article-show-by-category');
    }

    public function infoAction() {
        $sSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
        if ($sSlug == 'galeria') {
            $this->setTemplateName('article-gallery');
        } else {
            $this->setTemplateName('article-info-2');
        }
    }
}