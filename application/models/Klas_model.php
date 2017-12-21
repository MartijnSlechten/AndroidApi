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

    /*
    function getAllSoortProduct()
    {
        $this->db->order_by('naam', 'asc');
        $query = $this->db->get('bier_soort');
        $soorten = $query->result();

        $this->load->model('product_model');

        foreach ($soorten as $soort) {
            $soort->producten =
                $this->product_model->getAllBySoort($soort->id);
        }
        return $soorten;
    }

    function insert($soort)
    {
        $this->db->insert('bier_soort', $soort);
        return $this->db->insert_id();
    }

    function update($soort)
    {
        $this->db->where('id', $soort->id);
        $this->db->update('bier_soort', $soort);
    }

    function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('bier_soort');
    }
*/
}
