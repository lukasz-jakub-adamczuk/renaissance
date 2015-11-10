<?php
require_once AYA_DIR.'/Core/View.php';

class UserIndexView extends View {

	public function fill() {
		// $sSlug = $_GET['slug'];

		// $sql = 'SELECT u.*, u.slug
		// 		FROM user u 
		// 		WHERE u.slug="'.$sSlug.'" ';

		// $oUserEntity = Dao::entity('user');
		// $oUserEntity->query($sql);

		// $this->_oRenderer->assign('aUser', $oUserEntity->getFields());

		// $aUser = $oUserEntity->getFields();

		

		// trophies
		// echo 'aaa';
		// echo $oUserEntity->getField('id_user');
		// echo $aUser['id_user'];

		// top10 news authors ever
		$sql = 'SELECT a.id_news, COUNT(a.id_news) total, u.id_user, u.name, u.slug 
				FROM news a
				LEFT JOIN user u ON(u.id_user=a.id_author) 
				GROUP BY a.id_author 
				ORDER BY total DESC 
				LIMIT 0, 10';
		
		$oNewsAuthorsEverCollection = Dao::collection('news');
		$oNewsAuthorsEverCollection->query($sql);

		$this->_oRenderer->assign('aNewsAuthorsEver', $oNewsAuthorsEverCollection->getRows());


		// top10 article authors ever
		$sql = 'SELECT a.id_article, COUNT(a.id_article) total, u.id_user, u.name, u.slug 
				FROM article a
				LEFT JOIN user u ON(u.id_user=a.id_author) 
				GROUP BY a.id_author 
				ORDER BY total DESC 
				LIMIT 0, 10';
		
		$oArticleAuthorsEverCollection = Dao::collection('article');
		$oArticleAuthorsEverCollection->query($sql);

		$this->_oRenderer->assign('aArticleAuthorsEver', $oArticleAuthorsEverCollection->getRows());


		// top10 story authors ever
		$sql = 'SELECT a.id_story, COUNT(a.id_story) total, u.id_user, u.name, u.slug 
				FROM story a
				LEFT JOIN user u ON(u.id_user=a.id_author) 
				GROUP BY a.id_author 
				ORDER BY total DESC 
				LIMIT 0, 10';
		
		$oStoryAuthorsEverCollection = Dao::collection('story');
		$oStoryAuthorsEverCollection->query($sql);

		$this->_oRenderer->assign('aStoryAuthorsEver', $oStoryAuthorsEverCollection->getRows());


		// top10 news comments authors ever
		$sql = 'SELECT nc.id_news_comment, COUNT(nc.id_news_comment) total, u.id_user, u.name, u.slug 
				FROM news_comment nc
				LEFT JOIN user u ON(u.id_user=nc.id_author) 
				WHERE nc.id_author <> 0 AND nc.id_news <> 0 
				GROUP BY nc.id_author 
				ORDER BY total DESC 
				LIMIT 0, 10';
		
		$oNewsCommentsAuthorsEverCollection = Dao::collection('news-comment');
		$oNewsCommentsAuthorsEverCollection->query($sql);

		$this->_oRenderer->assign('aNewsCommentsAuthorsEver', $oNewsCommentsAuthorsEverCollection->getRows());


		// top10 article comments authors ever
		$sql = 'SELECT ac.id_article_comment, COUNT(ac.id_article_comment) total, u.id_user, u.name, u.slug 
				FROM article_comment ac
				LEFT JOIN user u ON(u.id_user=ac.id_author) 
				WHERE ac.id_author <> 0 AND ac.id_article <> 0 
				GROUP BY ac.id_author 
				ORDER BY total DESC 
				LIMIT 0, 10';
		
		$oArticleCommentsAuthorsEverCollection = Dao::collection('article-comment');
		$oArticleCommentsAuthorsEverCollection->query($sql);

		$this->_oRenderer->assign('aArticleCommentsAuthorsEver', $oArticleCommentsAuthorsEverCollection->getRows());


		// top10 story comments authors ever
		$sql = 'SELECT sc.id_story_comment, COUNT(sc.id_story_comment) total, u.id_user, u.name, u.slug 
				FROM story_comment sc
				LEFT JOIN user u ON(u.id_user=sc.id_author) 
				WHERE sc.id_author <> 0 AND sc.id_story <> 0 
				GROUP BY sc.id_author 
				ORDER BY total DESC 
				LIMIT 0, 10';
		
		$oStoryCommentsAuthorsEverCollection = Dao::collection('story-comment');
		$oStoryCommentsAuthorsEverCollection->query($sql);

		$this->_oRenderer->assign('aStoryCommentsAuthorsEver', $oStoryCommentsAuthorsEverCollection->getRows());


		// top10 article verdicts authors ever
		$sql = 'SELECT av.id_article_verdict, COUNT(av.id_article_verdict) total, u.id_user, u.name, u.slug 
				FROM article_verdict av
				LEFT JOIN user u ON(u.id_user=av.id_author) 
				WHERE av.id_author <> 0 AND av.id_article_verdict <> 0 
				GROUP BY av.id_author 
				ORDER BY total DESC 
				LIMIT 0, 10';
		
		$oArticleVerdictsAuthorsEverCollection = Dao::collection('article-verdict');
		$oArticleVerdictsAuthorsEverCollection->query($sql);

		$this->_oRenderer->assign('aArticleVerdictsAuthorsEver', $oArticleVerdictsAuthorsEverCollection->getRows());
		// $this->_oRenderer->assign('aNavigator', $oAllAuthorsCollection->getNavigator());
	}
}