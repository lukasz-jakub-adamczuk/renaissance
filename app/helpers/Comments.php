<?php

class Comments {

    static public function getFormParams($sCtrl, $oEntity) {
        $sIdLabel = 'id_'.$sCtrl;

        $aCommentsForm = array();
        $aCommentsForm['request'] = Comments::_createFormParams($sCtrl, $oEntity);
        // value from request is mapped
        $aCommentsForm['request']['ctrl'] = $sCtrl;

        $aCommentsForm['object'] = $sIdLabel;
        $aCommentsForm['id_object'] = $oEntity->getField($sIdLabel);

        return $aCommentsForm;
    }

    static private function _createFormParams($sCtrl, $oEntity) {
        // ...
        $sMethod = '_get'.ucfirst($sCtrl).'ConfigParams';
        $aParams = Comments::$sMethod();

        $aRequestParams = array();
        if ($aParams['request']) {
            foreach ($aParams['request'] as $value) {
                $aRequestParams[$value] = isset($_GET[$value]) ? strip_tags($_GET[$value]) : null;
            }
        }
        if ($aParams['entity']) {
            foreach ($aParams['entity'] as $key => $value) {
                $aRequestParams[$key] = $oEntity->hasField($value) ? $oEntity->getField($value) : null;
            }
        }
        return $aRequestParams;
    }

    static private function _getNewsConfigParams() {
        $aConfigParams = array(
            'request' => array(
                'ctrl', 'act', 'year', 'month', 'day'
            ),
            'entity' => array(
                'slug' => 'slug'
            )
        );
        return $aConfigParams;
    }

    static private function _getArticleConfigParams() {
        $aConfigParams = array(
            'request' => array(
                'ctrl', 'act'
            ),
            'entity' => array(
                'category' => 'category_slug',
                'slug' => 'slug'
            )
        );
        return $aConfigParams;
    }

    static private function _getStoryConfigParams() {
        $aConfigParams = array(
            'request' => array(
                'ctrl', 'act'
            ),
            'entity' => array(
                'category' => 'category_slug',
                'slug' => 'slug'
            )
        );
        return $aConfigParams;
    }

    static private function _getGalleryConfigParams() {
        $aConfigParams = array(
            'request' => array(
                'ctrl', 'act'
            ),
            'entity' => array(
                'category' => 'category_slug',
                'slug' => 'slug'
            )
        );
        return $aConfigParams;
    }

    static private function _getUserConfigParams() {
        $aConfigParams = array(
            'request' => array(
                'ctrl', 'act'
            ),
            'entity' => array(
                // 'category' => 'category_slug',
                'slug' => 'slug'
            )
        );
        return $aConfigParams;
    }
}