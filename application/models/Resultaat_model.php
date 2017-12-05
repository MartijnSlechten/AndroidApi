<?php

class Resultaat_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
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

    function insertVoormetingen() {
        $getal1 = rand(1,10);
        $duur =  rand(1,11) . ":" . rand(1,59) . ":" . rand(1,59);
        $voormeting = new stdClass();
        $voormeting->aantalJuist = $getal1;
        $voormeting->aantalFout = 10-$getal1;
        $voormeting->aantalTotaal = 10;
        $voormeting->duur = $duur;
        $voormeting->datum = date("Y-m-d");

        $this->db->insert('voormetingen',$voormeting);
        return $this->db->insert_id();
    }
    function insertNametingen() {
        $getal1 = rand(1,10);
        $duur =  rand(1,11) . ":" . rand(1,59) . ":" . rand(1,59);
        $voormeting = new stdClass();
        $voormeting->aantalJuist = $getal1;
        $voormeting->aantalFout = 10-$getal1;
        $voormeting->aantalTotaal = 10;
        $voormeting->duur = $duur;
        $voormeting->datum = date("Y-m-d");

        $this->db->insert('nametingen',$voormeting);
        return $this->db->insert_id();
    }

}
