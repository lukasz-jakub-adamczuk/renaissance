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
            $news = $newsEntity->getNewsByOldUrl($url);
        } else {
            $news = $newsEntity->getNews($slug, $year, $month, $day);
        }

        $this->_renderer->assign('news', $news);

        // headers
        if ($url) {
            $date = $newsEntity->getField('creation_date');
            $slug = $newsEntity->getField('slug');
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);
            
            $this->redirect(BASE_URL.'/'.ValueMapper::getUrl('news').'/'.$year.'/'.$month.'/'.$day.'/'.$slug);
        }

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

        // title
        $this->_renderer->assign('title', 'Squarezone - Aktualności - '.$newsEntity->getField('title'));

        // images
        $imagesCollection = Dao::collection('news-image');
        $images = $imagesCollection->getNewsImagesById($newsEntity->getField('id_news'));

        if ($images) {
            $this->_renderer->assign('firstImage', current($images));
            if (count($images) > 1)  {
                $this->_renderer->assign('images', array_slice($images, 1));
            }
        }

        // previous and next entry
        $newsCollection = Dao::collection('news');
        $siblings = $newsCollection->getNewsSiblings($newsEntity->getField('id_news'));

        $pagination = [];
        if (is_array($siblings)) {
            foreach ($siblings as $nk => $news) {
                if ($nk > $news['id_news']) {
                    $pagination['newer'] = $news;
                    $pagination['newer']['date'] = str_replace('-', '/', substr($news['creation_date'], 0, 10));
                }
                if ($nk < $news['id_news']) {
                    $pagination['older'] = $news;
                    $pagination['older']['date'] = str_replace('-', '/', substr($news['creation_date'], 0, 10));
                    break;
                }
            }
        }
        $this->_renderer->assign('pagination', $pagination);

        $this->_renderer->assign('commentsForm', Comments::getFormParams('news', $newsEntity));

        // comments
        $commentCollection = Dao::collection('comment');

        $this->_renderer->assign('comments', $commentCollection->getCommentsById('news', $newsEntity->getField('id_news')));
        $this->_renderer->assign('navigator', $commentCollection->getNavigator());
    }
}