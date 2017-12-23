<?php

class Klas_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('klas');
        return $query->row();
    }
    function getByNaam($klasNaam)
    {
        $this->db->where('naam', $klasNaam);
        $query = $this->db->get('klas');
        return $query->row()->id;
    }

    function getAll()
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('klas');
        return $query->result();
    }

    function getAll_objecten()
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('klas');
        return $query->result();
    }

    public function insertKlas($klasNaam){
        $klas = new stdClass();
        $klas->naam = $klasNaam;
        $this->db->insert('klas',$klas);
    }
    public function getDropdownOptions(){
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('klas');
        $klassen =  $query->result();
        $dropdownOptions = array('0'=>'zoek op klas');
        foreach ($klassen as $klas){
            $dropdownOptions[$klas->id] = $klas->naam;
        }
        return $dropdownOptions;
    }

}
