<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
        $data['header']="template/template_header.php";
		$data['css']="Form/vForm_css";
		$data['content']="Form/vForm";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}

	function save(){
		print_r($this->session->userdata());
	}
}
