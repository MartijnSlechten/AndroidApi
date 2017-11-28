<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    public function test() {
        $this->load->model('vragen_model');
        $vragen = $this->db->getAll();
        //commentaar test
        echo json_encode($vragen);
    }

}
