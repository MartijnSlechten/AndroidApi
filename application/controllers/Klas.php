<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klas extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function get($id) {
        $this->load->model('Klas_model');
        $object = $this->Klas_model->get($id);
        echo json_encode($object);
    }

    public function getAll() {
        $this->load->model('Klas_model');
        $objecten = $this->Klas_model->getAll();
        echo json_encode($objecten);
    }


}