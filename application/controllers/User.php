<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('string');
        $this->load->library('email');
    }

    public function nieuw() {
        $data['title'] = 'Registreren';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu',
            'content' => 'user_nieuw');
        $this->template->load('main_master', $partials, $data);
    }

    private function sendmail($to, $id, $password = '') {
        $this->email->set_mailtype('html');
        $this->email->from('info.movieserver@gmail.com', 'Info MovieServer');
        $this->email->to($to);

        if ($password == '') {
            $this->email->subject('Account Activeren');
            $this->email->message(
                    'U bent geregistreerd, klik ' .
                    '<a href="' . site_url('/user/activeer/' . $id . '/' . sha1($id)) . '">hier</a>' . ' om je account te activeren '
            );
        } else {
            $this->email->subject('Wachtwoord Herstel');
            $this->email->message(
                    '<div> Uw nieuw wachtwoord is:  ' . $password . '</div>' .
                    '<div> Klik <a href="' . site_url('/home/login/') . '">hier</a>' . ' om je in te loggen </div>'
            );
        }
        $this->email->send();
    }

    public function registreer() {
        $naam = $this->input->post('naam');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password2 = $this->input->post('password2');
        if ($password == $password) {
            $Rcode = $this->input->post('Rcode');
            $info = $this->authex->register($naam, $email, $password, $Rcode); //info = code of id

            if ($info == 'bestaatNiet') {
                redirect('user/RcodeFout');
            } else {
                $id = $info;
                if ($password == $password2) {

                    if ($id == 0) {
                        redirect('user/bestaat');
                    } else {
                        $this->sendmail($email, $id);
                        redirect('user/klaar'); // effe in commentaar zetten als de mail niet lukt. Anders kan je geen foutmelding niet zien, omdat hij direct 'redirect'
                    }
                } else {
                    redirect('user/nieuw');
                }
            }
        } else {
            //'wachtwoord komt niet overeen';
        }
    }

    public function registreerUpdate() {
        $id = $this->input->post('id');
        $naam = $this->input->post('naam');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $password2 = $this->input->post('password2');
        if ($password == null) {
            $this->authex->registerUpdate($id, $naam, $email);
        } else {
            if ($password == $password2) {
                $this->authex->registerUpdateWithPassword($id, $naam, $email, $password);
            } else {
                redirect('user/profile_updateMislukt');
            }
        }
        redirect('home/profile');
    }

    public function profile_updateMislukt() {
        $data['title'] = '';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu',
            'content' => 'profile_updateMislukt');
        $this->template->load('main_master', $partials, $data);
    }

    public function profile_delete() {
        $id = $this->authex->getUserId();
        $this->authex->deleteProfile($id);
        redirect('home');
    }

    public function profile_delete_bevestiging() {
        $data['title'] = '';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'profile_delete_bevestiging');
        $this->template->load('main_master', $partials, $data);
    }

    public function activeer($id, $idHash) {
        if (sha1($id) == $idHash) {
            $id = $this->authex->activate($id);
            $data['title'] = 'Geactiveerd';
            $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
            $data['footer'] = '';

            $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_geactiveerd');
            $this->template->load('main_master', $partials, $data);
        } else {
            $this->redirect('registreer');
        }
    }

    public function bestaat() {
        $data['title'] = 'Reeds geregistreerd';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_bestaat');
        $this->template->load('main_master', $partials, $data);
    }

    public function klaar() {
        $data['title'] = 'Geregistreerd !';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_klaar');
        $this->template->load('main_master', $partials, $data);
    }

    public function wachtwoord() {
        $data['title'] = 'Wachtwoord vergeten';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_wachtwoord');
        $this->template->load('main_master', $partials, $data);
    }

    public function wachtwoordHerstel() {
        $email = $this->input->post('email');
        $newpassword = random_string('alpha', 8);

        if ($this->authex->emailExist($email)) {
//            $id=
            $this->authex->updateWachtwoord($email, $newpassword);
            $this->sendmail($email, $id, $newpassword);
            redirect('user/wachtwoordHerstelGelukt'); // effe in commentaar zetten als de mail niet lukt. Anders kan je de fout niet zien omdat hij direct 'redirect'
        } else {
            //redirect('user/wachtwoordHerstelfout'); //niet goed omdat ...
            $this->wachtwoordHerstelfout();
        }
    }

    public function wachtwoordHerstelfout() {
        $data['title'] = 'Deze e-mail bestaat niet';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu',
            'content' => 'user_wachtwoordHerstelMislukt');
        $this->template->load('main_master', $partials, $data);
    }

    public function wachtwoordHerstelGelukt() {
        $data['title'] = 'Wachtwoord hersteld';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen

        $partials = array('header' => 'main_header', 'menu' => 'main_menu',
            'content' => 'user_wachtwoordHerstelGelukt');
        $this->template->load('main_master', $partials, $data);
    }

    public function RcodeFout() {
        $data['title'] = 'Registratie Code onbekend';
        $data['user'] = $this->authex->getUserInfo(); //nodig voor het menu links te tonen
        $data['footer'] = '';

        $partials = array('header' => 'main_header', 'menu' => 'main_menu', 'content' => 'user_RcodeFout');
        $this->template->load('main_master', $partials, $data);
    }

}

/* End of file User.php */
/* Location: ./applications/tvshop/controllers/User.php */