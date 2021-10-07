<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unduh extends CI_Controller {

	public function index(){
        $data['header']="template/template_header.php";
		$data['css']="Dataset/vDataset_css";
		$data['content']="Dataset/vDataset";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}
}
