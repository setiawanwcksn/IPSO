<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Optimization extends CI_Controller {
	public function __construct(){
		parent :: __construct();
		$this->load->model("mPokok");	
		$this->load->model("mBuah");	
		$this->load->model("mHewani");		
		$this->load->model("mNabati");	
		$this->load->model("mSayur");	
	}

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
		$this->model_ipso($dataKebutuhan);

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

	function model_ipso($dataKebutuhan){
		$tMax = 10;
		for ($t=0; $t < $tMax; $t++) { 
			if ($t==0) {

				// inisialisasi awal partikel
				$x = $this->inisialisasi_awal();
				echo '<pre> posisi awal : '; print_r($x);
			}

			// hitung kandungan gizi
			$gizi = $this->kandungan_gizi($x);

			// hitung penalti gizi
			$penalti = $this->penalti_gizi($dataKebutuhan,$gizi);
			echo '<pre> penalti : '; print_r($penalti);

			// hitung fitness
			$fitness = $this->fitness($gizi,$penalti);
			echo '<pre> fitness : '; print_r($fitness);

			// menentukan PBest / Local Best
			$pBest= $this->pBest($fitness);
			echo '<pre> pbest : '; print_r($pBest);

			// menentukan GBest / Global Best
			if ($t == 0) {
				$gBest = $pBest;
			} 			
			$gBest = $this->gBest($gBest,$pBest);
			echo '<pre> gbest : '; print_r($gBest);
									
			// Menghitung Constriction Factor (K)			
			$constrictionFactor = $this->constriction_factor($t+1,$tMax);
			echo '<pre> K : '; print_r($constrictionFactor);

			// menghitung Bobot Inersia (W)
			$bobotInersia = $this->bobot_inersia($constrictionFactor,$t+1,$tMax);
			echo '<pre> w : '; print_r($bobotInersia);

			// menghitung kecepatan (V)
			if ($t == 0) {
				for ($i=0; $i < 4; $i++) { 
					for ($j=0; $j < 14; $j++) { 
						$kecepatan[$i][] = 0;
					}
				}
			}			
			$kecepatan = $this->kecepatan($constrictionFactor,$bobotInersia,$kecepatan,$t,$tMax,$pBest,$gBest,$x);
			echo '<pre> kecepatan : '; print_r($kecepatan);

			// Update Posisi (X)
			$x = $this->update_posisi($x,$kecepatan);
			echo '<pre> updated posisi : '; print_r($x);
		}
	}

	function inisialisasi_awal(){
		$Xmax[1] = $this->mPokok->getMax();
		$Xmax[2] = $this->mNabati->getMax();
		$Xmax[3] = $this->mHewani->getMax();
		$Xmax[4] = $this->mSayur->getMax();
		$Xmax[5] = $this->mBuah->getMax();

		$x = array();
		for ($i=0; $i < 4 ; $i++) { 	
			$y = 1;		
			for ($j=0; $j < 14; $j++) { 
				$x[$i][] = round(1 + (mt_rand(0,10)/10)*($Xmax[$y]-1));
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
		for ($i=0; $i < 4 ; $i++) { 	
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
				$totalPenalti = $totalPenalti + abs($gizi[$i][$j]-$dataKebutuhan[$j]);				
			}				
			$penalti[] = $totalPenalti;
		}
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
		// print_r($key);
		$pBest[$key[0]] = max($fitness);
		return $pBest;
	}

	function constriction_factor($t,$tMax){
		$constrictionFactor = (abs(cos((6.28/$tMax)*(($t-$tMax)/2)))+2.428571)/4;
		return $constrictionFactor;
	}

	function gBest($gBest,$pBest){
		return max($gBest,$pBest);
	}

	function bobot_inersia($constrictionFactor,$t,$tMax){
		$bobotInersia = $constrictionFactor + ((1-$constrictionFactor)*(1-($t/$tMax)));
		return $bobotInersia;
	}

	function kecepatan($constrictionFactor,$bobotInersia,$kecepatan,$t,$tMax,$pBest,$gBest,$x){			
		$key = array_keys($pBest);
		// menghitung c1 * r1
		$c1_r1 = 2 * mt_rand(0,100)/100;
		// menghitung c1 * r1
		$c2_r2 = 2 * mt_rand(0,100)/100;
		// melakukan pengurangan pBest - X
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$pBest_x[$i][] = $x[$key[0]][$j] - $x[$i][$j];
			}
		}
		// melakukan pengurangan gBest - X
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$gBest_x[$i][] = $x[$key[0]][$j] - $x[$i][$j];
			}
		}
		// proses 1 : melakukan perkalian hasil c1 dan r1 dengan hasil pengurangan pBest dan X
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$c1_r1_pBest_x[$i][] = $pBest_x[$i][$j]*$c1_r1;
			}
		}		
		// proses 2 :  melakukan perkalian hasil c2 dan r2 dengan hasil pengurangan gBest dan X
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$c2_r2_gBest_x[$i][] = $gBest_x[$i][$j]*$c2_r2;
			}
		}				
		// proses 3 : melakukan penjumlahan proses 1 dan proses 2
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$proses3[$i][] = $c1_r1_pBest_x[$i][$j] + $c2_r2_gBest_x[$i][$j];
			}
		}			

		// melakukan perhitungan untuk 1/2 iterasi kebawah
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$w_k[$i][] = $bobotInersia * $kecepatan[$i][$j];
			}
		}			
		
		// melakukan perhitungan untuk 1/2 iterasi keatas
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				$w_v[$i][] = $bobotInersia *0.7* $kecepatan[$i][$j];
			}
		}			

		// menghitung kecepatan terbaru
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < count($x[0]); $j++) { 
				if ($t < ($tMax/2)) {
					$kecepatanNew[$i][] = round($proses3[$i][$j] + $w_k[$i][$j]);
				} else {
					$kecepatanNew[$i][] = round($proses3[$i][$j] + $w_v[$i][$j]);
				}		
			}
		}
		return $kecepatanNew;		
	}

	function update_posisi($posisiAwal,$kecepatan){
		$x = array();
		for ($i=0; $i < 4; $i++) { 
			for ($j=0; $j < 14; $j++) { 
				$x[$i][] = $posisiAwal[$i][$j] + $kecepatan[$i][$j];
			}
		}

		return $x;
	}
}
