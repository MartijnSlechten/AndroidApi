<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Meting_model');
        $this->load->model('Klas_model');
        $this->load->model('Woord_model');
        $this->load->model('FouteAntwoorden_model');
    }

    public function insert($metingId) {
        $data = file_get_contents('php://input');
        $meting = json_decode($data);
        $meting->datum = new DateTime($meting->datum);
        $isVoormeting = true;


        //array bevat minstens 1 woord
        if($meting->fouteAntwoorden != "[]"){
            // de "[" en "]" verwijderen via substring
            $fouteAntwoorden = array(substr($meting->fouteAntwoorden, 1, -1));
            //array bevat meer dan 1 woord
            if (strpos($meting->fouteAntwoorden, ',') !== false) {
                // de "[" en "]" verwijderen via substring, en dan exploden naar een array $fouteAntwoordenHulp
                $fouteAntwoorden = explode(", ", substr($meting->fouteAntwoorden, 1, -1));
            }
        }

        if ($metingId == 0) {
            $isVoormeting = true;
            $naam = $meting->naam;
            $klasId = $this->Klas_model->getByNaam($meting->klas);
            $groep = $meting->groep;

            // opslaan als voormeting
            $metingId = $this->Meting_model->insertMeting($meting->datum, $naam, $klasId, $groep);
            $this->Meting_model->insertVoormeting($metingId, $meting);
        }
        else {
            $isVoormeting = false;

            // opslaan als nameting en nametingDatum van de meting updaten
            $this->Meting_model->updateMeting($meting->datum, $metingId);
            $this->Meting_model->insertNameting($metingId, $meting);
        }

        if ($meting->fouteAntwoorden != "[]") {
            foreach ($fouteAntwoorden as $foutAntwoord) {
                $woordId = $this->Woord_model->getWoordId_ByNaam($foutAntwoord);
                $this->FouteAntwoorden_model->insertFouteAntwoorden($metingId, $woordId, $isVoormeting);
            }
        }

        //metingId terug op 0 zetten, zodat je in de App weet dat de nameting gedaan is (indien de nameting net ge-insert is)
        if (!$isVoormeting) {
            $metingId = 0;
        }

        echo $metingId;
    }


}