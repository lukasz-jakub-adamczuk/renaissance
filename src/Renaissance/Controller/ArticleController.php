<?php

namespace Renaissance\Controller;

use Renaissance\Controller\FrontController;

class ArticleController extends FrontController {

    public function indexAction() {
        // $this->setTemplateName('article-categories');
    }

    public function showByCategoryAction() {
        // $this->setTemplateName('article-show-by-category');
    }

    public function infoAction() {
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
        if ($slug == 'galeria') {
            $this->setTemplateName('article-gallery');
        } else {
            $this->setTemplateName('article-info-2');
        }
    }
}