<?php
class Accueil extends CI_Controller{
    public function index(){
        if(isset($this->session->userdata['logged_in'])){
            $this->acceuil();
        }else{
            redirect('authentification/');
        }
    }
    public function acceuil(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header', $data);
        $this->load->view('accueil/page_acceuil');
        $this->load->view('common/footer');
    }

    public function station_service(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header',$data);
        $this->load->view('accueil/station_service');
        $this->load->view('common/footer');  
    }

    public function centre_emplisseur(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header',$data);
        $this->load->view('accueil/centre_emplisseur');
        $this->load->view('common/footer');
    }

    public function depot_aviation(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header',$data);
        $this->load->view('accueil/depot_aviation');
        $this->load->view('common/footer');
    }

    public function HSE_chantier(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header',$data);
        $this->load->view('accueil/HSE_chantier');
        $this->load->view('common/footer');
    }
    public function STL_bouteilles(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header',$data);
        $this->load->view('accueil/STL_bouteilles');
        $this->load->view('common/footer');
    }
    public function controle_camion(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header',$data);
        $this->load->view('accueil/controle_camion');
        $this->load->view('common/footer');
    }
    public function STL_camion(){
        $data['connecter'] = $this->session->userdata['logged_in'];
        $this->load->view('common/header',$data);
        $this->load->view('accueil/STL_camion');
        $this->load->view('common/footer');
    }
}