<?php

class Woord_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('woorden');
        return $query->row();
    }

    public function getWoordId_ByNaam($woord) {
        $this->db->where('naam', $woord);
        $query = $this->db->get('woorden');
        return $query->row()->id;
    }

    function getAll($groep) {
        $this->db->order_by('naam', 'asc');
//        $this->db->where('groep',10);
        $query = $this->db->get('woorden');
        $result = $query->result_array();
        shuffle($result);
        return $result;
    }

    function getAll_objecten($groep) {
        $this->db->order_by('naam', 'asc');
//        $this->db->where('groep',10);
        $query = $this->db->get('woorden');
        return $query->result();
    }

    function getAnderWoord_AtRandom($woordId){
        $this->db->where('id !=', $woordId);
        $query = $this->db->get('woorden');
        $andereWoorden = $query->result();
        $randomGetal = rand(0,sizeof($andereWoorden)-1);
        return $andereWoorden[$randomGetal];
    }


}
