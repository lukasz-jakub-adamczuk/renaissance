<?php

class Breadcrumbs {

    static private $_aValues = array();

    static public function add($sUrl, $sTitle) {
        $aItem = array();
        $aItem['url'] = $sUrl;
        $aItem['title'] = $sTitle;
        self::$_aValues[] = $aItem;
    }

    static public function get() {
        return self::$_aValues;
    }
}