<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Woord extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

    }

    public function get($id)
    {
        $this->load->model('woord_model');
        $object = $this->woord_model->get($id);
        echo json_encode($object);
    }

    public function getAll()
    {
        $this->load->model('woord_model');
        $objecten = $this->woord_model->getAll();
        echo json_encode($objecten);
    }



    /*
    public function schrijfJSONObject()
    {
        $object = new stdClass();
        $object->id = $this->input->post('id');
        $object->naam = $this->input->post('naam');

        $this->load->model('soort_model');
        if ($object->id == 0) {
            $this->soort_model->insert($object);
        } else {
            $this->soort_model->update($object);
        }

        echo 0;
    }
    */
}