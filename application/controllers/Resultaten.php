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
    public function ajax_metingenViaZoekfunctie()
    {
        $view = $this->input->get('view');
        $zoekdata = $this->input->get('zoekdata');
        $zoekfunctie = $this->input->get('zoekfunctie');
        $metingen = new stdClass(); // deze wordt altijd opgevuld als array, ookal is er maar 1 rij (object) opgehaald

        // metingen ophalen
        if($zoekfunctie == "alleMetingen"){
            $metingen = $this->Resultaat_model->get_eenAantalMetingen("alles");
        }elseif($zoekfunctie == "opAantal"){
            // zoekdata = het 'aantal' metingen op te halen
            if ($zoekdata == 1) {
                // indien maar 1 meting ophalen -> het meting object als array opslaan
                $metingen = array($this->Resultaat_model->get_eenAantalMetingen($zoekdata)); //object als array opslaan
            } else {
                $metingen = $this->Resultaat_model->get_eenAantalMetingen($zoekdata);
            }
        }elseif($zoekfunctie == "opDatum"){
            // zoekdata = een deel van een string (van een datum) op metingen op te halen
            $metingen = $this->Resultaat_model->get_metingenOpDatum($zoekdata);
        }

        // elke meting opvullen met bijhorende voor- en nameting
        foreach ($metingen as $meting) {
            $meting->voormeting = $this->Resultaat_model->get_soortMeting_byMetingId($meting->id, "voormetingen");
            $meting->nameting = $this->Resultaat_model->get_soortMeting_byMetingId($meting->id, "nametingen");
        }

        //metingen opslaan en metingInfo (gemiddeldes van de metingen) maken/berekenen
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
            $totaalDuur_v += strtotime($meting->voormeting->duur);
            $totaalJuist_n += $meting->nameting->aantalJuist;
            $totaalFout_n += $meting->nameting->aantalFout;
            $totaalDuur_n += strtotime($meting->nameting->duur);
        }
        $gem_v = date('H:i,s',($totaalDuur_v / $aantalMetingen));
        $gem_n = date('H:i,s',($totaalDuur_n / $aantalMetingen));

        $metingenInfo->voormetingAantalJuist = ($totaalJuist_v / $aantalMetingen);
        $metingenInfo->voormetingAantalFout = ($totaalFout_v / $aantalMetingen);
        $metingenInfo->voormetingDuur = substr($gem_v, 3, strlen($gem_v)) . "min";
        $metingenInfo->nametingAantalJuist = ($totaalJuist_n / $aantalMetingen);
        $metingenInfo->nametingAantalFout = ($totaalFout_n / $aantalMetingen);
        $metingenInfo->nametingDuur = substr($gem_n, 3, strlen($gem_n)) . "min";

        return $metingenInfo;
    }


}
