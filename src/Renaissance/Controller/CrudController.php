<?php

namespace Renaissance\Controller;

use Aya\Core\Dao;

use Renaissance\Controller\FrontController;

class CrudController extends FrontController {
    
    public function insertAction() {
        $id = 0;

        $aPost = $this->beforeInsert();

        $oEntity = Dao::entity($this->_ctrlName, $id);
        
        $oEntity->setFields($aPost['dataset']);

        $aPossibleNameKeys = array('title', 'name');
        foreach ($aPossibleNameKeys as $key) {
            if (isset($aPost['dataset'][$key])) {
                $name = $aPost['dataset'][$key];
                break;
            }
        }

        // slug by used name if empty or changed name
        if (isset($name) && isset($aPost['dataset']['slug']) && (empty($aPost['dataset']['slug']) || $aPost['dataset']['slug'] != Text::slugify($name))) {
            $oEntity->setField('slug', Text::slugify($name));
        }

        // no creation date
        // TODO or creation date invalid
        if (empty($aPost['dataset']['creation_date'])) {
            $oEntity->setField('creation_date', date('Y-m-d H:i:s'));
        }
        // if mod_date comes somehow
        if (empty($aPost['dataset']['modification_date'])) {
            $oEntity->unsetField('modification_date');
        }
        
        if ($id = $oEntity->insert(true)) {
            $this->afterInsert($id);
            // clear cache
            $sSqlCacheFile = TMP_DIR . '/sql/collection/'.$this->_ctrlName.'-'.$this->_sActionName.'';

            $this->raiseInfo('Wpis '.(isset($name) ? '<strong>'.$name.'</strong>' : '').' został utworzony.');

            $this->addHistoryLog('create', $this->_ctrlName, $id);

            $this->actionForward('index', $this->_ctrlName, true);
        } else {
            $this->raiseError('Wystąpił nieoczekiwany wyjątek.');
            $this->actionForward('info', $this->_ctrlName);
        }
    }
    
    public function updateAction() {
        // lock handling
        if (Lock::exists($this->_ctrlName, (int)$_GET['id'])) {
            $sLock = Lock::get($this->_ctrlName, (int)$_GET['id']);
            $aLockParts = explode(':', $sLock);
            if ($aLockParts[0] != $_SESSION['user']['id']) {
                $this->_renderer->assign('aLock', array('id' => $aLockParts[0], 'name' => $aLockParts[1]));
            }
        } else {
            Lock::set($this->_ctrlName, (int)$_GET['id'], $_SESSION['user']);
        }

        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        
        $oEntity = Dao::entity($this->_ctrlName, $id, 'id_'.$this->_ctrlName);
        
        $oEntity->setFields($_POST['dataset']);

        $aPossibleNameKeys = array('title', 'name');
        foreach ($aPossibleNameKeys as $key) {
            if (isset($_POST['dataset'][$key])) {
                $name = $_POST['dataset'][$key];
                break;
            }
        }

        // slug by used name if empty or changed name
        if (isset($_POST['dataset']['slug']) && (empty($_POST['dataset']['slug']) || $_POST['dataset']['slug'] != Text::slugify($name))) {
            $oEntity->setField('slug', Text::slugify($name));
        }

        if (isset($_POST['dataset']['modification_date'])) {
            if ($_POST['dataset']['modification_date'] == '') {
                $oEntity->setField('modification_date', date('Y-m-d H:i:s'));
            }
        }
        
        if ($oEntity->update()) {
            $sEditUrl = BASE_URL.'/'.$this->_ctrlName.'/'.$id;
            if (isset($name)) {
                $this->raiseInfo('Wpis '.(isset($name) ? '<strong>'.$name.'</strong>' : '').' został zmieniony. <a href="'.$sEditUrl.'">Edytuj</a> ponownie.');
            } else {
                $this->raiseInfo('Wpis został zmieniony. <a href="'.$sEditUrl.'">Edytuj</a> ponownie.');
            }

            $this->addHistoryLog('update', $this->_ctrlName, $id);

            $this->afterUpdate($id);
            
            $this->actionForward('index', $this->_ctrlName, true);
        } else {
            $this->raiseError('Wystąpił nieoczekiwany wyjątek.');
            $this->actionForward('info', $this->_ctrlName);
        }
    }

    public function deleteAction() {
        if (isset($_GET['id'])) {
            $aIds = array($_GET['id']);
        }
        if (isset($_POST['ids'])) {
            $aIds = $_POST['ids'];
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

                $oEntity->setField('deleted', '1');
                
                if ($oEntity->update()) {
                    $this->addHistoryLog('delete', $this->_ctrlName, $id);
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
            // $this->actionForward('index', $this->_ctrlName, true);
        }
    }

    public function removeAction() {
        if (isset($_GET['id'])) {
            $aIds = array($_GET['id']);
        }
        if (isset($_POST['ids'])) {
            $aIds = $_POST['ids'];
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
            // $this->actionForward('index', $this->_ctrlName, true);
        }
    }

    // action hooks

    public function beforeInsert() {
        return $_POST;
    }

    public function afterInsert($id) {}

    public function beforeUpdate() {}

    public function afterUpdate($id) {}

    public function fetchTemplateAction() {
        $sPath = isset($_GET['path']) ? str_replace(',', '/', strip_tags($_GET['path'])) : null;

        if ($sPath) {
            $this->setContentType('template');

            $this->setTemplateName($sPath);
        }
    }

    // additional common tasks 

    public function addHistoryLog($sActionType, $sTableName, $id, $sLog = '') {
        $oEntity = Dao::entity('change_log');

        $sUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;

        $oEntity->setField('id_author', $sUser);
        $oEntity->setField('id_record', $id);
        $oEntity->setField('table', $sTableName);
        $oEntity->setField('log', $sLog);
        $oEntity->setField('creation_date', date('Y-m-d H:i:s'));
        $oEntity->setField('type', $sActionType);

        $oEntity->insert();
    }

    // private methods

    protected function _changeStatusField($sField, $mValue) {
        $id = $_GET['id'];
        
        $oEntity = Dao::entity($this->_ctrlName, $id, 'id_'.$this->_ctrlName);
        
        $oEntity->setField($sField, $mValue);

        $name = $id;
        $aPossibleNameKeys = array('title', 'name');
        foreach ($aPossibleNameKeys as $key) {
            if (isset($_POST['dataset'][$key])) {
                $name = $_POST['dataset'][$key];
                break;
            }
        }
        
        if ($oEntity->update()) {
            // $this->afterUpdate($id);

            $sEditUrl = BASE_URL.'/'.$this->_ctrlName.'/'.$id;
            if (isset($name)) {
                $this->raiseInfo('Wpis '.(isset($name) ? '<strong>'.$name.'</strong>' : '').' został zmieniony. <a href="'.$sEditUrl.'">Edytuj</a> ponownie.');
            } else {
                $this->raiseInfo('Wpis został zmieniony. <a href="'.$sEditUrl.'">Edytuj</a> ponownie.');
            }

            $this->addHistoryLog('change', $this->_ctrlName, $id);

            $this->afterUpdate($id);
            
            $this->actionForward('index', $this->_ctrlName, true);
        } else {
            $this->raiseError('Wystąpił nieoczekiwany wyjątek.');
            $this->actionForward('info', $this->_ctrlName);
        }
    }

    public function raiseInfo($sMessage) {
        $aMsg = [];
        $aMsg['text'] = $sMessage;
        $aMsg['type'] = 'info';
        MessageList::add($aMsg);
    }

    public function raiseWarning($sMessage) {
        $aMsg = [];
        $aMsg['text'] = $sMessage;
        $aMsg['type'] = 'warning';
        MessageList::add($aMsg);
    }

    public function raiseError($sMessage) {
        $aMsg = [];
        $aMsg['text'] = $sMessage;
        $aMsg['type'] = 'alert';
        MessageList::add($aMsg);
    }
}