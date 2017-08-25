<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\ValueMapper;

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
            $aActivities['news'] = $oNewsCollection->getNewsForStream(5);

            // articles
            $oArticleCollection = Dao::collection('article');
            $aActivities['article'] = $oArticleCollection->getArticlesForStream(5);

            // stories
            $oStoryCollection = Dao::collection('story');
            $aActivities['story'] = $oStoryCollection->getStoriesForStream(5);

            $oNewsImageEntity = Dao::entity('news-image');

            // ksort($aActivities)
            foreach ($aActivities['news'] as &$item) {
                $item['key'] = 'id_news';
                $item['type'] = 'news';
                $item['category_name'] = '';
                $item['url'] = ValueMapper::getUrl('news').'/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug'];

                $imageItem = $oNewsImageEntity->getFirstImage($item['id_news']);
                if ($imageItem) {
                    $item['fragment'] = $imageItem['name'];
                }
            }

            foreach ($aActivities['article'] as &$item) {
                $item['key'] = 'id_article';
                $item['type'] = 'article';
                $item['url'] = ValueMapper::getUrl('article').'/'.$item['category_slug'].'/'.$item['slug'];
            }

            foreach ($aActivities['story'] as &$item) {
                $item['key'] = 'id_story';
                $item['type'] = 'story';
                $item['url'] = ValueMapper::getUrl('story').'/'.$item['category_slug'].'/'.$item['slug'];
            }

            file_put_contents($sStreamFile, serialize($aActivities));

            file_put_contents($sStreamFile.'-news', serialize($aActivities['news']));
            file_put_contents($sStreamFile.'-article', serialize($aActivities['article']));
            file_put_contents($sStreamFile.'-story', serialize($aActivities['story']));
        }

        $this->_renderer->assign('activities', $aActivities);
    }

    protected function _runBeforeFill() {

    }
}