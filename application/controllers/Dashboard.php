<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
        $data['header']="template/template_header.php";
		// $data['css']="dashboard/dashboard_css";
		$data['content']="Dashboard/vDashboard";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}
}
