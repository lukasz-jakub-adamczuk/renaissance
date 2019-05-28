<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;
use Aya\Helper\ValueMapper;
use Renaissance\Helper\CupManager;

class HomeIndexView extends View {

    public function fill() {
        $streamFile = CACHE_DIR . '/stream';
        if (CACHE_OUTPUT && file_exists($streamFile)) {
        // if (file_exists($streamFile)) {
            $entries = unserialize(file_get_contents($streamFile));
        } else {
            $newsStreamFile = CACHE_DIR . '/stream-news';
            $articleStreamFile = CACHE_DIR . '/stream-article';
            $storyStreamFile = CACHE_DIR . '/stream-story';

            $frontItems = 5;
            $entries = [];

            // news
            if (file_exists($newsStreamFile)) {
                $entries['news'] = unserialize(file_get_contents($newsStreamFile));
            } else {
                $newsCollection = Dao::collection('news');
                $entries['news'] = $newsCollection->getNewsForStream($frontItems);

                $oNewsImageEntity = Dao::entity('news-image');
            
                foreach ($entries['news'] as &$item) {
                    $imageItem = $oNewsImageEntity->getFirstImage($item['id_news']);
                    if ($imageItem) {
                        $item['fragment'] = $imageItem['name'];
                    }
                }
            
                file_put_contents($newsStreamFile, serialize($entries['news']));
            }
            print_r($entries['news']);

            // articles
            if (file_exists($articleStreamFile)) {
                $entries['article'] = unserialize(file_get_contents($articleStreamFile));
            } else {
                $articleCollection = Dao::collection('article');
                $entries['article'] = $articleCollection->getArticlesForStream($frontItems);

                file_put_contents($articleStreamFile, serialize($entries['article']));
            }

            // stories
            if (file_exists($storyStreamFile)) {
                $entries['story'] = unserialize(file_get_contents($storyStreamFile));
            } else {
                $storyCollection = Dao::collection('story');
                $entries['story'] = $storyCollection->getArticlesForStream($frontItems);

                file_put_contents($storyStreamFile, serialize($entries['story']));
            }

            // creating urls
            foreach ($entries['news'] as &$item) {
                $item['key'] = 'id_news';
                $item['type'] = 'news';
                $item['category_name'] = '';
                $item['url'] = ValueMapper::getUrl('news').'/'.str_replace('-', '/', substr($item['creation_date'], 0, 10)).'/'.$item['slug'];
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

            file_put_contents($streamFile, serialize($entries));            
        }
        echo 'test';

        $this->_renderer->assign('activities', $entries);

        // cup
       $cupManager = new CupManager();
        // print_r($cupManager);
        // methods for debug fixing
        // $cupManager->clearingAllPlayersStats();
        // $cupManager->calculateGroupPhaseMatchesStats();
        // $cupManager->validatePlayersStats();
        // echo '.';
        // $cupManager->clearAllBattlesCache();
        
       $cupManager->manageGroupPhase();
       $cupManager->manageCupPhase();

        // var_dump($cupManager->getCurrentBattle());
        
        $this->_renderer->assign('cupBattle', $cupManager->getCurrentBattle());
        $this->_renderer->assign('canVote', $cupManager->canUserVote());
    }

    protected function _runBeforeFill() {

    }
}