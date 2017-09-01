<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\Breadcrumbs;
use Aya\Helper\ValueMapper;

use Renaissance\Helper\Comments;
use Renaissance\Helper\NewsConverter;

class NewsInfoView extends View {

    public function fill() {
        // old page urls
        $url = isset($_GET['url']) ? $_GET['url'].',news.html' : null;

        // new page urls
        $year = isset($_GET['year']) ? $_GET['year'] : null;
        $month = isset($_GET['month']) ? $_GET['month'] : null;
        $day = isset($_GET['day']) ? $_GET['day'] : null;
        $slug = isset($_GET['slug']) ? $_GET['slug'] : null;

        $newsEntity = Dao::entity('news');
        
        if ($url) {
            $aNews = $newsEntity->getNewsByOldUrl($url);
        } else {
            $aNews = $newsEntity->getNews($slug, $year, $month, $day);
        }

        $this->_renderer->assign('aNews', $aNews);

        // headers
        if ($url) {
            $date = $newsEntity->getField('creation_date');
            $slug = $newsEntity->getField('slug');
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            // refactor
            $sLogFile = LOG_DIR.'/redirects/'.date('Y-m-d').'.log';
            Logger::logStandardRequest($sLogFile);

            header('Location: '.BASE_URL.'/'.ValueMapper::getUrl('news').'/'.$year.'/'.$month.'/'.$day.'/'.$slug.'', TRUE, 301);
        }

        
        // check markup for validity
        $sMarkup = $newsEntity->getField('markup');

        $html = stripslashes($sMarkup);

        // breadcrumbs
        $item = array(
            'url' => ValueMapper::getUrl('news').'/'.$year,
            'text' => $year
        );
        Breadcrumbs::add($item);

        // breadcrumbs
        $item = array(
            'url' => ValueMapper::getUrl('news').'/'.$year.'/'.$month,
            'text' => $month
        );
        Breadcrumbs::add($item);

        // self url
        $selfUrl = BASE_URL . '/' . $item['url'] . '/' . $slug;
        $this->_renderer->assign('encodedSelfUrl', urlencode($selfUrl));

        // news details
        $id = $aNews['id_news'];

        // title
        $this->_renderer->assign('title', 'Squarezone - Aktualności - '.$newsEntity->getField('title'));

        // images
        $oImagesCollection = Dao::collection('news-image');
        $aImages = $oImagesCollection->getNewsImagesById($newsEntity->getField('id_news'));

        if ($aImages) {
            // print_r($aImages);
            if (count($aImages) > 1)  {
                $this->_renderer->assign('aFirstImage', current($aImages));
                $this->_renderer->assign('aImages', array_slice($aImages, 1));

                // gallery
                $this->_renderer->assign('aScreens', array_slice($aImages, 1));

                $aGallery['class'] = 'full';
                $aGallery['show_link'] = false;
                $aGallery['category_abbr'] = $newsEntity->getField('abbr');

                $this->_renderer->assign('aGallery', $aGallery);
            } else {
                $this->_renderer->assign('aFirstImage', current($aImages));
                
            }
        }

        // previous and next entry
        $oNewsCollection = Dao::collection('news');
        $aSiblings = $oNewsCollection->getNewsSiblings($newsEntity->getField('id_news'));

        $aRelatedNews = [];

        if (is_array($aSiblings)) {
            foreach ($aSiblings as $nk => $news) {
                // $aSiblings
                if ($nk > $id) {
                    $aRelatedNews['newer'] = $news;
                    $aRelatedNews['newer']['date'] = str_replace('-', '/', substr($news['creation_date'], 0, 10));
                }
                if ($nk < $id) {
                    $aRelatedNews['older'] = $news;
                    $aRelatedNews['older']['date'] = str_replace('-', '/', substr($news['creation_date'], 0, 10));
                    break;
                }
            }
        }

        $this->_renderer->assign('aRelatedNews', $aRelatedNews);

        $this->_renderer->assign('commentsForm', Comments::getFormParams('news', $newsEntity));

        // comments
        $commentCollection = Dao::collection('comment');

        $this->_renderer->assign('comments', $commentCollection->getCommentsById('news', $newsEntity->getField('id_news')));
        $this->_renderer->assign('navigator', $commentCollection->getNavigator());
    }
}