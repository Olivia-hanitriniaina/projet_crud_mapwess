<?php
defined('BASEPATH') OR exit('No direct script allowed');
class Centre_model extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_all_users(){
    try{
      $this->db->select("id,fullname");
      $this->db->from('codir_users');
      $this->db->where(array('profil_id'=>1));
      $query=$this->db->get();

      return $query->result();       
    }      
    catch(Exception $e){
      show_error($e->getMessage().'-----'.$e->getTraceAsString());
    }
  }

  public function get_all_centres(){

    try {
      $this->db->select('*');
      $this->db->from('codir_locals');
      $this->db->join('codir_local_type','local_type_id=codir_local_type.id');
      $this->db->join('codir_users','codir_users.id=local_manager_id','left');
      $this->db->where(array('local_type_id'=>6));
      $query=$this->db->get();
      return $query->result();
    }
    catch(Exception $e){
      show_error($e->getMessage().'-----'.$e->getTraceAsString());
    }

  }

  public function get_by_id($id){

    try{
      $this->db->select('*');
      $this->db->from('codir_locals');
      $this->db->join('codir_local_type','local_type_id=codir_local_type.id');
      $this->db->join('codir_users','codir_users.id=local_manager_id','left');
      $this->db->where(array('local_type_id'=>6,'id_local'=>$id));
      $query=$this->db->get();
      return $query->row();
    }
    catch(Exception $e){
      show_error($e->getMessage().'-----'.$e->getTraceAsString());
    }

  }

  public function create($data){
    try{
      $this->db->insert('codir_locals', $data);
      return $this->db->insert_id();

    }catch(Exception $e){
      show_error($e->getMessage().'-----'.$e->getTraceAsString());
    }
    
  }

  public function update($data){

     try {
            $where=array('id_local'=>$this->input->post('centre_id'));
            $this->db->update('codir_locals',$data,$where);
            return $this->db->affected_rows();
      }
      catch(Exception $e){
        show_error($e->getMessage().'-----'.$e->getTraceAsString());
      }

  }

  public function delete(){

    try {
          $id= $this->input->post('centre_id');
          $this->db->where('id_local',$id);
          $this->db->delete('codir_locals');
    }
    catch(Exception $e){
      show_error($e->getMessage().'-----'.$e->getTraceAsString());
    }
  }
}