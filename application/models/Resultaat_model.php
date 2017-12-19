<?php

class Resultaat_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_countMetingen() {
        $this->db->where('nametingDatum is NOT NULL', NULL, FALSE);
        return $this->db->count_all_results('meting');
    }

    function get_eenAantalMetingen($aantal) {
        $this->db->where('nametingDatum IS NOT NULL', null, false);
        $this->db->order_by('id', 'desc');
        // enkel limit instellen wanneer het 'aantal' een cijfer is (wat niet het geval is bij 'get_eenAantalMetingen("alles")'
        if ($aantal != "alles") {
            $this->db->limit($aantal);
        }
        $query = $this->db->get('meting');

        // een rij of rijen terug geven
        if ($aantal == 1) {
            return $query->row();
        }
        else {
            return $query->result();
        }
    }

    function get_soortMeting_byMetingId($metingId, $soortMeting) {
        $this->db->where('metingId', $metingId);
        $query = $this->db->get($soortMeting);
        return $query->row();
    }

    function get_metingenOpDatum($zoekstring) {
        $this->db->where('nametingDatum is NOT NULL', NULL, FALSE);
        $this->db->like('nametingDatum', $zoekstring, 'after');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('meting');
        return $query->result();
    }

    function insertMeting($datum1, $naam, $klasId, $groep) {
        $meting = new stdClass();
        $meting->voormetingDatum = $datum1->format('Y-m-d H:i:s');
        $meting->nametingDatum = null;
        $meting->naam = $naam;
        $meting->klasId = $klasId;
        $meting->groep = $groep;

        $this->db->insert('meting', $meting);
        return $this->db->insert_id();
    }

    function updateMeting($datum, $metingId) {
        // de nametinDatum van de meting updaten wanneer het een nameting is
        // (tijdens een insert van meting bij voormeting is de nametingDatum null)
        $meting = new stdClass();
        $meting->nametingDatum = $datum->format('Y-m-d H:i:s');
        $this->db->where('id', $metingId);
        $this->db->update('meting', $meting);
    }

    function insertVoormeting($metingId, $meting) {
        $voormeting = new stdClass();
        $voormeting->metingId = $metingId;
        $voormeting->aantalJuist = $meting->juist;
        $voormeting->aantalFout = $meting->fout;
        $voormeting->aantalTotaal = $meting->totaal;
        $voormeting->duur = $meting->duur;

        $this->db->insert('voormetingen', $voormeting);
    }

    function insertNameting($metingId, $meting) {
        $nameting = new stdClass();
        $nameting->metingId = $metingId;
        $nameting->aantalJuist = $meting->juist;
        $nameting->aantalFout = $meting->fout;
        $nameting->aantalTotaal = $meting->totaal;
        $nameting->duur = $meting->duur;

        $this->db->insert('nametingen', $nameting);
    }


    // testdata genereren
    function insertMetingen($datum1, $datum2) {
        $meting = new stdClass();
        $meting->voormetingDatum = $datum1->format('Y-m-d H:i:s');
        $meting->nametingDatum = $datum2->format('Y-m-d H:i:s');
        $this->db->insert('meting', $meting);
        return $this->db->insert_id();
    }

    function insertVoormetingen($metingId) {
        $getal1 = rand(1, 7);
        $duur = "0:" . rand(1, 35) . ":" . rand(1, 59);

        $voormeting = new stdClass();
        $voormeting->metingId = $metingId;
        $voormeting->aantalJuist = $getal1;
        $voormeting->aantalFout = 10 - $getal1;
        $voormeting->aantalTotaal = 10;
        $voormeting->duur = $duur;

        $this->db->insert('voormetingen', $voormeting);
    }

    function insertNametingen($metingId) {
        $getal1 = rand(2, 10);
        $duur = "0:" . rand(1, 25) . ":" . rand(1, 39);

        $nameting = new stdClass();
        $nameting->metingId = $metingId;
        $nameting->aantalJuist = $getal1;
        $nameting->aantalFout = 10 - $getal1;
        $nameting->aantalTotaal = 10;
        $nameting->duur = $duur;

        $this->db->insert('nametingen', $nameting);
    }

}
