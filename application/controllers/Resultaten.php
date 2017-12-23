<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once("PHPDebug.php");
$debug = new PHPDebug();

class Resultaten extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Meting_model');
        $this->load->model('Klas_model');
        $this->load->library('authex');

        if (!$this->authex->loggedIn()) {
            redirect('home/login');
        }
        else {
            $user = $this->authex->GetUserInfo();
            if ($user->level < 5) {
                redirect('home/login');
            }
        }
    }

    public function ajax_metingenViaZoekfunctie() {
        $view = $this->input->get('view');
        $zoekfunctie = $this->input->get('zoekfunctie');
        $zoekdata = $this->input->get('zoekdata');

        $metingen = new stdClass(); // deze wordt altijd opgevuld als array, ookal is er maar 1 rij (object) opgehaald
        $metingenA = array();
        $metingenB = array();

        // metingen ophalen
        if ($zoekfunctie == "alleMetingen") {
            $metingen = $this->Meting_model->get_eenAantalMetingen("alles");
        }
        elseif ($zoekfunctie == "opAantal") {
            // zoekdata = het 'aantal' metingen op te halen
            if ($zoekdata == 1) {
                // indien maar 1 meting ophalen -> het meting object als array opslaan
                $metingen = array($this->Meting_model->get_eenAantalMetingen($zoekdata)); //object als array opslaan
            }
            else {
                $metingen = $this->Meting_model->get_eenAantalMetingen($zoekdata);
            }
        }
        elseif ($zoekfunctie == "opDatum") {
            // zoekdata = een deel van een string (van een datum) om metingen op te halen
            $metingen = $this->Meting_model->get_metingenOpDatum($zoekdata);
        }
        elseif ($zoekfunctie == "opNaam") {
            // zoekdata = een deel van een string (van een naam) om metingen op te halen
            $metingen = $this->Meting_model->get_metingenOpNaam($zoekdata);
        }
        elseif ($zoekfunctie == "opKlas") {
            // zoekdata = een klasId van de dropdownOptions om metingen op te halen
            $metingen = $this->Meting_model->get_metingenOpKlas($zoekdata);
        }

        // elke meting opvullen met bijhorende voor- en nameting
        foreach ($metingen as $meting) {
            $meting->klas = $this->Klas_model->get($meting->klasId)->naam;
            $meting->voormeting = $this->Meting_model->get_soortMeting_byMetingId($meting->id, "voormetingen");
            $meting->voormetingFouteAntwoorden = $this->getFouteAntwoorden($meting->id, true);
            $meting->nameting = $this->Meting_model->get_soortMeting_byMetingId($meting->id, "nametingen");
            $meting->nametingFouteAntwoorden = $this->getFouteAntwoorden($meting->id, false);
        }

        // metingen opsplitsen in A en B
        foreach ($metingen as $meting) {
            if ($meting->groep == "A") {
                array_push($metingenA, $meting);
            }
            else {
                array_push($metingenB, $meting);
            }
        }

        //metingen opslaan en metingInfo (gemiddeldes van de metingen) maken/berekenen
        $data['metingenA'] = $metingenA;
        $data['metingenB'] = $metingenB;
        $data['metingenAInfo'] = $this->getInfoOverMetingenA($metingenA);
        $data['metingenBInfo'] = $this->getInfoOverMetingenB($metingenB);
        $data['metingenInfo'] = $this->getInfoOverMetingen($data['metingenAInfo'], $data['metingenBInfo']);

        // de juiste view laten zien (lijst of grafiek)
        if ($view == "lijst") {
            $this->load->view('ajax_resultatenLijst', $data);
        }
        else {
            if ($metingen != null) {
                $data['title'] = '';
                $data['nobox'] = true;
                $data['user'] = $this->authex->getUserInfo();
                $data['graphDataArray'] = $this->getGraphDataArray($metingenA, $metingenB);
                $data['graphDataInfoA'] = $data['metingenAInfo'];
                $data['graphDataInfoB'] = $data['metingenBInfo'];
                $partials = array('header' => 'main_header', 'content' => 'ajax_resultatenGrafiek');
                $this->template->load('main_master', $partials, $data);
            }
        }
    }

    public function getFouteAntwoorden($metingId, $isVoormeting) {
        $arrayMetWoorden = array();
        $this->load->model('FouteAntwoorden_model');
        $this->load->model('Woord_model');
        //alle fouteAntwoorden ophalen
        $fouteAntwoorden = $this->FouteAntwoorden_model->get_byMetingId_and_soortMeting($metingId, $isVoormeting);
        //alle fouteWoorden ophalen
        foreach ($fouteAntwoorden as $foutAntwoord) {
            $woord = $this->Woord_model->get($foutAntwoord->woordId);
            array_push($arrayMetWoorden, $woord);
        }
        return $arrayMetWoorden;
    }

    public function getInfoOverMetingenA($metingenA) {
        $metingenInfo = new stdClass();
        $metingenInfo->aantalMetingen = count($metingenA);

        //metingen text aan serverkant opbouwen ipv in de view
        switch ($metingenInfo->aantalMetingen) {
            case 0:
                $metingenInfo->aantalMetingenText = "";
                break;
                break;
            case 1:
                $metingenInfo->aantalMetingenText = $metingenInfo->aantalMetingen . " meting";
                break;
            default:
                $metingenInfo->aantalMetingenText = $metingenInfo->aantalMetingen . " metingen";
                break;
        }

        $aantalMetingen = 1;
        if (count($metingenA) > 0) {
            $aantalMetingen = count($metingenA);
        }

        $totaalJuist_v = 0;
        $totaalFout_v = 0;
        $totaalDuur_v = 0;
        $totaalJuist_n = 0;
        $totaalFout_n = 0;
        $totaalDuur_n = 0;

        foreach ($metingenA as $meting) {
            $totaalJuist_v += $meting->voormeting->aantalJuist;
            $totaalFout_v += $meting->voormeting->aantalFout;
            $totaalDuur_v += strtotime($meting->voormeting->duur);
            $totaalJuist_n += $meting->nameting->aantalJuist;
            $totaalFout_n += $meting->nameting->aantalFout;
            $totaalDuur_n += strtotime($meting->nameting->duur);
        }
        $gem_v = date('H:i,s', ($totaalDuur_v / $aantalMetingen));
        $gem_n = date('H:i,s', ($totaalDuur_n / $aantalMetingen));

        $metingenInfo->voormetingAantalJuist = ($totaalJuist_v / $aantalMetingen);
        $metingenInfo->voormetingAantalFout = ($totaalFout_v / $aantalMetingen);
        $metingenInfo->voormetingAantalTotaal = 10;
//        $metingenInfo->voormetingAantalTotaal = $metingenA[0]->voormeting->aantalTotaal;
        $metingenInfo->voormetingDuur = substr($gem_v, 3, strlen($gem_v)) . "min";
        $metingenInfo->nametingAantalJuist = ($totaalJuist_n / $aantalMetingen);
        $metingenInfo->nametingAantalFout = ($totaalFout_n / $aantalMetingen);
        $metingenInfo->nametingAantalTotaal = 10;
//        $metingenInfo->nametingAantalTotaal = $metingenA[0]->nameting->aantalTotaal;
        $metingenInfo->nametingDuur = substr($gem_n, 3, strlen($gem_n)) . "min";

        //maak info over de foute antwoorden
        $metingenInfo->voormetingFouteAntwoorden_AssocArray = $this->getInfoOverFouteAntwoorden($metingenA, true);
        $metingenInfo->nametingFouteAntwoorden_AssocArray = $this->getInfoOverFouteAntwoorden($metingenA, false);

        return $metingenInfo;
    }


    public function getInfoOverMetingenB($metingenB) {
        $metingenInfo = new stdClass();
        $metingenInfo->aantalMetingen = count($metingenB);

        //metingen text aan serverkant opbouwen ipv in de view
        switch ($metingenInfo->aantalMetingen) {
            case 0:
                $metingenInfo->aantalMetingenText = "";
                break;
            case 1:
                $metingenInfo->aantalMetingenText = $metingenInfo->aantalMetingen . " meting";
                break;
            default:
                $metingenInfo->aantalMetingenText = $metingenInfo->aantalMetingen . " metingen";
                break;
        }

        $aantalMetingen = 1;
        if (count($metingenB) > 0) {
            $aantalMetingen = count($metingenB);
        }

        $totaalJuist_v = 0;
        $totaalFout_v = 0;
        $totaalDuur_v = 0;
        $totaalJuist_n = 0;
        $totaalFout_n = 0;
        $totaalDuur_n = 0;

        foreach ($metingenB as $meting) {
            $totaalJuist_v += $meting->voormeting->aantalJuist;
            $totaalFout_v += $meting->voormeting->aantalFout;
            $totaalDuur_v += strtotime($meting->voormeting->duur);
            $totaalJuist_n += $meting->nameting->aantalJuist;
            $totaalFout_n += $meting->nameting->aantalFout;
            $totaalDuur_n += strtotime($meting->nameting->duur);
        }
        $gem_v = date('H:i,s', ($totaalDuur_v / $aantalMetingen));
        $gem_n = date('H:i,s', ($totaalDuur_n / $aantalMetingen));

        $metingenInfo->voormetingAantalJuist = ($totaalJuist_v / $aantalMetingen);
        $metingenInfo->voormetingAantalFout = ($totaalFout_v / $aantalMetingen);
        $metingenInfo->voormetingAantalTotaal = 10;
//        $metingenInfo->voormetingAantalTotaal = $metingenB[0]->voormeting->aantalTotaal;
        $metingenInfo->voormetingDuur = substr($gem_v, 3, strlen($gem_v)) . "min";
        $metingenInfo->nametingAantalJuist = ($totaalJuist_n / $aantalMetingen);
        $metingenInfo->nametingAantalFout = ($totaalFout_n / $aantalMetingen);
        $metingenInfo->nametingAantalTotaal = 10;
//        $metingenInfo->voormetingAantalTotaal = $metingenB[0]->nameting->aantalTotaal;
        $metingenInfo->nametingDuur = substr($gem_n, 3, strlen($gem_n)) . "min";

        //maak info over de foute antwoorden
        $metingenInfo->voormetingFouteAntwoorden_AssocArray = $this->getInfoOverFouteAntwoorden($metingenB, true);
        $metingenInfo->nametingFouteAntwoorden_AssocArray = $this->getInfoOverFouteAntwoorden($metingenB, false);

        return $metingenInfo;
    }

    public function getInfoOverFouteAntwoorden($metingen, $isVoormeting) {
        // associative array om te returnen
        $returnArray = array();
        // associatieve array om mee te rekenen (bevat 'woord' => 'aantalKeerFout')
        $berekeningsArray = array();

        foreach ($metingen as $meting) {
            if ($isVoormeting) {
                $metingFouteAntwoorden = $meting->voormetingFouteAntwoorden;
            }
            else {
                $metingFouteAntwoorden = $meting->nametingFouteAntwoorden;
            }

            foreach ($metingFouteAntwoorden as $foutAntwoord) {
                if (array_key_exists($foutAntwoord->naam, $berekeningsArray)) {
                    $berekeningsArray[$foutAntwoord->naam] = $berekeningsArray[$foutAntwoord->naam] + 1;
                }
                else {
                    $berekeningsArray[$foutAntwoord->naam] = 1;
                }
            }
        }

        // percentages berekenen (1 woord is zoveel keer fout naargelang de aantal metingen)
        foreach ($berekeningsArray as $woord => $aantal) {
            $returnArray[$woord] = number_format(($aantal / count($metingen)) * 100, 0);
        }
        arsort($returnArray);
        return $returnArray;
    }

    public function getInfoOverMetingen($metingenA, $metingenB) {
        $metingenInfo = new stdClass();
        $metingenInfo->aantalMetingen = ($metingenA->aantalMetingen + $metingenB->aantalMetingen);


//        $aantalMetingen = 1;
//        if (count($metingenA) > 0) {
//            $aantalMetingen = count($metingenA);
//        }
//
//        $totaalJuist_v = 0;
//        $totaalFout_v = 0;
//        $totaalDuur_v = 0;
//        $totaalJuist_n = 0;
//        $totaalFout_n = 0;
//        $totaalDuur_n = 0;
//
//        foreach ($metingenA as $meting) {
//            $totaalJuist_v += $meting->voormeting->aantalJuist;
//            $totaalFout_v += $meting->voormeting->aantalFout;
//            $totaalDuur_v += strtotime($meting->voormeting->duur);
//            $totaalJuist_n += $meting->nameting->aantalJuist;
//            $totaalFout_n += $meting->nameting->aantalFout;
//            $totaalDuur_n += strtotime($meting->nameting->duur);
//        }
//        $gem_v = date('H:i,s', ($totaalDuur_v / $aantalMetingen));
//        $gem_n = date('H:i,s', ($totaalDuur_n / $aantalMetingen));
//
//        $metingenInfo->voormetingAantalJuist = ($totaalJuist_v / $aantalMetingen);
//        $metingenInfo->voormetingAantalFout = ($totaalFout_v / $aantalMetingen);
//        $metingenInfo->voormetingDuur = substr($gem_v, 3, strlen($gem_v)) . "min";
//        $metingenInfo->nametingAantalJuist = ($totaalJuist_n / $aantalMetingen);
//        $metingenInfo->nametingAantalFout = ($totaalFout_n / $aantalMetingen);
//        $metingenInfo->nametingDuur = substr($gem_n, 3, strlen($gem_n)) . "min";

        return $metingenInfo;
    }

//    public function getGraphDataArray($metingen, $metingenInfo) {
//
//        $voormetingenJuist = [];
//        $nametingenJuist = [];
//        $voormetingenGemiddeldJuist = [];
//        $nametingenGemiddeldJuist = [];
//        foreach ($metingen as $meting) {
//            array_push($voormetingenJuist, $meting->voormeting->aantalJuist);
//            array_push($nametingenJuist, $meting->nameting->aantalJuist);
//            array_push($voormetingenGemiddeldJuist, $metingenInfo->voormetingAantalJuist);
//            array_push($nametingenGemiddeldJuist, $metingenInfo->nametingAantalJuist);
//        }
//        $mainArray = [];
//        array_push($mainArray, array_reverse($voormetingenJuist));
//        array_push($mainArray, array_reverse($nametingenJuist));
//        array_push($mainArray, array_reverse($voormetingenGemiddeldJuist));
//        array_push($mainArray, array_reverse($nametingenGemiddeldJuist));
//
//        return $mainArray;
//    }
    public function getGraphDataArray($metingenA, $metingenB) {
        $voormetingenJuistA = [];
        $nametingenJuistA = [];
        $voormetingenJuistB = [];
        $nametingenJuistB = [];

        foreach ($metingenA as $meting) {
            array_push($voormetingenJuistA, $meting->voormeting->aantalJuist);
            array_push($nametingenJuistA, $meting->nameting->aantalJuist);

        }
        foreach ($metingenB as $meting) {
            array_push($voormetingenJuistB, $meting->voormeting->aantalJuist);
            array_push($nametingenJuistB, $meting->nameting->aantalJuist);

        }

        $mainArray = [];
        array_push($mainArray, array_reverse($voormetingenJuistA));
        array_push($mainArray, array_reverse($nametingenJuistA));
        array_push($mainArray, array_reverse($voormetingenJuistB));
        array_push($mainArray, array_reverse($nametingenJuistB));

        return $mainArray;
    }

    public function vanGrafiekTerugNaarLijst() {
        $this->globals['laatsteView'] = "terugVanGrafiekNaarLijst";
        redirect('home/resultaten');
    }


}
