<?php

namespace Renaissance\Controller;

use Renaissance\Controller\FrontController;

class StoryController extends FrontController {

    public function showByCategoryAction() {
    }

    public function infoAction() {
        $this->setTemplateName('article-info-2');
    }
}