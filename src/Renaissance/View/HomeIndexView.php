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
            $entries = unserialize(file_get_contents($sStreamFile));
        } else {
            // echo 'from db';
            $frontItems = 7;
            // news
            $oNewsCollection = Dao::collection('news');
            $entries['news'] = $oNewsCollection->getNewsForStream($frontItems);

            // articles
            $oArticleCollection = Dao::collection('article');
            $entries['article'] = $oArticleCollection->getArticlesForStream($frontItems);

            // stories
            $oStoryCollection = Dao::collection('story');
            $entries['story'] = $oStoryCollection->getStoriesForStream($frontItems);

            $oNewsImageEntity = Dao::entity('news-image');

            // ksort($entries)
            foreach ($entries['news'] as &$item) {
                $item['key'] = 'id_news';
                $item['type'] = 'news';
                $item['category_name'] = '';
                $item['url'] = ValueMapper::getUrl('news').'/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug'];

                $imageItem = $oNewsImageEntity->getFirstImage($item['id_news']);
                if ($imageItem) {
                    $item['fragment'] = $imageItem['name'];
                }
            }

            foreach ($entries['article'] as &$item) {
                $item['key'] = 'id_article';
                $item['type'] = 'article';
                $item['url'] = ValueMapper::getUrl('article').'/'.$item['category_slug'].'/'.$item['slug'];
            }

            foreach ($entries['story'] as &$item) {
                $item['key'] = 'id_story';
                $item['type'] = 'story';
                $item['url'] = ValueMapper::getUrl('story').'/'.$item['category_slug'].'/'.$item['slug'];
            }

            file_put_contents($sStreamFile, serialize($entries));

            file_put_contents($sStreamFile.'-news', serialize($entries['news']));
            file_put_contents($sStreamFile.'-article', serialize($entries['article']));
            file_put_contents($sStreamFile.'-story', serialize($entries['story']));
        }

        $this->_renderer->assign('activities', $entries);
    }

    protected function _runBeforeFill() {

    }
}