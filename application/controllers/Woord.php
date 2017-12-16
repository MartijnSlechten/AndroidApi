<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Woord extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }

    public function get($id) {
        $this->load->model('Woord_model');
        $object = $this->Woord_model->get($id);
        echo json_encode($object);
    }

    public function getAll() {
        $this->load->model('Woord_model');
        $objecten = $this->Woord_model->getAll();
        echo json_encode($objecten);
    }

    public function getWoordenMetEigenschappen() {
        $woordObjecten = new stdClass();
        $this->load->model('Woord_model');
        $this->load->model('WoordEigenschappen_model');
        $woordObjecten = $this->Woord_model->getAll_objecten();

        foreach ($woordObjecten as $woordObject) {
            $woordObject->juisteEigenschappen = $this->WoordEigenschappen_model->getJuisteEigenschappen_byWoordId($woordObject->id);
            $woordObject->fouteEigenschap = $this->WoordEigenschappen_model->getFouteEigenschap_byWoordId($woordObject->id);
        }
        shuffle($woordObjecten);
        echo json_encode($woordObjecten);
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