<?php

class NewsController extends FrontController {

    public function indexAction() {}

    public function infoAction() {
        $this->setTemplateName('news-info-2');
    }

    public function showByYearAction() {}

    public function showByMonthAction() {}
}