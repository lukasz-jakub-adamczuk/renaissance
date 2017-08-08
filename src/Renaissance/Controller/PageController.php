<?php

class PageController extends FrontController {

    public function infoAction() {
        $slug = isset($_GET['slug']) ? strip_tags($_GET['slug']) : null;

        if ($slug) {
            $this->setTemplateName('page/'.$slug);
        }
    }
}