<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Woord extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Woord_model');

    }

    public function get($id) {
        $object = $this->Woord_model->get($id);
        echo json_encode($object);
    }


    public function getAll() {
        $objecten = $this->Woord_model->getAll();
        echo json_encode($objecten);
    }

    public function getWoordenMetEigenschappen() {
        $this->load->model('WoordEigenschappen_model');
        $woordObjecten = $this->Woord_model->getAll_objecten();

        foreach ($woordObjecten as $woordObject) {
            $woordObject->juisteEigenschappen = $this->WoordEigenschappen_model->getJuisteEigenschappen_byWoordId($woordObject->id);
            $woordObject->fouteEigenschap = $this->WoordEigenschappen_model->getFouteEigenschap_byWoordId($woordObject->id);
        }
        shuffle($woordObjecten);
        echo json_encode($woordObjecten);
    }


}