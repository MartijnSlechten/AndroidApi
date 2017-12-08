<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Resultaat_model');
    }

    public function insert($metingId) {
        $data = file_get_contents('php://input');
        $meting = json_decode($data);
        $meting->datum = new DateTime($meting->datum);

        if ($metingId == 0) {
            // opslaan als voormeting
            $metingId = $this->Resultaat_model->insertMeting($meting->datum);
            $this->Resultaat_model->insertVoormeting($metingId, $meting);
        }
        else {
            // opslaan als nameting en nametingDatum van de meting updaten
            $this->Resultaat_model->updateMeting($meting->datum, $metingId);
            $this->Resultaat_model->insertNameting($metingId, $meting);

            //metingId terug op 0 zetten, zodat je in de App weet dat de nameting gedaan is
            $metingId = 0;
        }
        // in de androidApp de $metingId opvangen/opslaan om vervolgens ...
        // bij de insert van de nameting, de meting datum te updaten aan de hand van deze $metingId
        echo $metingId;
    }

}