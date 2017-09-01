<?php

namespace Renaissance\Controller;

use Aya\Core\Dao;
use Aya\Helper\ChangeLog;

class CommentController extends FrontController {

    public function acceptAction() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($id) {
            $this->_changeStatusField('visible', 1);

            header('Location: '.$_SERVER['HTTP_REFERER'].'#komentarz-'.$id, TRUE, 303);
        }
    }

    public function removeAction() {
        if (isset($_GET['id'])) {
            $aIds = array($_GET['id']);
        }
        
        if (isset($aIds)) {
            $aNames = [];
            foreach ($aIds as $id) {
                $oEntity = Dao::entity($this->_ctrlName, $id, 'id_'.$this->_ctrlName);

                $aPossibleNameKeys = array('title', 'name');
                foreach ($aPossibleNameKeys as $key) {
                    if ($oEntity->hasField($key)) {
                        $name = $oEntity->getField($key);
                    } else {
                        $name = $id;
                    }
                }
                
                if ($oEntity->delete()) {
                    // $this->addHistoryLog('remove', $this->_ctrlName, $id);
                    ChangeLog::add('delete', $this->_ctrlName, $id);
                    $aNames[] = $name;
                }
            }

            // msg
            if (count($aNames) == 1) {
                $this->raiseInfo('Komentarz <strong>'.$aNames[0].'</strong> został usunięty.');
            } else {
                $this->raiseError('Wystąpił nieoczekiwany wyjątek.');
            }

            // $aParams = [];
            // foreach ($aPost['request'] as $key => $value) {
            //     $aParams['get:'.$key] = $value;
            // }

            // // redirect to right page after comment
            // $redirectParams = [];

            // foreach ($aPost['request'] as $pk => $param) {
            //     if ($pk === 'ctrl') {
            //         $redirectParams[] = ValueMapper::getUrl($param);
            //     } elseif ($pk === 'act') {
            //         // ignore
            //     } else {
            //         $redirectParams[] = $param;
            //     }
            // }

            header('Location: '.$_SERVER['HTTP_REFERER'].'#komentarze', TRUE, 303);

            // $this->actionForward('info', $aPost['request']['ctrl'], true, $aParams);

            // $this->actionForward('info', 'article', true, $aParams);
        }
    }
}