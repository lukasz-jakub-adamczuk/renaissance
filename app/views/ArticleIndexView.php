<?php
require_once AYA_DIR.'/Core/View.php';

class ArticleIndexView extends View {

    public function fill() {
        // $sql = 'SELECT c.*, COUNT(a.id_article) items, c.id_article_category, f.fragment
        $sql = 'SELECT c.*, c.id_article_category, f.fragment
                -- FROM article a 
                FROM article_category c
                -- LEFT JOIN article_category c ON(c.id_article_category=a.id_article_category)
                
                LEFT OUTER JOIN object_fragment of ON(of.id_object=c.id_article_category)
                LEFT JOIN fragment f ON(f.id_fragment=of.id_fragment)
                
                -- WHERE f.id_fragment_type = 2 AND f.id_object = a.id_article AND f.id_object = "article" AND a.slug = "recenzja"
                -- WHERE f.id_fragment_type = 2 AND of.object = "article_category"
                -- WHERE of.object = "article_category"
                WHERE c.visible = 1
                -- GROUP BY a.id_article_category
                ORDER BY c.idx';

        $oCollection = Dao::collection('article-category');
        $oCollection->query($sql);

        // print_r($oCollection->getRows());

        $this->_renderer->assign('aCategories', $oCollection->getRows());
    }
}