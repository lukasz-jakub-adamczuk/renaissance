<?php

class DevController extends CrudController {

    public function indexAction() {
        $this->setTemplateName('dev-index');
    }

    public function introsAction() {
        $this->setTemplateName('dev-index');
    }

    public function reviewsAction() {
        echo 'aaa';
        $this->setTemplateName('dev-index');
    }
}