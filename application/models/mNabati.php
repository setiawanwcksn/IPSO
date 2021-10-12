<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mNabati extends CI_Model {

	public function getAll(){
    $query = $this->db->get('nabati')->result_array();
    return $query;
    }

    function getMax(){
        $last = $this->db->order_by('id',"desc")
                ->limit(1)
                ->get('nabati')
                ->row();                
        return $last->id;
    }
}
