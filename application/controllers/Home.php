<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("PHPDebug.php");
$debug = new PHPDebug();


class Home extends CI_Controller
{


    public function index()
    {
        $data['title'] = '';
        $data['nobox'] = true;
        $data['user'] = $this->authex->getUserInfo();
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'content' => 'home');
        $this->template->load('main_master', $partials, $data);
    }

    public function login()
    {
        // toont een pagina om door een form in te loggen
        $data['title'] = 'Aanmelden';
        $data['user'] = $this->authex->getUserInfo(); // nodig voor de links in navigatie
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'content' => 'home_login');
        $this->template->load('main_master', $partials, $data);
    }

    public function aanmelden()
    {
        // is de action van de form van de loginpagina
        clearstatcache();
        $gebruikersnaam = $this->input->post('gebruikersnaam');
        $password = $this->input->post('password');

        if ($this->authex->login($gebruikersnaam, $password)) {
            redirect('home/index');
        } else {
            redirect('home/fout');
        }
    }

    public function afmelden()
    {
        // is de function om af te melden en te redirecten naar de home pagina
        $this->authex->logout();
        redirect('home/index');
    }

    public function resultaten() {
        // naar de pagina gaan om de resultaten van de android app 'fonologisch verkennen' te bekijken via database records
        $data['title'] = '';
        $data['nobox'] = true;
        $data['user'] = $this->authex->getUserInfo();
        $data['footer'] = '';
//        $data['infoMovies'] = $this->authex->getCountMovies();
//        $data['infoEpisodes'] = $this->authex->getCountEpisodes();

        $partials = array('header' => 'main_header', 'content' => 'resultaten');
        $this->template->load('main_master', $partials, $data);
    }

    public function testData() {

        $recordsAantal = 50;
        $record = 0;
        while($record < $recordsAantal){
            $record++;
            $this->load->model('Resultaat_model');
            $id = $this->Resultaat_model->insertVoormetingen();
        }
        $recordsAantal2 = 50;
        $record2 = 0;
        while($record2 < $recordsAantal2){
            $record2++;
            $this->load->model('Resultaat_model');
            $id = $this->Resultaat_model->insertNametingen();
        }
//        log_message('error', 'Some variable did not contain a value.');
        redirect('home/index');

    }







}
