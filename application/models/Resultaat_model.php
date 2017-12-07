<?php

class Resultaat_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_countMetingen()
    {
        $this->db->where('nametingDatum is NOT NULL', NULL, FALSE);
        return $this->db->count_all_results('meting');
    }

    function get_laatsteMetingen($aantal)
    {
//        $this->db->where('nametingDatum is NOT NULL', NULL, FALSE);
        $this->db->order_by('voormetingDatum', 'desc');
        $this->db->limit($aantal);
        $query = $this->db->get('meting');

        // een rij of rijen terug geven
        if ($aantal == 1) {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    function get_soortMeting_byMetingId($id, $soortMeting)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($soortMeting);
        return $query->row();
    }



//    function get_laatsteMetingen($aantal,$soortMeting) {
//        $this->db->order_by('datum', 'desc');
//        $this->db->limit($aantal);
//
//        $query = $this->db->get($soortMeting);
//
//        // een rij of rijen terug geven
//        if($aantal == 1){
//            return $query->row();
//        }else{
//            return $query->result();
//        }
//    }

    function get_metingenOpDatum($zoekstring)
    {
        $this->db->where('nametingDatum is NOT NULL', NULL, FALSE);
        $this->db->like('nametingDatum', $zoekstring, 'after');
        $this->db->order_by('voormetingDatum', 'desc');
        $query = $this->db->get('meting');
        return $query->result();
    }


//    function get($id)
//    {
//        $this->db->where('id', $id);
//        $query = $this->db->get('woorden');
//        return $query->row();
//    }
//
//    function getAll()
//    {
//        $this->db->order_by('naam', 'asc');
//        $query = $this->db->get('woorden');
//        $result = $query->result_array();
//        shuffle($result);
//        return $result;
//    }


//    testdata genereren

    function insertMetingen($datum1, $datum2)
    {
        $meting = new stdClass();
        $meting->voormetingDatum = $datum1->format('Y-m-d H:i:s');
        $meting->nametingDatum = $datum2->format('Y-m-d H:i:s');
        $this->db->insert('meting', $meting);
        return $this->db->insert_id();
    }

    function insertVoormetingen($metingId)
    {
        $getal1 = rand(1, 10);
        $duur = "0:" . rand(1, 30) . ":" . rand(1, 59);

        $voormeting = new stdClass();
        $voormeting->metingId = $metingId;
        $voormeting->aantalJuist = $getal1;
        $voormeting->aantalFout = 10 - $getal1;
        $voormeting->aantalTotaal = 10;
        $voormeting->duur = $duur;

        $this->db->insert('voormetingen', $voormeting);
    }

    function insertNametingen($metingId)
    {
        $getal1 = rand(1, 10);
        $duur = "0:" . rand(1, 30) . ":" . rand(1, 59);

        $voormeting = new stdClass();
        $voormeting->metingId = $metingId;
        $voormeting->aantalJuist = $getal1;
        $voormeting->aantalFout = 10 - $getal1;
        $voormeting->aantalTotaal = 10;
        $voormeting->duur = $duur;

        $this->db->insert('nametingen', $voormeting);
    }

}
