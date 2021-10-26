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
}
