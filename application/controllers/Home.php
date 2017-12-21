<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("PHPDebug.php");
$debug = new PHPDebug();


class Home extends CI_Controller {

    public function index() {
        $data['title'] = '';
        $data['nobox'] = true;
        $data['user'] = $this->authex->getUserInfo();
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'content' => 'home');
        $this->template->load('main_master', $partials, $data);
    }

    public function login() {
        // toont een pagina om door een form in te loggen
        $data['title'] = 'Aanmelden';
        $data['user'] = $this->authex->getUserInfo(); // nodig voor de links in navigatie
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'content' => 'home_login');
        $this->template->load('main_master', $partials, $data);
    }

    public function aanmelden() {
        // is de action van de form van de loginpagina
        clearstatcache();
        $gebruikersnaam = $this->input->post('gebruikersnaam');
        $password = $this->input->post('password');

        if ($this->authex->login($gebruikersnaam, $password)) {
            redirect('home/index');
        }
        else {
            redirect('home/fout');
        }
    }

    public function afmelden() {
        // is de function om af te melden en te redirecten naar de home pagina
        $this->authex->logout();
        redirect('home/index');
    }

    public function resultaten() {
        $this->load->model('Meting_model');

        // naar de pagina gaan om de resultaten van de android app 'fonologisch verkennen' te bekijken via database records
        $data['title'] = '';
        $data['nobox'] = true;
        $data['user'] = $this->authex->getUserInfo();
        $data['footer'] = '';
        $data['aantalMetingen'] = $this->Meting_model->get_countMetingen();

        $partials = array('header' => 'main_header', 'content' => 'resultaten');
        $this->template->load('main_master', $partials, $data);
    }

    //todo:
    public function klassen() {
        $this->load->model('Klas_model');

        // naar de pagina gaan om de resultaten van de android app 'fonologisch verkennen' te bekijken via database records
        $data['title'] = '';
        $data['nobox'] = true;
        $data['user'] = $this->authex->getUserInfo();
        $data['footer'] = '';
        $data['klassen'] = $this->Klas_model->getAll();

        $partials = array('header' => 'main_header', 'content' => 'klassenToevoegen');
        $this->template->load('main_master', $partials, $data);
    }

    public function klasOpslaan() {
        $klasNaam = $this->input->post('klasNaam');
        $this->load->model('Klas_model');
        $this->Klas_model->insertKlas($klasNaam);

        redirect(site_url("/home/klassen"));
    }

    // TESTDATA
    public function testData() {
        $this->load->model('Meting_model');

        $record = 0;
        $recordsAantal = 250;
        $datumVeranderen = 0;
        // $datum = date("Y-m-d H:i:s");
        $datum = new DateTime('2017-12-15 20:24:00');
        $datum2 = new DateTime('2017-12-15 20:24:00');
        //$datum->format('Y-m-d H:i:s');

        while ($record < $recordsAantal) {
            $datumVeranderen++;
            if ($datumVeranderen == 5) {
                $datumVeranderen = 0;
                $datum->modify('+1 day');
                $datum2->modify('+1 day');
            }
            $datum->modify('+10 minutes');
            $datum2->modify('+10 minutes');

            $record++;
            $metingId = $this->Meting_model->insertMetingen($datum, $datum2);

            $this->Meting_model->insertVoormetingen($metingId);
            $this->Meting_model->insertNametingen($metingId);

        }
        redirect('home/index');
    }


}
