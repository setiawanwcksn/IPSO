<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mPokok extends CI_Model {

	public function getAll(){
    $query = $this->db->get('pokok')->result_array();
    return $query;
    }

    function getMax(){
        $last = $this->db->order_by('id',"desc")
                ->limit(1)
                ->get('pokok')
                ->row();                
        return $last->id;
    }
}
