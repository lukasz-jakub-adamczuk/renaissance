<?php
require_once AYA_DIR.'/Core/View.php';

class CupIndexView extends View {

    public function fill() {
        // $sql = 'SELECT COUNT(id_cup) AS matches, id_cup AS id, MIN(day) AS start, MAX(day) AS end, 32*(id_cup-1) AS page, 64*(id_cup-1) AS page2
  //                                   FROM cup_battle
  //                                   GROUP BY id_cup
  //                                   ORDER BY day ';
        $sql = 'SELECT *
                FROM cup
                ORDER BY id_cup DESC';

        $oCollection = Dao::collection('cup_battle', null, array('id' => 'id_cup'));
        $oCollection->query($sql);

        $aCups = $oCollection->getRows();

        // foreach ($aCups as &$cup) {
        //     $cup['type'] = strc
        // }

        $this->_renderer->assign('aCups', $aCups);
        $this->_renderer->assign('aNavigator', $oCollection->getNavigator());
    }
}