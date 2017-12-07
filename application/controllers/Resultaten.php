<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("PHPDebug.php");
$debug = new PHPDebug();


class Resultaten extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Resultaat_model');
        $this->load->library('authex');

        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        } else {
            $user = $this->authex->GetUserInfo();
            if ($user->level < 5) {
                redirect('home/login');
            }
        }
    }

    function p($object = null)
    {
        ob_start();                    // start buffer capture
        var_dump($object);           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log($contents);        // log contents of the result of var_dump( $object )
    }


    public function ajax_laatsteMetingen()
    {
        $view = $this->input->get('view');
        $aantal = $this->input->get('aantal');
        $metingen = new stdClass(); // deze wordt altijd opgevuld als array, ookal is er maar 1 rij (object) opgehaald

        // indien maar 1 meting ophalen -> het meting object als array opslaan
        if ($aantal == 1) {
            $metingen = array($this->Resultaat_model->get_laatsteMetingen($aantal));
        } else {
            $metingen = $this->Resultaat_model->get_laatsteMetingen($aantal);
        }

        // elke meting opvullen met bijhorende voor- en nameting
        foreach ($metingen as $meting) {
            $meting->voormeting = $this->Resultaat_model->get_soortMeting_byMetingId($meting->id, "voormetingen");
            $meting->nameting = $this->Resultaat_model->get_soortMeting_byMetingId($meting->id, "nametingen");
        }
        $data['metingen'] = $metingen;
        $data['metingenInfo'] = $this->getInfoOverMetingen($metingen);

        // de juiste view laten zien (lijst of grafiek)
        if ($view == "lijst") {
            $this->load->view('ajax_resultatenLijst', $data);
        } else {
            $this->load->view('ajax_resultaten', $data);
        }
    }

    public function ajax_metingenOpDatum()
    {
        $view = $this->input->get('view');
        $zoekstring = $this->input->get('zoekstring');
        $metingen = $this->Resultaat_model->get_metingenOpDatum($zoekstring);

        // elke meting opvullen met bijhorende voor- en nameting
        foreach ($metingen as $meting) {
            $meting->voormeting = $this->Resultaat_model->get_soortMeting_byMetingId($meting->id, "voormetingen");
            $meting->nameting = $this->Resultaat_model->get_soortMeting_byMetingId($meting->id, "nametingen");
        }
        $data['metingen'] = $metingen;
        $data['metingenInfo'] = $this->getInfoOverMetingen($metingen);

        // de juiste view laten zien (lijst of grafiek)
        if ($view == "lijst") {
            $this->load->view('ajax_resultatenLijst', $data);
        } else {
            $this->load->view('ajax_resultaten', $data);
        }
    }

    public function getInfoOverMetingen($metingen)
    {
        $metingenInfo = new stdClass();
        $metingenInfo->aantalMetingen = count($metingen);
        $aantalMetingen = 1;
        if (count($metingen) > 0) {
            $aantalMetingen = count($metingen);

        }
        $totaalJuist_v = 0;
        $totaalFout_v = 0;
        $totaalDuur_v = 0;
        $totaalJuist_n = 0;
        $totaalFout_n = 0;
        $totaalDuur_n = 0;

        foreach ($metingen as $meting) {
            $totaalJuist_v += $meting->voormeting->aantalJuist;
            $totaalFout_v += $meting->voormeting->aantalFout;
                $totaalDuur_v += $meting->voormeting->duur;
            $totaalJuist_n += $meting->nameting->aantalJuist;
            $totaalFout_n += $meting->nameting->aantalFout;
                $totaalDuur_v += $meting->nameting->duur;
        }

        $metingenInfo->voormetingAantalJuist = ($totaalJuist_v / $aantalMetingen);
        $metingenInfo->voormetingAantalFout = ($totaalFout_v / $aantalMetingen);
        $metingenInfo->voormetingDuur = ($totaalDuur_v / $aantalMetingen);
        $metingenInfo->nametingAantalJuist = ($totaalJuist_n / $aantalMetingen);
        $metingenInfo->nametingAantalFout = ($totaalFout_n / $aantalMetingen);
        $metingenInfo->nametingDuur = ($totaalDuur_n / $aantalMetingen);

        return $metingenInfo;
    }








//    public function ajax_laatsteMetingen()
//    {
//        $view = $this->input->get('view');
//        $aantal = $this->input->get('aantal');
//
//        // indien maar 1 meting ophalen -> het meting object als array opslaan
//        if ($aantal == 1) {
//            $data['resultaten'] = array($this->Resultaat_model->get_laatsteMetingen($aantal));
//        } else {
//            $data['resultaten'] = $this->Resultaat_model->get_laatsteMetingen($aantal);
//        }
//
//        // de juiste view laten zien (lijst of grafiek)
//        if ($view == "lijst") {
//            $this->load->view('ajax_resultatenLijst', $data);
//        } else {
//            $this->load->view('ajax_resultaten', $data);
//        }
//    }


}
