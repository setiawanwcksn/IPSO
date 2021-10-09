<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Optimization extends CI_Controller {

	public function index()
	{
        $data['header']="template/template_header.php";
		$data['css']="Dataset/vDataset_css";
		$data['content']="Result/vResult";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}

    function proccess(){
        $input = $this->input->post(NULL,TRUE);
        extract($input);   
        print_r($input);
        
    }
}
