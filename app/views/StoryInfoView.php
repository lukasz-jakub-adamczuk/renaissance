<?php
// require_once AYA_DIR.'/Management/InfoView.php';
require_once AYA_DIR.'/Core/View.php';

require_once APP_DIR.'/helpers/Comments.php';

class StoryInfoView extends View {

	private $_iEntityId = 0;

	public function fill() {
		// old page urls
		$sUrl = isset($_GET['url']) ? $_GET['url'].',articles,pub.html' : null;

		$bNotRedirected = true;

		// category redirect
		if ($sUrl == '0,articles,pub.html') {
			header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/fanfiki', TRUE, 301);
			$bNotRedirected = false;
		}
		if ($sUrl == '1,articles,pub.html') {
			header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/artykuly', TRUE, 301);
			$bNotRedirected = false;
		}

		if ($sUrl) {
			// story
			$sql = 'SELECT s.*, c.name category_name, c.slug category_slug, u.slug author_slug, u.name author_name 
					FROM story s 
					LEFT JOIN story_category c ON(c.id_story_category=s.id_story_category) 
					LEFT JOIN user u ON(u.id_user=s.id_author) 
					WHERE s.old_url="'.$sUrl.'" ';
		} else {
			$sSlug = isset($_GET['slug']) ? $_GET['slug'] : null;
			// $sCategory = isset($_GET['category']) ? $_GET['category'] : null;

			// story
			$sql = 'SELECT s.*, c.name category_name, c.slug category_slug, u.slug author_slug, u.name author_name 
					FROM story s 
					LEFT JOIN story_category c ON(c.id_story_category=s.id_story_category) 
					LEFT JOIN user u ON(u.id_user=s.id_author) 
					WHERE s.slug="'.$sSlug.'" ';
		}

		$oEntity = Dao::entity('story');
		$oEntity->query($sql);
		$aArticle = $oEntity->getFields();

		// headers
		if ($sUrl && $bNotRedirected) {
			$sCategorySlug = $oEntity->getField('category_slug');
			$sSlug = $oEntity->getField('slug');

			$sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
			Logger::logStandardRequest($sLogFile);

			header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('story').'/'.$sCategorySlug.'/'.$sSlug, TRUE, 301);
		}

		// var_dump($oEntity->getQuery());
		// echo $aArticle['title'];

		if ($aArticle) {
			// title
			$this->_oRenderer->assign('sTitle', 'Squarezone - Publicystyka - '.$oEntity->getField('category_name').' - '.$oEntity->getField('title'));

			$mId = $aArticle['id_story'];
			$this->_iEntityId = $aArticle['id_story'];

			$sCategorySlug = $oEntity->getField('category_slug');
			$sArticleSlug = $oEntity->getField('slug');

			$aArticle['id'] = $mId;
			$aArticle['template'] = 'story text';

			$this->_oRenderer->assign('aArticle', $aArticle);

			// breadcrumbs
			$aItem = array(
				'url' => ValueMapper::getUrl('story').'/'.$oEntity->getField('category_slug'),
				'text' => $oEntity->getField('category_name')
			);
			Breadcrumbs::add($aItem);

			// self url
			$sSelfUrl = BASE_URL . '/' . $aItem['url'] . '/' . $sArticleSlug;
			$this->_oRenderer->assign('sSelfUrlEncode', urlencode($sSelfUrl));

			// fragments
			$sql = 'SELECT of.*, f.*, ft.name type
					FROM object_fragment of 
					LEFT JOIN fragment f ON(f.id_fragment=of.id_fragment) 
					LEFT JOIN fragment_type ft ON(ft.id_fragment_type=f.id_fragment_type) 
					WHERE of.object="story" AND of.id_object="'.$aArticle['id_story'].'" ';

			$oFragmentsCollection = Dao::collection('object-fragment');
			$oFragmentsCollection->query($sql);

			$aFragments = array();
			foreach ($oFragmentsCollection->getRows() as $fragment) {
				$aFragments[$fragment['type']][] = $fragment;
			}
			
			// print_r($aFragments);
			$this->_oRenderer->assign('aFragments', $aFragments);

			if (isset($aFragments['cover-image'])) {
				$this->_oRenderer->assign('aCoverImage', $aFragments['cover-image']);
			}

			// comments form
			$this->_oRenderer->assign('aCommentsForm', Comments::getFormParams('story', $oEntity));
			$this->_oRenderer->assign('sCommentPrimaryKey', 'id_story_comment');

			// comments
			$oCommentsCollection = Dao::collection('story-comment');

			$this->_oRenderer->assign('aComments', $oCommentsCollection->getCommentsById($oEntity->getField('id_story')));
			$this->_oRenderer->assign('aNavigator', $oCommentsCollection->getNavigator());
		} else {
			// log 404
			$sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
			Logger::logStandardRequest($sLogFile);
		}
	}

	public function afterFill() {
		// update article
		// does we really need this value
		$sql = 'UPDATE story SET views = views + 1 WHERE id_story="'.$this->_iEntityId.'"';

		// $this->_aParams = unserialize(DB_SOURCE);

		$this->_db = Db::getInstance();
		$this->_db->execute($sql);
	}
}