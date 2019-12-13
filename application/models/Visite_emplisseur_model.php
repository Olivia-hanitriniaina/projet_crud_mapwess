<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Visite_emplisseur_model extends CI_model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_count(){
        try{
           $this->db->select('*');
           $this->db->from('visitecentreemplisseur');
           $this->db->join('Visite','Visite.id=visite_id','inner');
           $this->db->join('Localisation','Localisation.id=localisation_id','inner');
           $this->db->join('Utilisateur AS Visiteur','Visiteur.id=visiteur_id','inner');
           return $this->db->count_all_results(); 
        }catch(Exception $e){
            show_error($e->getMessage().'-----'.$e->getTraceAsString());
        }
    }

    public function get_all_visites($limit,$start){
        try{
            $this->db->select('visitecentreemplisseur.visite_id,Visite.date,Visite.time,Visiteur.nom_complet AS visiteur,Localisation.nom');
            $this->db->from('visitecentreemplisseur');
            $this->db->join('Visite','Visite.id=visite_id','inner');
            $this->db->join('Localisation','Localisation.id=localisation_id','inner');
            $this->db->join('Utilisateur AS Visiteur','Visiteur.id=visiteur_id','inner');
           
            $this->db->limit($limit,$start);
            $query=$this->db->get();
            return $query->result();
        }catch(Exception $e){
            show_error($e->getMessage().'------'.$e->getTraceAsString());
        }
    }

    public function get_all_visites_by_id($id){
        try{
            $this->db->select('visitecentreemplisseur.visite_id,Visite.date,Visite.time,Visiteur.nom_complet AS visiteur,Localisation.nom');
            $this->db->from('visitecentreemplisseur');
            $this->db->join('Visite','Visite.id=visite_id','inner');
            $this->db->join('Localisation','Localisation.id=localisation_id','inner');
            $this->db->join('Utilisateur AS Visiteur','Visiteur.id=visiteur_id','inner');
            $this->db->where('visitecentreemplisseur.visite_id',$id);
            $query=$this->db->get();
            return $query->result();
        }catch(Exception $e){
            show_error($e->getMessage().'------'.$e->getTraceAsString());
        }
    }

    public function search_visite($station,$date,$visiteur){
        try{
            $this->db->select('visitecentreemplisseur.visite_id,Visite.date,Visite.time,Visiteur.nom_complet AS visiteur,Localisation.nom');
            $this->db->from('visitecentreemplisseur');
            $this->db->join('Visite','Visite.id=visite_id','inner');
            $this->db->join('Localisation','Localisation.id=localisation_id','inner');
            $this->db->join('Utilisateur AS Visiteur','Visiteur.id=visiteur_id','inner');
            if(!empty($station) AND !empty($date) AND !empty($visiteur)){//tous remplies
                $this->db->or_like(array('Localisation.nom'=>$station,'Visite.date'=>$date,'Visiteur.nom_complet'=>$visiteur));
            }elseif(!empty($station) AND !empty($date) AND empty($visiteur)){//2 inputs remplies
                $this->db->or_like(array('Localisation.nom'=>$station,'Visite.date'=>$date));
            }elseif(!empty($station) AND empty($date) AND !empty($visiteur)){//2 inputs remplies
                $this->db->or_like(array('Localisation.nom'=>$station,'Visiteur.nom_complet'=>$visiteur));
            }elseif(empty($station) AND !empty($date) AND !empty($visiteur)){//2 inputs remplies
                $this->db->or_like(array('Visite.date'=>$date,'Visiteur.nom_complet'=>$visiteur));
            }elseif(!empty($station) AND empty($date) AND empty($visiteur)){//1 input remplie
                $this->db->or_like(array('Localisation.nom'=>$station));
            }elseif(empty($station) AND !empty($date) AND empty($visiteur)){//1 input remplie
                $this->db->or_like(array('Visite.date'=>$date));
            }elseif(empty($station) AND empty($date) AND !empty($visiteur)){//1 input remplie
                $this->db->or_like(array('Visiteur.nom_complet'=>$visiteur));
            }else{

            }  
            $query=$this->db->get();
            return $query->result();
        }catch (Exception $e){
            show_error($e->getMessage().'------'.$e->getTraceAsString());
        }
    }

    public function get_reponses($id_visite){
        try{
            $this->db->select('QuestionReponse.reponse,QuestionReponse.observations,Question.label,Question.id as id,QuestionCategorie.label AS categorie,QuestionCategorie.id as idcategorie,QuestionSousCategorie.label AS sous_categorie,QuestionSousCategorie.id as idsouscategorie');
            $this->db->from('QuestionReponse');
            $this->db->join('Question','Question.id=question_id');
            $this->db->join('QuestionCategorie','QuestionCategorie.id=Question.categorie_id');
            $this->db->join('QuestionSousCategorie','QuestionSousCategorie.id=Question.sous_categorie_id','left');
            $this->db->join('Visite','Visite.id=visite_id');
            $this->db->where(array('QuestionReponse.visite_id'=>$id_visite));
            $query=$this->db->get();
            return $query->result();
        }catch(Exception $e){
            show_error($e->getMessage().'------'.$e->getTraceAsString());
        }
    }
}