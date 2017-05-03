<?php
require_once AYA_DIR.'/Core/View.php';

require_once APP_DIR.'/helpers/Comments.php';

// temporary
require_once APP_DIR.'/helpers/NewsConverter.php';

class NewsInfoView extends View {

    public function fill() {
        // old page urls
        $sUrl = isset($_GET['url']) ? $_GET['url'].',news.html' : null;

        // new page urls
        $sYear = isset($_GET['year']) ? $_GET['year'] : null;
        $sMonth = isset($_GET['month']) ? $_GET['month'] : null;
        $sDay = isset($_GET['day']) ? $_GET['day'] : null;
        $sSlug = isset($_GET['slug']) ? $_GET['slug'] : null;

        if ($sUrl) {
            // news
            $sql = 'SELECT n.*, COUNT(nc.id_news_comment) comments, u.slug author_slug, u.name author_name 
                    FROM news n 
                    LEFT JOIN user u ON(u.id_user=n.id_author) 
                    LEFT JOIN news_comment nc ON(nc.id_news=n.id_news) 
                    WHERE n.old_url="'.$sUrl.'" ';
        } else {
            // news
            $sql = 'SELECT n.*, COUNT(nc.id_news_comment) comments, u.slug author_slug, u.name author_name 
                    FROM news n 
                    LEFT JOIN user u ON(u.id_user=n.id_author) 
                    LEFT JOIN news_comment nc ON(nc.id_news=n.id_news) 
                    WHERE n.slug="'.$sSlug.'" AND YEAR(n.creation_date)="'.$sYear.'" AND MONTH(n.creation_date)="'.$sMonth.'" AND DAY(n.creation_date)="'.$sDay.'"';
        }

        $oEntity = Dao::entity('news');
        $oEntity->query($sql);

        $aNews = $oEntity->getFields();
        
        // print_r($aNews);
        $this->_renderer->assign('aNews', $aNews);

        // headers
        if ($sUrl) {
            $sDate = $oEntity->getField('creation_date');
            $sYear = substr($sDate, 0, 4);
            $sMonth = substr($sDate, 5, 2);
            $sDay = substr($sDate, 8, 2);
            $sSlug = $oEntity->getField('slug');

            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('news').'/'.$sYear.'/'.$sMonth.'/'.$sDay.'/'.$sSlug.'', TRUE, 301);
        }

        
        // check markup for validity
        $sMarkup = $oEntity->getField('markup');

        $html = stripslashes($sMarkup);

        // breadcrumbs
        $aItem = array(
            'url' => ValueMapper::getUrl('news').'/'.$sYear,
            'text' => $sYear
        );
        Breadcrumbs::add($aItem);

        // breadcrumbs
        $aItem = array(
            'url' => ValueMapper::getUrl('news').'/'.$sYear.'/'.$sMonth,
            'text' => $sMonth
        );
        Breadcrumbs::add($aItem);

        // self url
        $sSelfUrl = BASE_URL . '/' . $aItem['url'] . '/' . $sSlug;
        $this->_renderer->assign('sSelfUrlEncode', urlencode($sSelfUrl));

        // news details
        $iId = $aNews['id_news'];

        if ($iId) {
            // title
            $this->_renderer->assign('sTitle', 'Squarezone - Aktualności - '.$oEntity->getField('title'));

            // images
            $oImagesCollection = Dao::collection('news-image');
            $aImages = $oImagesCollection->getNewsImagesById($oEntity->getField('id_news'));

            // print_r($aImages);

            // news conversion
            $bValidNews = true;
            // not valid if images have not paths
            if (count($aImages)) {
                foreach ($aImages as $img) {
                    if ($img['name'] == '') {
                        $bValidNews = false;
                    }
                }
            }
            // or unverified
            if ($aNews['verified'] == 0) {
                $bValidNews = false;
            }
            // $bValidNews = false;
            if ($bValidNews == false) {
                $aAssets = NewsConverter::check($iId, $sYear, $sMonth, $sDay, $aImages);

                if ($aAssets) {
                    // print_r($aAssets);
                    foreach ($aAssets as $ak => $asset) {
                        $aImages[$ak]['name'] = $asset;

                        $oNewsImageEntity = Dao::entity('news-image', $ak);
                        // print_r($oNewsImageEntity);
                        $oNewsImageEntity->setField('name', $asset);
                        // echo $oNewsImageEntity->getQuery();
                        // print_r($oNewsImageEntity);
                        if ($oNewsImageEntity->update()) {
                            // echo $oNewsEntity->getQuery();
                        //  // ChangeLog::add('create', $this->_ctrlName, $mId);
                        }
                    }
                }
                // update news as verified
                $oTmpEntity = Dao::entity('news', $iId);
                $oTmpEntity->setField('verified', 1);
                if ($oTmpEntity->update()) {
                    // 
                }
            }

            if ($aImages) {
                // print_r($aImages);
                if (count($aImages) > 1)  {
                    $this->_renderer->assign('aFirstImage', current($aImages));
                    $this->_renderer->assign('aImages', array_slice($aImages, 1));

                    // gallery
                    $this->_renderer->assign('aScreens', array_slice($aImages, 1));

                    $aGallery['class'] = 'full';
                    $aGallery['show_link'] = false;
                    $aGallery['category_abbr'] = $oEntity->getField('abbr');

                    $this->_renderer->assign('aGallery', $aGallery);
                } else {
                    $this->_renderer->assign('aFirstImage', current($aImages));
                    // print_r(current($aImages));
                }
            }

            // previous and next entry
            $oNewsCollection = Dao::collection('news');
            $aSiblings = $oNewsCollection->getNewsSiblings($oEntity->getField('id_news'));

            $aRelatedNews = array();

            if (is_array($aSiblings)) {
                foreach ($aSiblings as $nk => $news) {
                    // $aSiblings
                    if ($nk > $iId) {
                        $aRelatedNews['newer'] = $news;
                        $aRelatedNews['newer']['date'] = str_replace('-', '/', substr($news['creation_date'], 0, 10));
                    }
                    if ($nk < $iId) {
                        $aRelatedNews['older'] = $news;
                        $aRelatedNews['older']['date'] = str_replace('-', '/', substr($news['creation_date'], 0, 10));
                        break;
                    }
                }
            }

            $this->_renderer->assign('aRelatedNews', $aRelatedNews);

            // print_r($aSiblings);
            // print_r($aRelatedNews);
            // print_r($aPosts);


            // comments form
            // $this->_renderer->assign('aCommentsForm', Comments::getFormParams('article', $oEntity));
            // $aCommentsForm = array();
            // $aCommentsForm['ctrl'] = ValueMapper::getUrl($_GET['ctrl'], true);
            // $aCommentsForm['object_slug'] = $oEntity->getField('slug');

            // $aCommentsForm['object'] = 'id_news';
            // $aCommentsForm['id_object'] = $iId;
            // print_r(Comments::getFormParams('news', $oEntity));

            $this->_renderer->assign('aCommentsForm', Comments::getFormParams('news', $oEntity));

            // comments
            $oCommentsCollection = Dao::collection('comments');

            $this->_renderer->assign('aComments', $oCommentsCollection->getCommentsById('news', $oEntity->getField('id_news')));
            $this->_renderer->assign('aNavigator', $oCommentsCollection->getNavigator());
        } else {
            // log 404
            // $sLogFile = LOG_DIR.'/404/'.date('Y-m-d').'.log';
            Logger::logStandardRequest('404');
        }
    }
}