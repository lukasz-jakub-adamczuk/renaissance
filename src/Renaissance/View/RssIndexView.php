<?php
require_once AYA_DIR.'/Core/View.php';

class RssIndexView extends View {

    public function fill() {
        // news
        $oNewsCollection = Dao::collection('news');
        $aNews = $oNewsCollection->getNewsForStream(12);

        // ksort($aActivities)
        foreach ($aNews as &$item) {
            $item['key'] = 'id_news';
            $item['type'] = 'news';
            $item['url'] = ValueMapper::getUrl('news').'/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug'];

            // rss
            $item['title'] = stripslashes($item['title']);
            $item['link'] = SITE_URL . '/' . ValueMapper::getUrl('news').'/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug'];
            // $item['description'] = strip_tags(stripslashes($item['markup']));

            $objDateTime = new DateTime($item['creation_date']);

            $item['pubDate'] = $objDateTime->format(DateTime::RSS);

            // $aImageItem = $oNewsImageEntity->getFirstImage($item['id_news']);

            // $item['fragment'] = $aImageItem['name'];
            // // fix
            // if ($aImageItem['name'] == '') {
            //     $sAsset = '/assets/news/'.strftime('%Y/%m/%d', strtotime($item['creation_date'])).'/'.$item['id_news'].'/bg-01.jpg';
            //     $item['fragment'] = $sAsset;
            // }
        }
        $aRss = array();

        // config
        $aRss['title'] = 'Squarezone - Aktualności';
        $aRss['description'] = 'Squarezone - polska strona o Square Enix oraz jRPG.';
        $aRss['link'] = 'http://squarezone.pl';
        $aRss['lastBuildDate'] = '...';
        $aRss['generator'] = 'genrator';

        $aRss['image'] = array();
        $aRss['image']['url'] = BASE_URL . '/favicon.png';
        $aRss['image']['title'] = 'title';
        $aRss['image']['link'] = BASE_URL;
        $aRss['image']['description'] = 'get from meta...';

        // items
        $aRss['items'] = $aNews;

        $this->_renderer->assign('aRss', $aRss);

    }

    protected function _runBeforeFill() {

    }
}