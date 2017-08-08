<?php

class CommentController extends CrudController {

    public function removeAction() {
        if (isset($_GET['id'])) {
            $aIds = array($_GET['id']);
        }
        if (isset($_POST['ids'])) {
            $aIds = $_POST['ids'];
        }
        
        if (isset($aIds)) {
            $aNames = array();
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
                    $this->addHistoryLog('remove', $this->_ctrlName, $id);
                    $aNames[] = $name;
                }
            }

            // msg
            if (count($aNames) == 1) {
                $this->raiseInfo('Wpis <strong>'.$aNames[0].'</strong> został usunięty.');
            } elseif (count($aNames) > 1) {
                $this->raiseInfo('Wpisy <strong>'.implode(', ', $aNames).'</strong> zostały usunięte.');
            } else {
                $this->raiseError('Wystąpił nieoczekiwany wyjątek.');
            }
            // 
            $aParams = array();
            $aParams['get:category'] = 'tomb-raider';
            $aParams['get:slug'] = 'recenzja';

            // print_r($aParams);

            $this->actionForward('info', 'article', true, $aParams);
        }
    }
}