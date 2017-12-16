<?php

class WoordEigenschappen_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function getJuisteEigenschappen_byWoordId($woordId)
    {
        $this->db->where('woordId', $woordId);
        $query = $this->db->get('woordEigenschappen');
        $result = $query->result();
//        shuffle($result);
        return $result;
    }
    function getFouteEigenschap_byWoordId($woordId)
    {
        $this->db->where('woordId !=', $woordId);
        $query = $this->db->get('woordEigenschappen');
        $result = $query->result();
        $randomGetal = rand(0,count($result)-1);
        return $result[$randomGetal];
    }

}
