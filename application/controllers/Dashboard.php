<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
        parent :: __construct();
    }
	public function index()
	{
		// Data Session
		$data['id'] = $this->session->userdata('id'); 
		$data['nama'] = $this->session->userdata('nama'); 
		$data['username'] = $this->session->userdata('username'); 
		$data['is_login'] = $this->session->userdata('is_login'); 		
		// print_r($data);

        // $data['header']="template/template_header.php";
		$data['css']="Dataset/vDataset_css";
		$data['content']="Dashboard/vDashboard";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}
}
