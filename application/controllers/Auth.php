<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function Login()
	{
        $data['header']="template/template_header.php";
		// $data['css']="dashboard/dashboard_css";
		$data['content']="Auth/vLogin";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}
}
