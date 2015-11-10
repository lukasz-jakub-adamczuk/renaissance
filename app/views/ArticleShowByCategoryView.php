<?php
require_once AYA_DIR.'/Core/View.php';

class ArticleShowByCategoryView extends View {

	public function fill() {
		$sCategory = isset($_GET['category']) ? $_GET['category'] : null;

		if ($sCategory) {
			$sql = 'SELECT a.*, c.slug category_slug, c.name category_name
					FROM article a 
					LEFT JOIN article_category c ON(c.id_article_category=a.id_article_category) 
					WHERE c.slug="'.$sCategory.'" 
					ORDER BY a.idx';
			
			$oArticleCollection = Dao::collection('article');
			$oArticleCollection->query($sql);

			$aArticles = $oArticleCollection->getRows();

			$this->_oRenderer->assign('aArticles', $aArticles);
			$this->_oRenderer->assign('aNavigator', $oArticleCollection->getNavigator());

			// category name
			$aFirstItem = current($aArticles);
			$this->_oRenderer->assign('sCategoryName', $aFirstItem['category_name']);

			// title
			$this->_oRenderer->assign('sTitle', 'Squarezone - Gry - '.$aFirstItem['category_name']);
		}
	}
}