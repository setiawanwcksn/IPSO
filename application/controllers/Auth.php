<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
        parent :: __construct();
        $this->load->model("mUser");
        
    }
	public function Login(){
        // $data['header']="template/template_header.php";
		// $data['css']="dashboard/dashboard_css";
		$data['content']="Auth/vLogin";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}

	public function Regis(){
        // $data['header']="template/template_header.php";
		// $data['css']="dashboard/dashboard_css";
		$data['content']="Auth/vRegis";
		// $data['js']="dashboard/dashboard_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}

    // fungsi logout
    function LogOut(){
        $data_session = array (
            'id','nama','username','is_login'
        );  
        
        // menghancurkan isi dari session login
        $this->session->unset_userdata($data_session);
        redirect('Dashboard');
    }	

	function log(){
		$input = $this->input->post(NULL,TRUE);
		extract($input);

		$akun = array(
			'username' => $username,
			'password' => $password
		);
		$cekAkun = $this->mUser->cek_login($akun);
		
		// memasukkan kedalam session
		if ($cekAkun){
            // Data Session
            $data_session = array (
                'id'     => $cekAkun->id,
                'nama' 	    => $cekAkun->name,                        
                'username'   => $cekAkun->username,
                'is_login' 	=> true
            );                               
            // Set Session degan data diatas  
            $this->session->set_userdata($data_session);
            redirect('Dashboard');
        } else {
            redirect('Auth/Login');
        }

	}

	function reg(){
		$input = $this->input->post(NULL,TRUE);
		extract($input);
		
		$akun = array(
			'name' => $name,
			'username' => $username,
			'password' => $password
		);
		$regisAkun = $this->mUser->regis($akun);
		redirect('Auth/Login');
	}
}
