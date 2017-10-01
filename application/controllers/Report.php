<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct()
	{
		
		parent::__construct();
		//$this->load->model('m_responden','',TRUE);
		$this->load->model('m_user','',TRUE);
		$this->load->model('m_criteria','',TRUE);
		$this->load->model('m_bobot','',TRUE);
		$this->load->model('m_responden','',TRUE);
		$this->load->model('m_diskretisasi','',TRUE);
	   
	  
	}

	public function dapatkandata()
	{
		$result=[];
		$result[0]['count']=0;
		$result[0]['laki']=0;
		$result[0]['perempuan']=0;
		$result[0]['pendidikan_1']=0;
		$result[0]['pendidikan_2']=0;
		$result[0]['pendidikan_3']=0;
		$result[0]['pendidikan_4']=0;
		$result[0]['pendidikan_5']=0;
		$result[0]['pendidikan_6']=0;
		$result[0]['pendidikan_7']=0;

		$result[1]=[];

		$parResp=[];
		$data_responden=$this->m_responden->getresponden($parResp);
		$parCri=[];
		$data_criteria = $this->m_criteria->getcriteria($parCri);
		$parSubCri=[];
		$data_subcriteria = $this->m_criteria->getsubcriteria($parSubCri);
		$paruser = [];
		$data_user= $this->m_user->getuser($paruser);
		$parDiskretisasi=[];
		$data_diskretisasi= $this->m_diskretisasi->getdiskretisasi($parDiskretisasi);
		
		$data_subcriteria2=[];
		foreach ($data_subcriteria as $key => $value) {
			$data_subcriteria2[$value['id_subcriteria']]=$value;
		}
		$data_criteria2=[];
		foreach ($data_criteria as $key => $value) {
			$data_criteria2[$value['id_criteria']]=$value;
		}
		$data_user2=[];
		foreach ($data_user as $key => $value) {
			$data_user2[$value['id_user']]=$value;
		}
		$data['user']=$data_user2;		

		$result[0]['count']=sizeof($data_responden);
		//get jumlah laki perempuan
		
		foreach ($data_responden as $key => $value) {
			if($value['jenis_kelamin']=='1')
			{
				$result[0]['laki']++;
			}else
			{
				$result[0]['perempuan']++;
			}

			switch ($value['tingkat_pendidikan']) {
				case 1:
					$result[0]['pendidikan_1']++;
					break;
				case 2:
					$result[0]['pendidikan_2']++;
					break;
				case 3:
					$result[0]['pendidikan_3']++;
					break;
				case 4:
					$result[0]['pendidikan_4']++;
					break;
				case 5:
					$result[0]['pendidikan_5']++;
					break;
				case 6:
					$result[0]['pendidikan_6']++;
					break;
				default:
					$result[0]['pendidikan_7']++;
					break;
			}	
		}

		//hitung nomor 1;
		$ans_1=[];
		$ans_2=[];
		foreach ($data_responden as $key => $value) {
			//echo $value['answers_1'].'<br>';
			$exp_answers_1=explode(',', $value['answers_1']);
			$exp_answers_2=explode(',', $value['answers_2']);
			
			//ans_12 empty
			foreach ($data_subcriteria as $key => $value1) {
				$ans_1[$value['id_responden']][$value1['id_criteria_fk']][$value1['id_subcriteria']]=$exp_answers_1[$key];
				$ans_2[$value['id_responden']][$value1['id_criteria_fk']][$value1['id_subcriteria']]=$exp_answers_2[$key];
			}
		}
		

		$diskretisasi2=[];
		$batas_awal=1*10;
		foreach ($data_diskretisasi as $key => $value) {
			for ($i=$batas_awal; $i <= ($value['batas_akhir']*10); $i+=(0.5*10)) { 
				$diskretisasi2[$i]=$value;
			}
			$batas_awal=($value['batas_akhir']*10)+(0.5*10);
		}
		

		$diskretisasi3=[];
		foreach ($data_diskretisasi as $key => $value) {
			$diskretisasi3[$value['id_diskretisasi']]=$value;
		}

		$jadidiskretisasi=[];
		foreach ($ans_1 as $kresp => $resp) {
			foreach ($resp as $kcri => $cri) {
				foreach ($cri as $ksubcri => $subcri) {
					$jadidiskretisasi[$kresp][$kcri][$ksubcri]= $diskretisasi2[$subcri*10]['id_diskretisasi'];
				}
			}
		}

		$olahdiskretisasi=[];
		foreach ($jadidiskretisasi as $kresp => $resp) {
			foreach ($resp as $kcri => $cri) {
				foreach ($cri as $ksc => $subc) {
					if(!isset($olahdiskretisasi[$kcri][$ksc][$subc]['count']))
					{
						$olahdiskretisasi[$kcri][$ksc][$subc]['count']=0;
					}
					if(!isset($olahdiskretisasi[$kcri][$ksc][$subc]['avg']))
					{
						$olahdiskretisasi[$kcri][$ksc][$subc]['avg']=0;
					}
					$olahdiskretisasi[$kcri][$ksc][$subc]['count']=$olahdiskretisasi[$kcri][$ksc][$subc]['count']+1;
					$olahdiskretisasi[$kcri][$ksc][$subc]['avg']=$olahdiskretisasi[$kcri][$ksc][$subc]['count']/sizeof($jadidiskretisasi);
					ksort($olahdiskretisasi[$kcri][$ksc]);
				}
			}
		}

		//cek apakah ad kosong
		foreach ($olahdiskretisasi as $kcri => $cri) {
			foreach ($cri as $ksc => $sc) {
				foreach ($data_diskretisasi as $key => $value) {
					if (!isset($olahdiskretisasi[$kcri][$ksc][$value['id_diskretisasi']])) {
						$olahdiskretisasi[$kcri][$ksc][$value['id_diskretisasi']]['count']=0;
						$olahdiskretisasi[$kcri][$ksc][$value['id_diskretisasi']]['avg']=0;
					}
					ksort($olahdiskretisasi[$kcri][$ksc]);
				}
			}
		}

		$hitung1=[];
		foreach ($olahdiskretisasi as $kcri => $cri) {
			foreach ($cri as $ksc => $sc) {
				foreach ($sc as $kd => $dis) {
					$hitung1[$kcri][$ksc][$kd]=$dis['avg']*$bobot_subcriteria_dm[$kcri][$ksc];
				}
				
			}
		}

		$hitung1_sum=[];
		foreach ($hitung1 as $kc => $cri) {
			foreach ($cri as $ksc => $sc) {
				foreach ($sc as $kd => $dis) {
					if (!isset($hitung1_sum[$kc][$kd])) {
						$hitung1_sum[$kc][$kd]=0;
					}
					$hitung1_sum[$kc][$kd]=$hitung1_sum[$kc][$kd]+$dis;
				}
			}
		}

		$hitung2=[];
		foreach ($hitung1_sum as $kc => $cri) {
			foreach ($cri as $kd => $dis) {
				$hitung2[$kc][$kd]=$dis*$bobot_criteria_dm[$kc];
			}
		}

		$hitung2_sum=[];
		foreach ($hitung2 as $kc => $cri) {
			foreach ($cri as $kd => $dis) {
				if (!isset($hitung2_sum[$kd])) {
					$hitung2_sum[$kd]=0;
				}
				$hitung2_sum[$kd]=$hitung2_sum[$kd]+$dis;
			}
		}

		$hitung2prosentase=[];
		foreach ($hitung2_sum as $key => $value) {
			$hitung2prosentase[$key]=$value/array_sum($hitung2_sum)*100;
		}

		print_r($hitung2prosentase);
		break 1;



		return $result;

	}

	public function dl($tipedokumen)
	{

		$data=$this->dapatkandata();


		if ($tipedokumen == 'excel') {
			// echo 'excel';
		}else if($tipedokumen == "pdf")
		{
			// echo 'pdf';
		}

		$row=1;
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Report');
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Responden');
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1'.$row)->getFont()->setBold(true);
		$row++;
		$this->excel->getActiveSheet()->mergeCells('A'.$row.':I'.$row);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(44);
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Pemustaka yang menjadi responden pada penelitian mengenai tingkat kualitas layanan Perpustakaan menggunakan metode GDSS-AHP ini berjumlah '.$data[0]['count'].' responden, dengan distribusi berdasarkan jenis kelamin dan tingkat pendidikan yaitu :');
		$row++;
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Jenis Kelamin');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Laki-Laki');
		$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Perempuan');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, $data[0]['laki']);
		$this->excel->getActiveSheet()->setCellValue('B'.$row, $data[0]['perempuan']);
		$row++;
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Tingkat Pendidikan');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'SD');
		$this->excel->getActiveSheet()->setCellValue('B'.$row, 'SMP');
		$this->excel->getActiveSheet()->setCellValue('C'.$row, 'SMA');
		$this->excel->getActiveSheet()->setCellValue('D'.$row, 'S1');
		$this->excel->getActiveSheet()->setCellValue('E'.$row, 'S2');
		$this->excel->getActiveSheet()->setCellValue('F'.$row, 'S3');
		$this->excel->getActiveSheet()->setCellValue('G'.$row, 'Lain-Lain');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, $data[0]['pendidikan_1']);
		$this->excel->getActiveSheet()->setCellValue('B'.$row, $data[0]['pendidikan_2']);
		$this->excel->getActiveSheet()->setCellValue('C'.$row, $data[0]['pendidikan_3']);
		$this->excel->getActiveSheet()->setCellValue('D'.$row, $data[0]['pendidikan_4']);
		$this->excel->getActiveSheet()->setCellValue('E'.$row, $data[0]['pendidikan_5']);
		$this->excel->getActiveSheet()->setCellValue('F'.$row, $data[0]['pendidikan_6']);
		$this->excel->getActiveSheet()->setCellValue('G'.$row, $data[0]['pendidikan_7']);

		$row++;
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Hasil Penelitian');
		$this->excel->getActiveSheet()->getStyle('A1'.$row)->getFont()->setBold(true);
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Berdasarkan hasil penelitian dengan menggunakan metode GDSS-AHP LibQual, maka diperoleh hasil penelitian sebagai berikut :');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '1. Tingkat kepuasan responden terhadap kualitas layanan perpustakaan yaitu pada tingkat '.'0'.' dengan prosentase ('.'0'.'%), dengan rincian tingkat kepuasan sebagai berikut :');
		$row++;


		$row++;
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '2. Nilai evaluasi tiap butir pernyataan yang dinyatakan dalam bentuk persepsi berbobot dan ekspektasi berbobot serta analisis A58kuadran IPA, sebagai berikut:');
		$row++;

		$row++;
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '2. Rekomendasi evaluasi layanan:');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Untuk meningkatkan kualitas layanan perpustakaan diharapkan pengelola perpustakaan melakukan hal-hal sebagai berikut:');
		$row++;
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '1');
		$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Memberikan perhatian khusus (prioritas) terhadap item pernyataan dalam Kuadran 1 (concentrate here), dimana pada kuadran ini item evaluasi dianggap penting oleh pelanggan, tetapi pada kenyataannya item ini belum sesuai dengan harapan pelanggan (tingkat kepuasan yang diperoleh masih rendah). Item evaluasi yang harus diperhatikan/diprioritaskan adalah sebagai berikut : MASUKAN ITEM KUADRAN 1');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '2');
		$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Mempertahankan kinerja terhadap item evaluasi dalam Kuadran 2 (keep up the good work), di mana pada kuadran ini item evaluasi dianggap penting oleh pelanggan, dan dianggap pelanggan sudah sesuai dengan yang dirasakannya sehingga tingkat kepuasannya relatif lebih tinggi. item evaluasi ini menjadikan produk atau jasa unggul di mata pelanggan. Item evaluasi yang harus dipertahankan adalah sebagai berikut: MASUKAN ITEM KUADRAN 2');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '3');
		$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Mempertimbangkan kinerja terhadap item evaluasi dalam Kuadran 3 (low priority), di mana pada kuadran ini item evaluasi dianggap kurang penting oleh pelanggan, dan pada kenyatannya kinerjanya tidak terlalu istimewa. Peningkatan item evaluasi yang termasuk dalam kuadran ini dapat dipertimbangkan kembali karena pengaruhnya terhadap manfaat yang dirasakan oleh pelanggan sangat kecil. Item evaluasi yang harus dipertimbangkan adalah sebagai berikut: MASUKAN ITEM KUADRAN 3');
		$row++;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '4');
		$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Mengurangi (mengabaikan) kinerja terhadap item evaluasi dalam Kuadran 4 (possible overkill), di mana pada kuadran ini item evaluasi dianggap kurang penting oleh pelanggan, dan dirasakan terlalu berlebihan. Item evaluasi yang termasuk dalam kuadran ini dapat dikurangi agar perpustakaan dapat menghemat biaya. Item evaluasi yang dapat diabaikan adalah sebagai berikut: MASUKAN ITEM KUADRAN 4');



		//merge cell A1 until D1
	
		$filename='Report.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');

	}

}
