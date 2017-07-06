<?php

class HomeController extends FrontController {

    public function indexAction() {
        require_once APP_DIR.'/helpers/CupManager.php';

        $cupManager = new CupManager();

        $cupManager->manageCalculationProcess();
        
        // current battle details
        $this->_renderer->assign('aMatch', $cupManager->getCurrentBattle());
        
        // can user vote on current battle
        $this->_renderer->assign('canVote', $cupManager->canUserVote());
    }
}
