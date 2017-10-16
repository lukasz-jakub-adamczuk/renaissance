<?php

namespace Renaissance\Controller;

use Renaissance\Controller\FrontController;

class PageController extends FrontController {

    public function indexAction() {
        // $slug = isset($_GET['slug']) ? strip_tags($_GET['slug']) : null;

        // if ($slug) {
        //     $this->setTemplateName('page/'.$slug);
        // }
    }

    public function infoAction() {
        $slug = isset($_GET['slug']) ? strip_tags($_GET['slug']) : null;

        $this->setTemplateName('all-info');
        // $this->_rendere

        // if ($slug) {
        //     $this->setTemplateName('page/'.$slug);
        // }
    }
}