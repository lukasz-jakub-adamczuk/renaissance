<?php

namespace Renaissance\View;

use Aya\Core\Dao;
use Aya\Core\View;

class UserIndexView extends View {

    public function fill() {
        $names = [];
        $names[] = 'Aktualności';
        $names[] = 'Artykuły';
        $names[] = 'Publicystyka';
        $names[] = 'Komentarze aktualności';
        $names[] = 'Komentarze artykułów';
        $names[] = 'Komentarze publicystyki';
        $names[] = 'Oceny gier';

        $users = [];
        $users[] = Dao::collection('news')->mostActiveAuthors();
        $users[] = Dao::collection('article')->mostActiveAuthors();
        $users[] = Dao::collection('story')->mostActiveAuthors();
        $users[] = Dao::collection('comment')->mostActiveAuthors('news');
        $users[] = Dao::collection('comment')->mostActiveAuthors('article');
        $users[] = Dao::collection('comment')->mostActiveAuthors('story');
        $users[] = Dao::collection('article-verdict')->mostActiveAuthors();

        $this->_renderer->assign('names', $names);
        $this->_renderer->assign('users', $users);
    }
}