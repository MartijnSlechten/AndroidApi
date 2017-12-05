<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Authex {

    public function __construct() {
        $CI = & get_instance();
        $CI->load->model('user_model');
    }

    function loggedIn() {
        // gebruiker is aangemeld als sessievariabele user_id bestaat
        $CI = & get_instance();
        if ($CI->session->has_userdata('user_id')) {
            return true;
        } else {
            return false;
        }
    }

    function getUserInfo() {
        // geef user-object als gebruiker aangemeld is
        $CI = & get_instance();
        if (!$this->loggedIn()) {
            return null;
        } else {
            $id = $CI->session->userdata('user_id');
            return $CI->user_model->get($id);
        }
    }
    
    function getUserId() {
        // geef user-id als gebruiker aangemeld is
        $CI = & get_instance();
        if (!$this->loggedIn()) {
            return null;
        } else {
            $userId = $CI->session->userdata('user_id');
            return $userId;
        }
    }

    function login($gebruikersnaam, $password) {
        // gebruiker aanmelden met opgegeven email en wachtwoord
        $CI = & get_instance();
        $user = $CI->user_model->getAccount($gebruikersnaam, $password);
        if ($user == null) {
            return false;
        } else {
            //$CI->user_model->updateLaatstAangemeld($user->id);
            $CI->session->set_userdata('user_id', $user->id);
            return true;
        }
    }

    function logout() {
        // uitloggen, dus sessievariabele wegdoen
        $CI = & get_instance();
        $CI->session->unset_userdata('user_id');
    }

    function register($naam, $email, $password, $Rcode) {
        // nieuwe gebruiker registreren als email nog niet bestaat
        $CI = & get_instance();
        if ($CI->user_model->RcodeExist($Rcode)) {
            if ($CI->user_model->emailVrij($email)) {
                $id = $CI->user_model->insert($naam, $email, $password);
                $CI->user_model->deleteRcode($Rcode);
                return $id;
            } else {
                return 0;
            }
        } else {
            $code = 'bestaatNiet'; // bestaat niet in db
            return $code;
        }
    }

    function registerUpdate($id, $naam, $email) {
        $CI = & get_instance();
        $CI->user_model->updateUserProfile($id, $naam, $email);
    }
    
    function registerUpdateWithPassword($id, $naam, $email, $password) {
        $CI = & get_instance();
        $CI->user_model->updateUserProfileWithPassword($id, $naam, $email, $password);
    }
    
    function updateWachtwoord($email, $newpassword) {
        $CI = & get_instance();
        $CI->user_model->updateWachtwoord($email, $newpassword);
    }

    function deleteProfile($id) {
        $CI = & get_instance();
        $CI->user_model->deleteProfile($id);
    }
    
    function activate($id) {
        // nieuwe gebruiker activeren
        $CI = & get_instance();
        $CI->user_model->activeer($id);
    }

    function emailExist($email) {
        $CI = & get_instance();
        if (!$CI->user_model->emailVrij($email)) {
            return true;
        } else {
            return false;
        }
    }

// FILMS ******************************************************************************
    function getMoviesOpNaam($zoekstring) {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $data['movies'] = $CI->films_model->getFilmsOpNaam($zoekstring);
        return $data;
    }

    function getMoviesOpJaar($zoekstring) {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $data['movies'] = $CI->films_model->getFilmsOpJaar($zoekstring);
        return $data;
    }
    
    function getMoviesOpLaatstToegevoegd($aantal) {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $data['movies'] = $CI->films_model->getFilmsOpLaatstToegevoegd($aantal);
        return $data;
    }
    
    function getAlleMovies() {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $data['movies'] = $CI->films_model->getAllMovies();
        return $data;
    }
    
    function getMoviesMeestGedownload() {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $data['movies'] = $CI->films_model->getMoviesMeestGedownload();
        return $data;
    }
    
    function getGesorteerdeMovies($taal, $type, $duurVan, $duurTot, $grootteVan, $grootteTot, $jaarVan, $jaarTot) {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $data['movies'] = $CI->films_model->getGesorteerdeMovies($taal, $type, $duurVan , $duurTot, $grootteVan, $grootteTot, $jaarVan, $jaarTot);
        return $data;
    }

    function get($zoekid) {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $data['movie'] = $CI->films_model->get($zoekid);
        return $data;
    }

    function updateDownloadCount($id) {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $currentCount = $CI->films_model->getDownloadCount($id);
        $newCount = ($currentCount->aantalDownloads+1);
        $CI->films_model->updateDownloadCount($id,$newCount);
    }
    
    function updateUserGedownload($userId) {
        $CI = & get_instance();
        $CI->load->model('user_model');
        $currentCount = $CI->user_model->getUserGedownload($userId);
        $newCount = ($currentCount->gedownload+1);
        $CI->user_model->updateUserGedownload($userId,$newCount);
    }  
    
    function updateRequestCount($id) {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $currentCount = $CI->films_model->getRequestCount($id);
        $newCount = ($currentCount->aantalRequests+1);
        $CI->films_model->updateRequestCount($id,$newCount);
    }
    
    function getCountMovies() {
        $CI = & get_instance();
        $CI->load->model('films_model');
        $infoMovies = $CI->films_model->getCountMovies();
        return $infoMovies;      
    }
    
// EPISODES **************************************************************************
    function getEpisodesSeizoenOpNaam($zoekstring) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $data['episodesSeizoen'] = $CI->episodesSeizoen_model->getEpisodesSeizoenOpNaam($zoekstring);
        return $data;
    }

    function getEpisodesSeizoenOpJaar($zoekstring) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $data['episodesSeizoen'] = $CI->episodesSeizoen_model->getEpisodesSeizoenOpJaar($zoekstring);
        return $data;
    }
    
    function getAlleEpisodesSeizoen() {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $data['episodesSeizoen'] = $CI->episodesSeizoen_model->getAlleEpisodesSeizoen();
        return $data;
    }
    function getEpisodesSeizoenCollectie() {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $data['episodesSeizoen'] = $CI->episodesSeizoen_model->getEpisodesSeizoenCollectie();
        return $data;
    }
    function getEpisodesMeestGedownload() {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $data['episodesSeizoen'] = $CI->episodesSeizoen_model->getEpisodesMeestGedownload();
        return $data;
    }
    
    function getAlleEpisodesByCollectie($collectie) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $data['episodesSeizoen'] = $CI->episodesSeizoen_model->getAlleEpisodesByCollectie($collectie);
        return $data;
    }
    
    function getEpisodesSeizoenOpLaatstToegevoegd($aantal) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $data['episodesSeizoen'] = $CI->episodesSeizoen_model->getEpisodesSeizoenOpLaatstToegevoegd($aantal);
        return $data;
    }
    
    function getEpisodesSeizoen($zoekid) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        return $CI->episodesSeizoen_model->getEpisodesSeizoen($zoekid);
    }
      function getEpisode($zoekid) {
        $CI = & get_instance();
        $CI->load->model('episodes_model');
        return $CI->episodes_model->getEpisode($zoekid);
    }
    
    function getGesorteerdeEpisodes($taal, $type, $collectie, $seizoen, $jaarVan, $jaarTot) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        return $CI->episodesSeizoen_model->getGesorteerdeEpisodes($taal, $type, $collectie, $seizoen, $jaarVan, $jaarTot);
    }
    
    function updateDownloadCountEpisodes($id) {
        $CI = & get_instance();
        $CI->load->model('episodes_model');
        $currentCount = $CI->episodes_model->getDownloadCountEpisodes($id);
        $newCount = ($currentCount->aantalDownloads+1);
        $CI->episodes_model->updateDownloadCountEpisodes($id,$newCount);
    }
    
     function updateRequestCountEpisodes($id) {
        $CI = & get_instance();
        $CI->load->model('episodes_model');
        $currentCount = $CI->episodes_model->getRequestCountEpisodes($id);
        $newCount = ($currentCount->aantalRequests+1);
        $CI->episodes_model->updateRequestCountEpisodes($id,$newCount);
    }
    
    function updateDownloadCountEpisodesSeizoen($id) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $currentCount = $CI->episodesSeizoen_model->getDownloadCountEpisodesSeizoen($id);
        $newCount = ($currentCount->aantalDownloads+1);
        $CI->episodesSeizoen_model->updateDownloadCountEpisodesSeizoen($id,$newCount);
    }
    
     function updateRequestCountEpisodesSeizoen($id) {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $currentCount = $CI->episodesSeizoen_model->getRequestCountEpisodesSeizoen($id);
        $newCount = ($currentCount->aantalRequests+1);
        $CI->episodesSeizoen_model->updateRequestCountEpisodesSeizoen($id,$newCount);
    }
    
    function getCountEpisodes() {
        $CI = & get_instance();
        $CI->load->model('episodesSeizoen_model');
        $infoEpisodes = $CI->episodesSeizoen_model->getCountEpisodes();
        return $infoEpisodes;      
    }
    
    function getEpisodesBySeizoenId($id) {
        $CI = & get_instance();
        $CI->load->model('episodes_model');
        $episodes = $CI->episodes_model->getEpisodes($id);
        return $episodes;      
    }
    
    
        

}
