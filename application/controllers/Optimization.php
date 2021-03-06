<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Optimization extends CI_Controller {
	
	var $partikel;
	var $tMax;
	public function __construct(){
		parent :: __construct();
		$this->load->model("mPokok");	
		$this->load->model("mBuah");	
		$this->load->model("mHewani");		
		$this->load->model("mNabati");	
		$this->load->model("mSayur");		
		$this->load->model("mUser");	
		$this->partikel = 10;
		$this->tMax = 400;
	}

	public function index()
	{
		// Data Session
		$data['id'] = $this->session->userdata('id'); 
		$data['nama'] = $this->session->userdata('nama'); 
		$data['username'] = $this->session->userdata('username'); 
		$data['is_login'] = $this->session->userdata('is_login'); 

		$data['active'] = "";
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
		// hitung indeks massa tubuh
		$imt = $this->IndeksMassaTubuh($input);
		
		// hitung berat badan ideal		
		$bbi = $this->BeratBadanIdeal($input,$imt);
		
		// hitung Basal Metabolic Rate
		$bmr = $this->BasalMetabolicRate($input,$bbi);
        
		// hitung Kebutuhan Energi 
		$ke = $this->KebutuhanEnergi($input,$bmr);
		
		// menentukan kebutuhan natrium
		$natrium = $this->natrium($input);

		// kebutuhan kalium
		$kalium = 2000;

		// kebutuhan karbohidrat
		$kh = $this->karbohidrat($ke);

		// kebutuhan protein
		$protein = $this->protein($ke);

		// kebutuhan lemak
		$lemak = $this->lemak($ke);

		$dataKebutuhan = [
			'0' => $kh,
			'1' => $protein,
			'2' => $lemak,
			'3' => $natrium,
			'4' => $kalium,								
		];
		
		// melakukan perhitungan model IPSO
		$this->model_ipso($dataKebutuhan,$input);

    }

	function IndeksMassaTubuh($data){
		$imt = $data['weight']/sqrt($data['height']);
		return round($imt,2);
	}

	function BeratBadanIdeal($data,$imt){
		if ($imt >= 18.5  && $imt <= 22.9){
			$bbi = $imt;
		} else {
			$bbi = ($data['height']-100) - 0.1*($data['height']-100);
		}		
		return $bbi;
	}

	function BasalMetabolicRate($data,$bbi){
		if ($data['gender']=='Laki-laki') {
			$bmr = 66 + (13.7 * $bbi) + (5 * $data['height']) - (6.8 * $data['age']);		
		} else {
			$bmr = 65.5 + (9.6 * $bbi) + (1.7 * $data['height']) - (4.7 * $data['age']);
		}
		return $bmr;		
	}

	function KebutuhanEnergi($data,$bmr){
		// Menentukan tingkat aktivitas berdasarkan jenis kelamin
		if ($data['gender']=='Laki-laki') {
			if ($data['activity']=='Sangat ringan') {
				$activity = 1.3;
			}
			if ($data['activity']=='Ringan') {
				$activity = 1.65;
			}
			if ($data['activity']=='Sedang') {
				$activity = 1.76;
			}
			if ($data['activity']=='Berat') {
				$activity = 2.1;
			}
			
		} else {
			if ($data['activity']=='Sangat ringan') {
				$activity = 1.3;
			}
			if ($data['activity']=='Ringan') {
				$activity = 1.65;
			}
			if ($data['activity']=='Sedang') {
				$activity = 1.76;
			}
			if ($data['activity']=='Berat') {
				$activity = 2.1;
			}
		}
		// hitung kebutuhan energi
		$ke = $bmr*$activity*$data['stress'];

		return round($ke,4);
	}

	function natrium($data){
		// menentukan tingkat hipertensi
		if ( (120 <= $data['sistolik'] && $data['sistolik'] <= 139) || (80 <= $data['diastolik'] && $data['diastolik'] <= 89 )) {
			$natrium = 200;
		} else if ((140 <= $data['sistolik'] && $data['sistolik'] <= 159) || (90 <= $data['diastolik'] && $data['diastolik'] <= 99 )) {
			$natrium = 600;
		} else if ($data['sistolik'] >= 160 || $data['diastolik'] >= 100 ){
			$natrium = 1000;
		}else {
			$this->session->set_flashdata('warning', 'Tekanan darah tidak termasuk penderita Hipertensi!');  
            redirect('User');
		}

		return $natrium;		
	}

	function karbohidrat($ke){
		$kh = (0.65*$ke)/4;
		return round($kh,2);
	}

	function protein($ke){
		$protein = (0.15*$ke)/4;
		return round($protein,2);
	}

	function lemak($ke){
		$lemak = (0.2*$ke)/9;
		return round($lemak,2);
	}

	function model_ipso($dataKebutuhan,$dataDiri){
		$tMax = $this->tMax;
		for ($t=0; $t < $tMax; $t++) { 
			if ($t==0) {
				// inisialisasi awal partikel
				$x = $this->inisialisasi_awal();				
				// echo '<pre> posisi awal : '; var_dump($x);die;
			}

			// hitung kandungan gizi
			$gizi = $this->kandungan_gizi($x);

			// hitung penalti gizi
			$penalti = $this->penalti_gizi($dataKebutuhan,$gizi);
			// echo '<pre> penalti : '; print_r($penalti);

			// hitung fitness
			$fitness = $this->fitness($gizi,$penalti);
			// echo '<pre> fitness : '; print_r($fitness);

			// menentukan PBest / Local Best
			$pBest= $this->pBest($fitness);
			// echo '<pre> pbest : '; print_r($pBest);

			// menentukan GBest / Global Best
			if ($t == 0) {
				$gBest = $pBest;
			}	
			$gBest = $this->gBest($gBest,$pBest);
			// echo '<pre> gbest '.$t. ': '; print_r($gBest);
			
			// menyimpan lokasi terbaik pada setiap iterasi	
			if ($gBest[array_keys($gBest)[0]] <= $pBest[array_keys($pBest)[0]]) {
				$xBest = $x[array_keys($gBest)[0]];
			}			

			// menyimpan lokasi terbaik dari t=0 sampai t saat ini
			$tempBest[$t] = end($gBest);
			if ($t == 0 || end($gBest) > $tempBest[$t-1]) {
				$dataTheBest = [
					'iterasi' => $t+1,
					'fitness' => end($gBest),
					'partikel' => array_keys($gBest)[0]+1
				];
			}
						
			// Menghitung Constriction Factor (K)			
			$constrictionFactor = $this->constriction_factor($t+1,$tMax);
			// echo '<pre> K : '; print_r($constrictionFactor);

			// menghitung Bobot Inersia (W)
			$bobotInersia = $this->bobot_inersia($constrictionFactor,$t+1,$tMax);
			// echo '<pre> w : '; print_r($bobotInersia);

			// menghitung kecepatan (V)
			if ($t == 0) {
				for ($i=0; $i < $this->partikel; $i++) { 
					for ($j=0; $j < 14; $j++) { 
						$kecepatan[$i][] = 0;
					}
				}
			}			


			// menampung data
			for ($i=0; $i < $this->partikel; $i++) { 
				for ($j=0; $j < 14; $j++) { 					
					$temp_posisi[$t][$i][] = $x[$i][$j];
				}
			}		
			$temp_fitness[$t] = $fitness;
			$temp_pbest[$t] = $pBest;
			$temp_gbest[$t] = $gBest;
			$temp_kecepatan[$t] = $kecepatan;			
			
			$kecepatan = $this->kecepatan($constrictionFactor,$bobotInersia,$kecepatan,$t,$tMax,$pBest,$xBest,$x);
			// echo '<pre> kecepatan : '; print_r($kecepatan);

			// Update Posisi (X)
			$x = $this->update_posisi($x,$kecepatan);
			// echo '<pre> updated posisi : '; var_dump($x);die;			
		}
		$data = [
			'posisi' => $temp_posisi,
			'fitness' => $temp_fitness,
			'pbest' => $temp_pbest,
			'gbest' => $temp_gbest,
			'kecepatan' => $temp_kecepatan

		];
		// echo '<pre> best : ' ; print_r($dataTheBest);die;
		// echo '<pre> data : '; print_r($data);die;
		$this->show_recommendation($xBest,$dataKebutuhan,$data,$dataDiri,$dataTheBest);
	}

	function inisialisasi_awal(){
		$Xmax[1] = $this->mPokok->getMax();
		$Xmax[2] = $this->mNabati->getMax();
		$Xmax[3] = $this->mHewani->getMax();
		$Xmax[4] = $this->mSayur->getMax();
		$Xmax[5] = $this->mBuah->getMax();

		$x = array();
		for ($i=0; $i < $this->partikel ; $i++) { 	
			$y = 1;		
			for ($j=0; $j < 14; $j++) { 
				$x[$i][] = (int) round(1 + (mt_rand(0,10)/10)*($Xmax[$y]-1));
				$y++;
				if ($y > 5) {
					$y=1;
				}
			}
		}	
		return $x;
	}

	function kandungan_gizi($x){		
		$i = 0;$j=0;
		$getGizi[1] = $this->mPokok->getGizi($x[$i][$j]);
		$getGizi[2] = $this->mNabati->getGizi($x[$i][$j]);
		$getGizi[3] = $this->mHewani->getGizi($x[$i][$j]);
		$getGizi[4] = $this->mSayur->getGizi($x[$i][$j]);
		$getGizi[5] = $this->mBuah->getGizi($x[$i][$j]);

		$gizi = array();
		for ($i=0; $i < $this->partikel ; $i++) { 	
			$karbohidrat = 0;
			$protein = 0;
			$lemak = 0;
			$natrium = 0;
			$kalium = 0;
			$harga = 0;
			$y = 1;		
			for ($j=0; $j < 14; $j++) { 
				if ($y == 1) {
					$getGizi = $this->mPokok->getGizi($x[$i][$j]);
				} else if ($y == 2) {
					$getGizi = $this->mNabati->getGizi($x[$i][$j]);
				} elseif ($y == 3) {
					$getGizi = $this->mHewani->getGizi($x[$i][$j]);
				} elseif ($y == 4) {
					$getGizi = $this->mSayur->getGizi($x[$i][$j]);
				} elseif ($y == 5) {
					$getGizi = $this->mBuah->getGizi($x[$i][$j]);
				}
				$karbohidrat = $karbohidrat + $getGizi->karbohidrat;
				$protein = $protein + $getGizi->protein;
				$lemak = $lemak + $getGizi->lemak;
				$natrium = $natrium + $getGizi->natrium;
				$kalium = $kalium + $getGizi->kalium;
				if ($y == 1) {
					$harga = $harga + $getGizi->harga;
				}else {
					$harga = $harga + ($getGizi->harga*($getGizi->berat/$getGizi->per));
				}				

				$y++;
				if ($y > 5) {
					$y=1;
				}
			}
			$gizi[$i]= [$karbohidrat,$protein,$lemak,$natrium,$kalium,round($harga)]; 					
		}	
		return $gizi;
	}

	function penalti_gizi($dataKebutuhan,$gizi){
		
		$penalti = array();
		
		for ($i=0; $i < count($gizi); $i++) { 
			$totalPenalti = 0;
			for ($j=0; $j < count($gizi[$i])-1; $j++) { 
				$totalPenalti = $totalPenalti + ($dataKebutuhan[$j]-$gizi[$i][$j]);				
			}				
			$penalti[] = abs($totalPenalti);
		}
		// echo '<pre>';print_r($gizi);print_r($dataKebutuhan);print_r($penalti);die;
		return $penalti;
	}

	function fitness($gizi,$penalti){		
		$fitness = array();
		for ($i=0; $i < count($penalti) ; $i++) { 
			$fitness[] = round(100000/($gizi[$i][5]+($penalti[$i]*20)),2);
		}
		return $fitness;
	}

	function pBest($fitness){
		$key = array_keys($fitness,max($fitness));
		$pBest[$key[0]] = max($fitness);
		return $pBest;
	}

	function constriction_factor($t,$tMax){
		$constrictionFactor = (abs(cos((6.28/$tMax)*(($t-$tMax)/2)))+2.428571)/4;
		return $constrictionFactor;
	}

	function gBest($gBest,$pBest){
		if ($gBest[array_keys($gBest)[0]] > $pBest[array_keys($pBest)[0]]) {
			$x[array_keys($gBest)[0]] = $gBest[array_keys($gBest)[0]];
		} else {
			$x[array_keys($pBest)[0]] = $pBest[array_keys($pBest)[0]];
		}		
		return $x;
	}

	function bobot_inersia($constrictionFactor,$t,$tMax){
		$bobotInersia = $constrictionFactor + ((1-$constrictionFactor)*(1-($t/$tMax)));
		return $bobotInersia;
	}

	function kecepatan($constrictionFactor,$bobotInersia,$kecepatan,$t,$tMax,$pBest,$gBest,$x){	
		// echo '<pre>';print_r($gBest);
		$key = array_keys($pBest);
		// menghitung c1 * r1
		$c1_r1 = 1 * mt_rand(0,100)/100;
		// menghitung c2 * r1
		$c2_r2 = 2 * mt_rand(0,100)/100;
		// melakukan pengurangan pBest - X
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$pBest_x[$i][] = $x[$key[0]][$j] - $x[$i][$j];
			}
		}
		// melakukan pengurangan gBest - X
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$gBest_x[$i][] = $gBest[$j] - $x[$i][$j];
			}
		}
		
		// proses 1 : melakukan perkalian hasil c1 dan r1 dengan hasil pengurangan pBest dan X
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$c1_r1_pBest_x[$i][] = $pBest_x[$i][$j]*$c1_r1;
			}
		}		

		// proses 2 :  melakukan perkalian hasil c2 dan r2 dengan hasil pengurangan gBest dan X
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$c2_r2_gBest_x[$i][] = $gBest_x[$i][$j]*$c2_r2;
			}
		}				
		// proses 3 : melakukan penjumlahan proses 1 dan proses 2
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$proses3[$i][] = $c1_r1_pBest_x[$i][$j] + $c2_r2_gBest_x[$i][$j];
			}
		}	

		// melakukan perhitungan untuk 1/2 iterasi kebawah
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$w_v[$i][] = $bobotInersia * $kecepatan[$i][$j];
			}
		}			
		
		// melakukan perhitungan untuk 1/2 iterasi keatas
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$w_k[$i][] = $constrictionFactor *0.7* $kecepatan[$i][$j];
			}
		}			

		// menghitung kecepatan terbaru
		for ($i=0; $i < $this->partikel; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				if ($t < ($tMax/2)) {
					$kecepatanNew[$i][] = round($proses3[$i][$j] + $w_v[$i][$j]);
				} else {
					$kecepatanNew[$i][] = round($proses3[$i][$j] + $w_k[$i][$j]);
				}		
			}
		}
		return $kecepatanNew;		
	}

	function update_posisi($posisiAwal,$kecepatan){
		$x = array();		
		$Xmax[1] = $this->mPokok->getMax();
		$Xmax[2] = $this->mNabati->getMax();
		$Xmax[3] = $this->mHewani->getMax();
		$Xmax[4] = $this->mSayur->getMax();
		$Xmax[5] = $this->mBuah->getMax();
		for ($i=0; $i < $this->partikel; $i++) { 
			$y = 1;
			for ($j=0; $j < 14; $j++) { 
				$temp_x = abs($posisiAwal[$i][$j] + $kecepatan[$i][$j]);				
				if ($temp_x > $Xmax[$y]) {
					$temp_x = $temp_x % $Xmax[$y];
				}
				if ($temp_x == 0) {
					$temp_x = $Xmax[$y];
				}
				$x[$i][] =(int) $temp_x;
				$y++;
				if ($y > 5) {
					$y=1;
				}
			}
		}
		return $x;
	}

	function show_recommendation($xBest,$dataKebutuhan,$dataProcess,$dataDiri,$dataTheBest){		
		$j = 0;
		$getGizi[1] = $this->mPokok->getGizi($xBest[$j]);
		$getGizi[2] = $this->mNabati->getGizi($xBest[$j]);
		$getGizi[3] = $this->mHewani->getGizi($xBest[$j]);
		$getGizi[4] = $this->mSayur->getGizi($xBest[$j]);
		$getGizi[5] = $this->mBuah->getGizi($xBest[$j]);
		$y = 1;$i = 1;
		
		for ($j=0; $j < 14; $j++) { 
			$tempXBest['temp'.$j] = $xBest[$j];
			if ($y == 1) {
				$data['makanan'][$i][] = $this->mPokok->getGizi($xBest[$j])->nama;
				$data['berat'][$i][] = $this->mPokok->getGizi($xBest[$j])->berat;
			}elseif ($y == 2) {
				$data['makanan'][$i][] = $this->mNabati->getGizi($xBest[$j])->nama;
				$data['berat'][$i][] = $this->mNabati->getGizi($xBest[$j])->berat;
			}elseif ($y == 3) {
				$data['makanan'][$i][] = $this->mHewani->getGizi($xBest[$j])->nama;
				$data['berat'][$i][] = $this->mHewani->getGizi($xBest[$j])->berat;
			}elseif ($y == 4) {
				$data['makanan'][$i][] = $this->mSayur->getGizi($xBest[$j])->nama;
				$data['berat'][$i][] = $this->mSayur->getGizi($xBest[$j])->berat;
			}elseif ($y == 5) {
				$data['makanan'][$i][] = $this->mBuah->getGizi($xBest[$j])->nama;
				$data['berat'][$i][] = $this->mBuah->getGizi($xBest[$j])->berat;
			}
			if ($j == 13) {
				$data['makanan'][$i][] = " - ";
				$data['berat'][$i][] = " - ";
			}
			$y++;
			if ($y > 5) {
				$y=1; $i++;
			}
		}
		$this->mUser->temp($tempXBest);
		
		$data['kebutuhan'] = $dataKebutuhan;
		$data['process'] = $dataProcess;
		$data['dataDiri'] = $dataDiri;
		// Data Session
		$data['id'] = $this->session->userdata('id'); 
		$data['nama'] = $this->session->userdata('nama'); 
		$data['username'] = $this->session->userdata('username'); 
		$data['is_login'] = $this->session->userdata('is_login'); 
		$data['terbaik'] = $dataTheBest;
		$data['partikel'] = $this->partikel;
		$data['iterasiMax'] = $this->tMax;
		$data['active'] = "";
		$data['header']="template/template_header.php";
		$data['css']="Result/vResult_css";
		$data['content']="Result/vResult";
		$data['js']="Result/vResult_js.php";
		$data['footer']="template/template_footer.php";	
		$this->load->view('template/vtemplate',$data);
	}
}
