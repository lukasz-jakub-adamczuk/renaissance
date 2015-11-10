<?php

class PageController extends FrontController {

	public function infoAction() {
		$sSlug = isset($_GET['slug']) ? strip_tags($_GET['slug']) : null;

		if ($sSlug) {
			$this->setTemplateName('page/'.$sSlug);
		}
	}
}