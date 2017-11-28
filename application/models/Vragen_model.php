<?php

class Vragen_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getAll()
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('bmw_auto');
        return $query->result();
    }

}

?>