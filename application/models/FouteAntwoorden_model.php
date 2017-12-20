<?php

class FouteAntwoorden_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insertFouteAntwoorden($metingId, $woordId, $isVoormeting) {
        $foutWoord = new stdClass();
        $foutWoord->metingId = $metingId;
        $foutWoord->woordId = $woordId;
        $foutWoord->isVoormeting = $isVoormeting;

        $this->db->insert('fouteAntwoorden', $foutWoord);
    }


}
