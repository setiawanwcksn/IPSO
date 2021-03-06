<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mUser extends CI_Model {
    function cek_login($akun){
        $this->db->from('user');
        $this->db->where($akun);    
        return  $this->db->get()->row();
    }
    
    function regis($akun){
        $this->db->where('username', $akun["username"]);
        $query=$this->db->from('user');
        $data = $query->get()->row();
        
         if($data){
        $this->db->where('username', $akun["username"]);
        $this->db->update('user', $akun);
        
        }else{
        $this->db->insert('user', $akun);        
        } 
    }

    function temp($data){                
        $this->db->where('id', 0);
        $this->db->update('temp', $data);        
    }

    function getTemp(){
        $this->db->from('temp');
        $this->db->where('id',0);    
        return  $this->db->get()->row();
    }

    function saveItem($data){
        $this->db->insert('saveditem', $data);  
        return $this->db->insert_id();
    }

    function userHistory($data){
        $this->db->insert('userhistory', $data);  
    }

    function getHistory($id){
        // $this->db->from('savedItem');
        // $this->db->where('id', $id);    
        // return  $this->db->get()->result_array();
        $this->db->select('savedItem.*');
        $this->db->from('userhistory');
        $this->db->join('savedItem','savedItem.id = userhistory.id_saved'); 
        $this->db->where('userhistory.id_user',$id);
        return  $this->db->get()->result_array();
    }

    function cekUser($username){
        $this->db->from('user');
        $this->db->where('username',$username);    
        return  $this->db->get()->row();
    }
}
