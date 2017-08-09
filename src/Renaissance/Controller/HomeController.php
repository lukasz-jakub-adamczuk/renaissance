<?php

namespace Renaissance\Controller;

use Renaissance\Controller\FrontController;
use Renaissance\Helper\CupManager;

class HomeController extends FrontController {

    public function indexAction() {
        $cupManager = new CupManager();

        $cupManager->manageCalculationProcess();
        
        // current battle details
        $this->_renderer->assign('cupBattle', $cupManager->getCurrentBattle());
        
        // can user vote on current battle
        $this->_renderer->assign('canVote', $cupManager->canUserVote());
    }
}
