<?php
require_once AYA_DIR.'/Core/View.php';

class HomeIndexView extends View {

    public function fill() {
        $sStreamFile = CACHE_DIR . '/stream';
        if (CACHE_OUTPUT && file_exists($sStreamFile)) {
            // echo 'from cache';
            $aActivities = unserialize(file_get_contents($sStreamFile));
        } else {
            // echo 'from db';
            // news
            $oNewsCollection = Dao::collection('news');
            $aActivities['news'] = $oNewsCollection->getNewsForStream(6);

            // print_r($aActivities['news']);

            // articles
            $oArticleCollection = Dao::collection('article');
            $aActivities['article'] = $oArticleCollection->getArticlesForStream(6);

            // stories
            $oStoryCollection = Dao::collection('story');
            $aActivities['story'] = $oStoryCollection->getStoriesForStream(6);

            $oNewsImageEntity = Dao::entity('news-image');

            // ksort($aActivities)
            foreach ($aActivities['news'] as &$item) {
                $item['key'] = 'id_news';
                $item['type'] = 'news';
                $item['url'] = ValueMapper::getUrl('news').'/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug'];

                $aImageItem = $oNewsImageEntity->getFirstImage($item['id_news']);

                // print_r($aImageItem);

                $item['fragment'] = $aImageItem['name'];
                // $item['fragment'] = 'aaa';
                // fix
                // if ($aImageItem['name'] == '') {
                //     $sAsset = '/assets/news/'.strftime('%Y/%m/%d', strtotime($item['creation_date'])).'/'.$item['id_news'].'/bg-01.jpg';
                //     $item['fragment'] = $sAsset;
                // }
            }

            foreach ($aActivities['article'] as &$item) {
                $item['key'] = 'id_article';
                $item['type'] = 'article';
                $item['url'] = ValueMapper::getUrl('article').'/'.$item['category_slug'].'/'.$item['slug'];
                $item['title'] = $item['category'].' - '.$item['title'];
            }

            foreach ($aActivities['story'] as &$item) {
                $item['key'] = 'id_story';
                $item['type'] = 'story';
                $item['url'] = ValueMapper::getUrl('story').'/'.$item['category_slug'].'/'.$item['slug'];
                // $item['title'] = $item['category'].' - '.$item['title'];
                $item['title'] = $item['title'];
            }

            file_put_contents($sStreamFile, serialize($aActivities));

            // ...
            file_put_contents($sStreamFile.'-news', serialize($aActivities['news']));
            file_put_contents($sStreamFile.'-article', serialize($aActivities['article']));
            file_put_contents($sStreamFile.'-story', serialize($aActivities['story']));
        }

        // echo count($aActivities);
        // print_r($aActivities);

        $i = 0;
        foreach ($aActivities as $key => $val) {
            // echo $i.'.'.$sItemKey = $val['ctrl'].'-'.$val['id'].'<br>';
            $i++;
        }

        $aReducedItems = array();
        $aUniqueActivities = array();
        foreach ($aActivities as $key => $val) {
            // $sItemKey = $val['ctrl'].'-'.$val['id'];
            // if (!isset($aReducedItems[$sItemKey])) {
            //     $aReducedItems[$sItemKey] = true;
            //     $aUniqueActivities[] = $val;
            // }
        }

        // $aActivities = $aUniqueActivities;

        // echo count($aUniqueActivities);

        $this->_renderer->assign('aActivities', $aActivities);

        // $aImages = array();
        // $aBackgrounds = array();
        // foreach ($aActivities['news'] as $ak => $a) {
        //     if (!isset($a['ctrl'])) {
        //         $sql = 'SELECT ni.*
        //                 FROM news_image ni
        //                 WHERE id_news = '.$a['id_news'].'';

        //         $oImageCollection = Dao::collection('news-image');
        //         $oImageCollection->query($sql);

        //         $aImages[$a['id_news']] = $oImageCollection->getRows();

        //         $aBackgrounds[$a['id_news']] = current($oImageCollection->getRows());
        //     }
        // }
        // $this->_renderer->assign('aImages', $aImages);
        // $this->_renderer->assign('aBackgrounds', $aBackgrounds);
    }

    protected function _runBeforeFill() {

    }
}