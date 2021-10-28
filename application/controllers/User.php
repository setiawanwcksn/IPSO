<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent :: __construct();
		$this->load->model("mPokok");	
		$this->load->model("mBuah");	
		$this->load->model("mHewani");		
		$this->load->model("mNabati");	
		$this->load->model("mSayur");
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

	function show(){
		$history = $this->mUser->getHistory($this->session->userdata('id'));
		// echo '<pre>';print_r($history);die;

		for ($indeks=0; $indeks < count($history); $indeks++) { 
			$y = 1;$i = 1;
			for ($j=0; $j < 14; $j++) { 
				if ($y == 1) {
					$data['history'][$indeks]['makanan'][$i][] = $this->mPokok->getGizi($history[$indeks]['save'.$j])->nama;
				}elseif ($y == 2) {
					$data['history'][$indeks]['makanan'][$i][] = $this->mNabati->getGizi($history[$indeks]['save'.$j])->nama;
				}elseif ($y == 3) {
					$data['history'][$indeks]['makanan'][$i][] = $this->mHewani->getGizi($history[$indeks]['save'.$j])->nama;
				}elseif ($y == 4) {					
					$data['history'][$indeks]['makanan'][$i][] = $this->mSayur->getGizi($history[$indeks]['save'.$j])->nama;					
				}elseif ($y == 5) {
					$data['history'][$indeks]['makanan'][$i][] = $this->mBuah->getGizi($history[$indeks]['save'.$j])->nama;
				}
				if ($j == 13) {
					$data['history'][$indeks]['makanan'][$i][] = " - ";
				}
				$y++;
				if ($y > 5) {
					$y=1; $i++;
				}
			}			
		}
		// echo '<pre>';print_r($data);die;

		// Data Session
		$data['id'] = $this->session->userdata('id'); 
		$data['nama'] = $this->session->userdata('nama'); 
		$data['username'] = $this->session->userdata('username'); 
		$data['is_login'] = $this->session->userdata('is_login'); 		

        $data['header']="template/template_header.php";
		$data['css']="SavedItem/vSaved_css";
		$data['content']="SavedItem/vSaved";
		$data['js']="SavedItem/vSaved_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);		
	}
}
