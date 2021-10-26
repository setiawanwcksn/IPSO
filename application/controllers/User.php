<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent :: __construct();	
		$this->load->model("mUser");	
	}

	public function index()
	{
		// Data Session
		$data['id'] = $this->session->userdata('id'); 
		$data['nama'] = $this->session->userdata('nama'); 
		$data['username'] = $this->session->userdata('username'); 
		$data['is_login'] = $this->session->userdata('is_login'); 

        $data['header']="template/template_header.php";
		$data['css']="Form/vForm_css";
		$data['content']="Form/vForm";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}

	function save(){
		$tempSave = $this->mUser->getTemp();
		// $temp0 = 'temp0';
		// print_r($tempSave);
		for ($i=0; $i < 14; $i++) { 
			$temp = 'temp'.$i;
			$tempHistory['save'.$i] = $tempSave->$temp;
		}
		$saved_id = $this->mUser->saveItem($tempHistory);	
		$data = array(
			'id_user' => $this->session->userdata('id'),
			'id_saved' => $saved_id
		);
		$this->mUser->userHistory($data);
		
		// Data Session
		$data['id'] = $this->session->userdata('id'); 
		$data['nama'] = $this->session->userdata('nama'); 
		$data['username'] = $this->session->userdata('username'); 
		$data['is_login'] = $this->session->userdata('is_login'); 		

        $data['header']="template/template_header.php";
		$data['css']="Dataset/vDataset_css";
		$data['content']="Dashboard/vDashboard";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);		
	}
}
