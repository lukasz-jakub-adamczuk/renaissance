<?php

namespace Renaissance\Controller;

use Renaissance\Controller\FrontController;

class NewsController extends FrontController {

    public function indexAction() {}

    public function infoAction() {
        $this->setTemplateName('news-info-2');
    }

    public function showByYearAction() {}

    public function showByMonthAction() {}
}