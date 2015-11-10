<?php

class ArticleController extends FrontController {

	public function showByCategoryAction() {
		// $this->setTemplateName('story-show-by-category');
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