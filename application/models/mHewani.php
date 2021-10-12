<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class mHewani extends CI_Model {

	public function getAll(){
    $query = $this->db->get('hewani')->result_array();
    return $query;
    }

    function getMax(){
        $last = $this->db->order_by('id',"desc")
                ->limit(1)
                ->get('hewani')
                ->row();                
        return $last->id;
    }
}
