<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mSayur extends CI_Model {

	public function getAll(){
    $query = $this->db->get('sayuran')->result_array();
    return $query;
    }

    function getMax(){
        $last = $this->db->order_by('id',"desc")
                ->limit(1)
                ->get('sayuran')
                ->row();                
        return $last->id;
    }

    function getGizi($id){
        $this->db->where('id',$id);
        $query=$this->db->from('sayuran');
        $data = $query->get()->row();
        return $data;      
    }
}
