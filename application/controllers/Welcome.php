<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function index()
    {
        $data['title'] = '';
        $data['nobox'] = true;      // geen extra rand rond hoofdmenu
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'content' => 'welcome_message');
        $this->template->load('main_master', $partials, $data);

//        $this->load->view('welcome_message');
    }

}
