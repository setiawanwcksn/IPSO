<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
        parent :: __construct();
        $this->load->model("mUser");
        
    }
	public function Login(){
        // $data['header']="template/template_header.php";
		$data['css']="Auth/vAuth_css";
		$data['content']="Auth/vLogin";
		$data['js']="Auth/vAuth_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}

	public function Regis(){
        // $data['header']="template/template_header.php";
		$data['css']="Auth/vAuth_css";
		$data['content']="Auth/vRegis";
		$data['js']="Auth/vAuth_js.php";
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
			$this->session->set_flashdata('warning', 'Akun belum terdaftar!');  
            redirect('Auth/Login');
        }

	}

	function reg(){
		$input = $this->input->post(NULL,TRUE);
		extract($input);
		$cekUsername = $this->mUser->cekUser($username);
		if ($cekUsername) {
			$this->session->set_flashdata('warning', 'Username Sudah dipakai!');  
            redirect('Auth/Regis');
		} else {
			$akun = array(
				'name' => $name,
				'username' => $username,
				'tanggal_lahir' => $date,
				'gender' => $gender,
				'password' => $password
			);
			$regisAkun = $this->mUser->regis($akun);
			redirect('Auth/Login');
		}
		
	}
}
