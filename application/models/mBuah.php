<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mBuah extends CI_Model {

	public function getAll(){
    $query = $this->db->get('buah')->result_array();
    return $query;
    }

    function getGizi($id){
        $this->db->where('id',$id);
        $query=$this->db->from('buah');
        $data = $query->get()->row();
        return $data;      
    }

    function getMax(){
        $last = $this->db->order_by('id',"desc")
                ->limit(1)
                ->get('buah')
                ->row();                
        return $last->id;
    }
}
