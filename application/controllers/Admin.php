<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	function __construct()
	{
		
		parent::__construct();
		//$this->load->model('m_responden','',TRUE);
		$this->load->model('m_user','',TRUE);
		$this->load->model('m_criteria','',TRUE);
		$this->load->model('m_bobot','',TRUE);
		$this->load->model('m_responden','',TRUE);
		$this->load->model('m_diskretisasi','',TRUE);
		$this->load->model('m_jawaban','',TRUE);

	   	if($this->session->userdata('logged_in_admin'))
	   	{
	   		$session_data = $this->session->userdata('logged_in_admin');
	   		
   			$this->ses_id = $session_data['id'];
   			$this->ses_username = $session_data['username'];
   			$this->ses_name = $session_data['name'];
   			$this->ses_role = $session_data['role'];
		}else
		{
			redirect('loginadmin', 'refresh');
		}
	}
	public function logout()
	{
		$this->session->unset_userdata('logged_in_admin');
	   	session_destroy();
		redirect('admin', 'refresh');	
	}
	public function index()
	{
		$data['page']='';
		
		$this->load->view('admin/base_admin',$data);
	}
	public function usermanagement()
	{
		$paruser=[];
		$data_user = $this->m_user->getuser($paruser);
		$data['page']='User Management';
		$data['users']=$data_user;
		$this->load->view('admin/base_admin',$data);
	}
	public function responden()
	{
		$parresponden=[];
		$data_responden = $this->m_responden->getresponden($parresponden);
		$parSubCri=[];
		$data_subcrieria = $this->m_criteria->getsubcriteria($parSubCri);
		$parJawaban=[];
		$data_jawaban = $this->m_jawaban->getjawaban($parJawaban);

		$jawaban2=[];
		foreach ($data_responden as $key_r => $value) {
			foreach ($data_subcrieria as $key_s => $value2) {
				$jawaban2[$value['id_responden']][$value2['id_subcriteria']][1]=null;
				$jawaban2[$value['id_responden']][$value2['id_subcriteria']][2]=null;
			}
		}
		foreach ($data_jawaban as $key => $value) {
			$jawaban2[$value['id_responden_fk']][$value['id_subcriteria_fk']][$value['tipe']]=$value['jawaban'];
		}
		// echo '<pre>';
		// print_r($jawaban2);
		// break 1 ;
		foreach ($data_responden as $key => $value) {
			
			$answers_1='';
			$answers_2='';
			foreach ($jawaban2[$value['id_responden']] as $keysubc => $subc) {
				$answers_1=$answers_1.$subc[1].',';
				$answers_2=$answers_2.$subc[2].',';
			}
			$data_responden[$key]['answers_1']=$answers_1;
			$data_responden[$key]['answers_2']=$answers_2;
		}
		// echo '<pre>';
		// print_r($data_responden);
		// break 1 ;


		$data['page']='Responden';
		$data['responden']=$data_responden;
		$data['subcriteria']=$data_subcrieria;
		$data['jawaban']=$data_jawaban;


		

		$this->load->view('admin/base_admin',$data);
	}
	public function diskretisasi()
	{
		$pardiskretisasi=[];
		$data_diskretisasi = $this->m_diskretisasi->getdiskretisasi($pardiskretisasi);
		$data['page']='Diskretisasi';
		$data['diskretisasi']=$data_diskretisasi;
		$this->load->view('admin/base_admin',$data);
	}
	public function report()
	{
		$data['page']='Report';
		$this->load->view('admin/base_admin',$data);
	}
	public function dl($tipedokumen)
	{
		if ($tipedokumen == 'excel') {
			$this->reportexcel();
		}else if($tipedokumen == "pdf") {
			$this->reportpdf();
		}
	}
	private function reportpdf()
	{
		$data=$this->dapatkandata();
		$hasp=$this->perhitunganpisah();
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$sheet = $this->excel->getActiveSheet();
  		$sheet->fromArray(
			array(
				array('',	2010,	2011,	2012),
				array('Q1',   12,   15,		21),
				array('Q2',   56,   73,		86),
				array('Q3',   52,   61,		69),
				array('Q4',   30,   32,		0),
			)
		);
		$dataseriesLabels1 = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1), 
		);
		$xAxisTickValues1 = array(
		new PHPExcel_Chart_DataSeriesValues('String','Worksheet!$A$2:$A$5', NULL, 4),  
		);
		$dataSeriesValues1 = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$5', NULL, 4), 
		);
		$series = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_PIECHART,       // plotType
			PHPExcel_Chart_DataSeries::GROUPING_STANDARD,  // plotGrouping
			range(0, count($dataSeriesValues1)-1),          // plotOrder
			$dataseriesLabels1,                   // plotLabel
			$xAxisTickValues1,                    // plotCategory
			$dataSeriesValues1                    // plotValues
		);
		$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_VERTICAL);
		$layout = new PHPExcel_Chart_Layout();
		$layout->setShowVal(TRUE);
		$layout->setShowPercent(TRUE);
		$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
		$xTitle = new PHPExcel_Chart_Title('xAxisLabel');
		$yTitle = new PHPExcel_Chart_Title('yAxisLabel');
		$title1 = new PHPExcel_Chart_Title('Jenis Kelamin');
		$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
		$chart = new PHPExcel_Chart('sample', $title1, $legend1, $plotarea, true,0,NULL,NULL);
		$chart->setTopLeftPosition('A7');
		$chart->setBottomRightPosition('H20');
		$sheet->addChart($chart);
		$dataSeriesLabels2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$C$1', NULL, 1),	//	2011
		);
		$xAxisTickValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Worksheet!$A$2:$A$5', NULL, 4),	//	Q1 to Q4
		);
		$dataSeriesValues2 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Worksheet!$C$2:$C$5', NULL, 4),
		);
		//	Build the dataseries
		$series2 = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_DONUTCHART,		// plotType
			NULL,			                                // plotGrouping (Donut charts don't have any grouping)
			range(0, count($dataSeriesValues2)-1),			// plotOrder
			$dataSeriesLabels2,								// plotLabel
			$xAxisTickValues2,								// plotCategory
			$dataSeriesValues2								// plotValues
		);
		$series2->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_VERTICAL);
		$layout2 = new PHPExcel_Chart_Layout();
		$layout2->setShowVal(TRUE);
		$layout2->setShowPercent(TRUE);
		$plotarea = new PHPExcel_Chart_PlotArea($layout2, array($series2));
		$xTitle = new PHPExcel_Chart_Title('xAxisLabel');
		$yTitle = new PHPExcel_Chart_Title('yAxisLabel');
		$title2 = new PHPExcel_Chart_Title('Tingkat Pendidikan');
		$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
		$chart2 = new PHPExcel_Chart('sample', $title2, $legend2, $plotarea, true,0,NULL,NULL);
		//	Set the position where the chart should appear in the worksheet
		$chart2->setTopLeftPosition('I7');
		$chart2->setBottomRightPosition('P20');
		//	Add the chart to the worksheet
		$sheet->addChart($chart2);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="graph.xlsx"');
		header('Cache-Control: max-age=0');
		
		$writer = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		$writer->setIncludeCharts(TRUE);
		$writer->save('php://output');
	}
	private function reportexcel()
	{
		$data=$this->dapatkandata();
		$hasp=$this->perhitunganpisah();

		$styleArray = array(
	    'font'  => array(
	        'size'  => 8,
	        'name'  => 'Verdana'
	    ));


		$row=1;
		$this->load->library('excel');
		$borderArray = array(
	      'borders' => array(
	          'allborders' => array(
	              'style' => PHPExcel_Style_Border::BORDER_THIN
	          )
	      )
	  );
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('Report');
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Responden');
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		$this->excel->getActiveSheet()->getStyle('A1'.$row)->getFont()->setBold(true);
		$row++;
		$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(44);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
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
		$row=$row+10;
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Hasil Penelitian');
		$this->excel->getActiveSheet()->getStyle('A1'.$row)->getFont()->setBold(true);
		$row++;
		$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(40);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Berdasarkan hasil penelitian dengan menggunakan metode GDSS-AHP LibQual, maka diperoleh hasil penelitian sebagai berikut :');
		$row++;
		
		$id_diskretisasi_max=0;
		foreach ($hasp['view']['hasil']['libq']['prosentase'] as $key => $value) {
			if($value == max($hasp['view']['hasil']['libq']['prosentase']))
			{
				$id_diskretisasi_max=$key;
			}
		}
		$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(40);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '1. Tingkat kepuasan responden terhadap kualitas layanan perpustakaan yaitu pada tingkat '.$hasp['diskretisasi3'][$id_diskretisasi_max]['diskretisasi_panjang'].' ('.$hasp['diskretisasi3'][$id_diskretisasi_max]['diskretisasi'].')'.' dengan prosentase ('.round(max($hasp['view']['hasil']['libq']['prosentase']),5).'%), dengan rincian tingkat kepuasan sebagai berikut :');
		$row++;
		$alphabet='B';
		foreach ($hasp['diskretisasi'] as $key => $value) { 
			$this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
			$this->excel->getActiveSheet()->getStyle($alphabet.$row)->getAlignment()->setWrapText(true); 
			$this->excel->getActiveSheet()->getStyle($alphabet.$row)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle($alphabet.$row)->applyFromArray($borderArray);
			$this->excel->getActiveSheet()->setCellValue($alphabet.$row, $value['diskretisasi_panjang'].' ('.$value['diskretisasi'].')');
			$alphabet++;
		}
		$row++;
		$alphabet='B';
		foreach ($hasp['view']['hasil']['libq']['prosentase'] as $key => $value) {
			$this->excel->getActiveSheet()->getDefaultColumnDimension()->setWidth(12);
			$this->excel->getActiveSheet()->getStyle($alphabet.$row)->getAlignment()->setWrapText(true); 
			$this->excel->getActiveSheet()->getStyle($alphabet.$row)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle($alphabet.$row)->applyFromArray($borderArray);
			$this->excel->getActiveSheet()->setCellValue($alphabet.$row, round($value,5).'%');
			$alphabet++;
		}
		$row++;
		$row++;
		$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(40);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A'.$row, '2. Nilai evaluasi tiap butir pernyataan yang dinyatakan dalam bentuk persepsi berbobot dan ekspektasi berbobot serta analisis A58kuadran IPA, sebagai berikut:');
		$row++;
		$this->excel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($borderArray);
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'ID Pernyataan Kuesioner');
		$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Persepsi Berbobot');
		$this->excel->getActiveSheet()->setCellValue('C'.$row, 'Ekspektasi Berbobot');
		$this->excel->getActiveSheet()->setCellValue('D'.$row, 'Kuadran');
		$row++;
		$tiapkuadran[1]=[];
		$tiapkuadran[2]=[];
		$tiapkuadran[3]=[];
		$tiapkuadran[4]=[];
		$tiapkuadran[5]=[];
		foreach ($hasp['view']['hasil']['ipa']['kuadran'] as $kc => $cri) {
			foreach ($cri as $ksc => $sc) {
				$this->excel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->getAlignment()->setWrapText(true); 
				$this->excel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($styleArray);
				$this->excel->getActiveSheet()->getStyle('A'.$row.':D'.$row)->applyFromArray($borderArray);
				$this->excel->getActiveSheet()->setCellValue('A'.$row, $ksc);
				$this->excel->getActiveSheet()->setCellValue('B'.$row, $sc[1]);
				$this->excel->getActiveSheet()->setCellValue('C'.$row, $sc[2]);
				$this->excel->getActiveSheet()->setCellValue('D'.$row, 'Kuadran '.$sc['posisi']);
				$row++;
				// switch ($sc['posisi']) {
				// 	case 'A':
				// 		$tiapkuadran[1][]=$ksc;
				// 		break;
				// 	case 'B':
				// 		$tiapkuadran[2][]=$ksc;
				// 		break;
				// 	case 'C':
				// 		$tiapkuadran[3][]=$ksc;
				// 		break;
				// 	case 'D':
				// 		$tiapkuadran[4][]=$ksc;
				// 		break;
				// 	default:
				// 		$tiapkuadran[5][]=$ksc;
				// 		break;
				// }
				$tiapkuadran[$sc['posisi']][]=$ksc;
			}
		}
		$row++;
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Rekomendasi evaluasi layanan:');
		$row++;
		$this->excel->getActiveSheet()->mergeCells('A'.$row.':H'.$row);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true); 
		$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(40);
		$this->excel->getActiveSheet()->getStyle('A'.$row)->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A'.$row, 'Untuk meningkatkan kualitas layanan perpustakaan diharapkan pengelola perpustakaan melakukan hal-hal sebagai berikut:');
		$row++;
		$row++;
		$num=1;
		if (sizeof($tiapkuadran[1]) > 0) {
			$this->excel->getActiveSheet()->setCellValue('A'.$row, $num);
			$this->excel->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true); 
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(50);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Memberikan perhatian khusus (prioritas) terhadap item pernyataan dalam Kuadran 1 (concentrate here), dimana pada kuadran ini item evaluasi dianggap penting oleh pelanggan, tetapi pada kenyataannya item ini belum sesuai dengan harapan pelanggan (tingkat kepuasan yang diperoleh masih rendah). Item evaluasi yang harus diperhatikan/diprioritaskan adalah sebagai berikut : ');
			$row++;
			foreach ($tiapkuadran[1] as $key => $value) {
				$this->excel->getActiveSheet()->setCellValue('B'.$row, $value.'. '.$hasp['subcriteria2'][$value]['subcriteria']);
				$row++;
			}
			$num++;
			$row++;
		}
		if (sizeof($tiapkuadran[2]) > 0) {
			$this->excel->getActiveSheet()->setCellValue('A'.$row, $num);
			$this->excel->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true); 
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(60);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Mempertahankan kinerja terhadap item evaluasi dalam Kuadran 2 (keep up the good work), di mana pada kuadran ini item evaluasi dianggap penting oleh pelanggan, dan dianggap pelanggan sudah sesuai dengan yang dirasakannya sehingga tingkat kepuasannya relatif lebih tinggi. item evaluasi ini menjadikan produk atau jasa unggul di mata pelanggan. Item evaluasi yang harus dipertahankan adalah sebagai berikut :');
			$row++;
			foreach ($tiapkuadran[2] as $key => $value) {
				$this->excel->getActiveSheet()->setCellValue('B'.$row, $value.'. '.$hasp['subcriteria2'][$value]['subcriteria']);
				$row++;
			}
			$num++;
			$row++;
		}
		if (sizeof($tiapkuadran[3]) > 0) {
			$this->excel->getActiveSheet()->setCellValue('A'.$row, $num);
			$this->excel->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true); 
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(60);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Mempertimbangkan kinerja terhadap item evaluasi dalam Kuadran 3 (low priority), di mana pada kuadran ini item evaluasi dianggap kurang penting oleh pelanggan, dan pada kenyatannya kinerjanya tidak terlalu istimewa. Peningkatan item evaluasi yang termasuk dalam kuadran ini dapat dipertimbangkan kembali karena pengaruhnya terhadap manfaat yang dirasakan oleh pelanggan sangat kecil. Item evaluasi yang harus dipertimbangkan adalah sebagai berikut :');
			$row++;
			foreach ($tiapkuadran[3] as $key => $value) {
				$this->excel->getActiveSheet()->setCellValue('B'.$row, $value.'. '.$hasp['subcriteria2'][$value]['subcriteria']);
				$row++;
			}
			$num++;
			$row++;
		}
		if (sizeof($tiapkuadran[4]) > 0) {
			$this->excel->getActiveSheet()->setCellValue('A'.$row, $num);
			$this->excel->getActiveSheet()->mergeCells('B'.$row.':H'.$row);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->getAlignment()->setWrapText(true); 
			$this->excel->getActiveSheet()->getRowDimension($row)->setRowHeight(50);
			$this->excel->getActiveSheet()->getStyle('B'.$row)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->setCellValue('B'.$row, 'Mengurangi (mengabaikan) kinerja terhadap item evaluasi dalam Kuadran 4 (possible overkill), di mana pada kuadran ini item evaluasi dianggap kurang penting oleh pelanggan, dan dirasakan terlalu berlebihan. Item evaluasi yang termasuk dalam kuadran ini dapat dikurangi agar perpustakaan dapat menghemat biaya. Item evaluasi yang dapat diabaikan adalah sebagai berikut :');
			$row++;
			foreach ($tiapkuadran[4] as $key => $value) {
				$this->excel->getActiveSheet()->setCellValue('B'.$row, $value.'. '.$hasp['subcriteria2'][$value]['subcriteria']);
				$row++;
			}
			$num++;
			$row++;
		}
		
		//merge cell A1 until D1
		//charts
		$dataseriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Report!$A$4', NULL, 1), 
		);
		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('String','Report!$A$5:$B$5', NULL, 2),  
		);
		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Report!$A$6:$B$6', NULL, 2), 
		);
		$series = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_PIECHART,       // plotType
			NULL,  // plotGrouping
			range(0, count($dataSeriesValues1)-1),          // plotOrder
			$dataseriesLabels1,                   // plotLabel
			$xAxisTickValues1,                    // plotCategory
			$dataSeriesValues1                    // plotValues
		);
		$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		$layout = new PHPExcel_Chart_Layout();
		$layout->setShowVal(TRUE);
		$layout->setShowPercent(TRUE);
		$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
		$xTitle = new PHPExcel_Chart_Title('xAxisLabel');
		$yTitle = new PHPExcel_Chart_Title('yAxisLabel');
		$title1 = new PHPExcel_Chart_Title('Jenis Kelamin');
		$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
		$chart = new PHPExcel_Chart('sample', $title1, $legend1, $plotarea, true,0,NULL,NULL);
		$chart->setTopLeftPosition('A4');
		$chart->setBottomRightPosition('E20');
		$this->excel->getActiveSheet()->addChart($chart);
		//chart 2
		$dataseriesLabels1 = array(
			new PHPExcel_Chart_DataSeriesValues('String', 'Report!$A$8', NULL, 1), 
		);
		$xAxisTickValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('String','Report!$A$9:$G$9', NULL, 2),  
		);
		$dataSeriesValues1 = array(
			new PHPExcel_Chart_DataSeriesValues('Number', 'Report!$A$10:$G$10', NULL, 2), 
		);
		$series = new PHPExcel_Chart_DataSeries(
			PHPExcel_Chart_DataSeries::TYPE_PIECHART,       // plotType
			NULL,  // plotGrouping
			range(0, count($dataSeriesValues1)-1),          // plotOrder
			$dataseriesLabels1,                   // plotLabel
			$xAxisTickValues1,                    // plotCategory
			$dataSeriesValues1                    // plotValues
		);
		$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		$layout = new PHPExcel_Chart_Layout();
		$layout->setShowVal(TRUE);
		$layout->setShowPercent(TRUE);
		$plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
		$xTitle = new PHPExcel_Chart_Title('xAxisLabel');
		$yTitle = new PHPExcel_Chart_Title('yAxisLabel');
		$title1 = new PHPExcel_Chart_Title('Tingkat Pendidikan');
		$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
		$chart2 = new PHPExcel_Chart('sample', $title1, $legend1, $plotarea, true,0,NULL,NULL);
		$chart2->setTopLeftPosition('E4');
		$chart2->setBottomRightPosition('I20');
		$this->excel->getActiveSheet()->addChart($chart2);
		//f36
		//O58
		// $dataseriesLabels1 = array(
		// 	new PHPExcel_Chart_DataSeriesValues('String', 'Report!$A$8', NULL, 1), 
		// );
		// $xAxisTickValues1 = array(
		// 	new PHPExcel_Chart_DataSeriesValues('String','Report!$A$36:$A$57', NULL, 2),  
		// );
		// $dataSeriesValues1 = array(
		// 	new PHPExcel_Chart_DataSeriesValues('Number', 'Report!$B$36:$B$57', NULL, 2), 
		// );
		// $series = new PHPExcel_Chart_DataSeries(
		// 	PHPExcel_Chart_DataSeries::TYPE_SCATTERCHART,       // plotType
		// 	NULL,  // plotGrouping
		// 	range(0, count($dataSeriesValues1)-1),          // plotOrder
		// 	$dataseriesLabels1,                   // plotLabel
		// 	$xAxisTickValues1,                    // plotCategory
		// 	$dataSeriesValues1                    // plotValues
		// );
		// $series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
		// $layout = new PHPExcel_Chart_Layout();
		// $layout->setShowVal(TRUE);
		// $layout->setShowPercent(TRUE);
		// $plotarea = new PHPExcel_Chart_PlotArea($layout, array($series));
		// $xTitle = new PHPExcel_Chart_Title('xAxisLabel');
		// $yTitle = new PHPExcel_Chart_Title('yAxisLabel');
		// $title1 = new PHPExcel_Chart_Title('Tingkat Pendidikan');
		// $legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
		// $chart3 = new PHPExcel_Chart('sample', $title1, $legend1, $plotarea, true,0,NULL,NULL);
		// $chart3->setTopLeftPosition('F36');
		// $chart3->setBottomRightPosition('O58');
		// $this->excel->getActiveSheet()->addChart($chart3);
	
		$filename='Report.xls'; //save our workbook as this file name
		header('Cache-Control: max-age=0'); //no cache
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0');
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
		$objWriter->setIncludeCharts(TRUE);
		$objWriter->save('php://output');
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
		return $result;
	}
	public function perhitungan()
	{
		
		$data=$this->perhitunganpisah();
		$this->load->view('admin/base_admin',$data);
	}
	public function perhitunganpisah()
	{
		$data=[];
		$view['hasil']=null;
		$view['perhitungan']=null;
		$view['perhitungan']['bobot']=null;
		$parResp=[];
		$data_responden=$this->m_responden->getresponden($parResp);
		$parCri=[];
		$data_criteria = $this->m_criteria->getcriteria($parCri);
		$parSubCri=[];
		$data_subcriteria = $this->m_criteria->getsubcriteria($parSubCri);
		$data_jawaban = $this->m_jawaban->getjawaban([]);

		$jawaban2=[];
		foreach ($data_responden as $key_r => $value) {
			foreach ($data_subcriteria as $key_s => $value2) {
				$jawaban2[$value['id_responden']][$value2['id_subcriteria']][1]=null;
				$jawaban2[$value['id_responden']][$value2['id_subcriteria']][2]=null;
			}
		}
		foreach ($data_jawaban as $key => $value) {
			$jawaban2[$value['id_responden_fk']][$value['id_subcriteria_fk']][$value['tipe']]=$value['jawaban'];
		}
		// echo '<pre>';
		// print_r($jawaban2);
		// break 1 ;
		foreach ($data_responden as $key => $value) {
			
			$answers_1='';
			$answers_2='';
			foreach ($jawaban2[$value['id_responden']] as $keysubc => $subc) {
				$answers_1=$answers_1.$subc[1].',';
				$answers_2=$answers_2.$subc[2].',';
			}
			$data_responden[$key]['answers_1']=$answers_1;
			$data_responden[$key]['answers_2']=$answers_2;
		}

		$paruser['role !='] = 1;
		$data_user= $this->m_user->getuser($paruser);
		// $data_porsi=[];
		$data_subcriteria2=[];
		foreach ($data_subcriteria as $key => $value) {
			$data_subcriteria2[$value['id_subcriteria']]=$value;
		}
		$data['subcriteria']=$data_subcriteria;
		$data['subcriteria2']=$data_subcriteria2;
		$data_criteria2=[];
		foreach ($data_criteria as $key => $value) {
			$data_criteria2[$value['id_criteria']]=$value;
		}
		$data['criteria']=$data_criteria2;
		$data_user2=[];
		foreach ($data_user as $key => $value) {
			$data_user2[$value['id_user']]=$value;
		}
		$data['user']=$data_user2;
		foreach ($data_user as $key => $valueuser) {
			// $data_porsi[$valueuser['id_user']]=$valueuser['porsi_bobot'];
			// if($valueuser['porsi_bobot']!="")
			// {
			if($valueuser['role']!=1)
			{
				$parbobot['id_user_fk']=$valueuser['id_user'];
				$data_bobot = $this->m_bobot->getbobot($parbobot);
				
				////atur bobot
				$bobot2=null;
				foreach ($data_bobot as $key => $value) {
					$bobot2[$value['type']][$value['id_target_1']][$value['id_target_2']][1]=(($value['lebihpenting'] == 1) ? $value['bobot'] : 1) ;
					$bobot2[$value['type']][$value['id_target_1']][$value['id_target_2']][2]=(($value['lebihpenting'] == 2) ? $value['bobot'] : 1) ;
					
				}
				// echo '<pre>';
				// print_r($bobot2);
				// break 1;
				$tbl_criteria=[];
				$tbl_subcriteria=[];
				foreach ($data_criteria as $i => $value1) {
					foreach ($data_criteria as $j => $value2) {
						$isi1=0;
						$isi2=0;
						if ($value1['id_criteria']==$value2['id_criteria']) {
							$isi1=1;
							$isi2=1;
						}
						else{
							if (isset($bobot2[1][$value1['id_criteria']][$value2['id_criteria']][1])) {
								$isi1=$bobot2[1][$value1['id_criteria']][$value2['id_criteria']][1];
								$isi2=$bobot2[1][$value1['id_criteria']][$value2['id_criteria']][2];
							}else
							{
								$isi1=$bobot2[1][$value2['id_criteria']][$value1['id_criteria']][2];
								$isi2=$bobot2[1][$value2['id_criteria']][$value1['id_criteria']][1];
							}
							
						}	
						$tbl_criteria[$value1['id_criteria']][$value2['id_criteria']][1]=$isi1;	
						$tbl_criteria[$value1['id_criteria']][$value2['id_criteria']][2]=$isi2;	
					}
					$tbl_subcriteria[$value1['id_criteria']]=[];
					$datasubberidcriteria=null;
					foreach ($data_subcriteria as $key => $valuesub) {
						if ($value1['id_criteria']==$valuesub['id_criteria_fk']) {
							$datasubberidcriteria[]=$valuesub;
							// echo $valuesub['id_subcriteria'].' masuk. count: '.sizeof($datasubberidcriteria).'<br>';
						}
						
					}
					if (!isset($datasubberidcriteria)) {
						$datasubberidcriteria=[];
					}
					foreach ($datasubberidcriteria as $key => $valu1) {
						foreach ($datasubberidcriteria as $key => $valu2) {
							$isi1=0;
							$isi2=0;
							if ($valu1['id_subcriteria']==$valu2['id_subcriteria']) {
								$isi1=1;
								$isi2=1;
							}
							else{
								if (isset($bobot2[2][$valu1['id_subcriteria']][$valu2['id_subcriteria']][1])) {
									$isi1=$bobot2[2][$valu1['id_subcriteria']][$valu2['id_subcriteria']][1];
									$isi2=$bobot2[2][$valu1['id_subcriteria']][$valu2['id_subcriteria']][2];
								}else
								{
									// echo $value2['id_criteria'].' - '.$value1['id_criteria'];
									$isi1=$bobot2[2][$valu2['id_subcriteria']][$valu1['id_subcriteria']][2];
									$isi2=$bobot2[2][$valu2['id_subcriteria']][$valu1['id_subcriteria']][1];
								}
								
							}	
							$tbl_subcriteria[$value1['id_criteria']][$valu1['id_subcriteria']][$valu2['id_subcriteria']][1]=$isi1;	
							$tbl_subcriteria[$value1['id_criteria']][$valu1['id_subcriteria']][$valu2['id_subcriteria']][2]=$isi2;	
						}
					}
				}
				
				$bobotcriteria=[];
				$criteria_sum=[];
				$criteria_perkalian=[];
				$nilai_akar_3=[];
				$sum_nilai_akar_3=0;
				$normalisasi=[];
				foreach ($tbl_criteria as $key => $value) {
					
					foreach ($value as $key1 => $va) {
						$nil=0;
						if(($va[1]=="") && ($va[2]==""))
						{
							$nil=0;
						}else
						{
							$nil=($va[1]/$va[2]);
						}
						if (isset($criteria_sum[$key1])) {
							$criteria_sum[$key1]=$criteria_sum[$key1]+$nil;
						}else
						{
							$criteria_sum[$key1]=$nil;
						}
						if (isset($criteria_perkalian[$key])) {
							$criteria_perkalian[$key]= $criteria_perkalian[$key]*$nil;
						}else
						{
							$criteria_perkalian[$key]=$nil;
						}
								
					}
				}
				
				foreach ($criteria_perkalian as $key => $value) {
					$nilai_akar_3[$key]=pow($value, (1/sizeof($tbl_criteria)));
					
				}
				$sum_nilai_akar_3=array_sum($nilai_akar_3);
				foreach ($nilai_akar_3 as $key => $value) {
					if (!$sum_nilai_akar_3) {
						$sum_nilai_akar_3=0;
					}
					else
					{
						$normalisasi[$key]=$value/$sum_nilai_akar_3;
					}
					
				}
				$bobotcriteria=$normalisasi;

				$view['perhitungan']['ipa']['bobot_criteria'][$valueuser['id_user']]=$bobotcriteria;
				//menghitung bobot sub
				$bobotsubcriteria=[];
				foreach ($tbl_subcriteria as $kcri => $valpersub) {
					$criteria_sum=[];
					$criteria_perkalian=[];
					$nilai_akar_3=[];
					$sum_nilai_akar_3=0;
					$normalisasi=[];
					foreach ($valpersub as $key => $value) {
						foreach ($value as $key1 => $va) {
							$nil=0;
							if(($va[1]=="") && ($va[2]==""))
							{
								$nil=0;
							}else
							{
								$nil=($va[1]/$va[2]);
							}
							if (isset($criteria_sum[$key1])) {
								$criteria_sum[$key1]=$criteria_sum[$key1]+$nil;
							}else
							{
								$criteria_sum[$key1]=$nil;
							}
							if (isset($criteria_perkalian[$key])) {
								$criteria_perkalian[$key]= $criteria_perkalian[$key]*$nil;
							}else
							{
								$criteria_perkalian[$key]=$nil;
							}
							
						}
					}
					foreach ($criteria_perkalian as $key => $value) {
						$nilai_akar_3[$key]=pow($value, (1/sizeof($valpersub)));
						
					}
					$sum_nilai_akar_3=array_sum($nilai_akar_3);
					foreach ($nilai_akar_3 as $key => $value) {
						if($sum_nilai_akar_3)
						{
							$normalisasi[$key]=$value/$sum_nilai_akar_3;
						}else
						{
							$normalisasi[$key]=0;
						}
					}
					
					$bobotsubcriteria[$kcri]=$normalisasi;
				}
				// echo '<pre>';
				// print_r($bobotcriteria);
				// print_r($bobotsubcriteria);
				//menghitung DM
				// print_r($bobotcriteria);
				// print_r($bobotsubcriteria);
				
				$bobot_global=[];
				foreach ($bobotsubcriteria as $kcri => $vcri) {
					foreach ($vcri as $key => $value) {
						// if (!isset($bobotcriteria[$kcri])) {
						// 	$bobotcriteria[$kcri]=0;
						// }
						// echo $bobotcriteria[$kcri].' x '.$value;
						// echo '<br>';
						$bobot_global[$kcri][$key]=$value*$bobotcriteria[$kcri];
							
					}
				}
				// break 1;
				// echo '<pre>';
				// print_r($bobot_dm);
				// break 1;

				// echo '<pre>';
				// print_r($bobot_global);
				// break 2;
				$view['perhitungan']['ipa']['bobot_subcriteria'][$valueuser['id_user']]=$bobot_global;
			}
		}
		$bobot_criteria_dm=[];
		if (!isset($view['perhitungan']['ipa']['bobot_criteria'])) {
			$view['perhitungan']['ipa']['bobot_criteria']=[];
		}
		foreach ($view['perhitungan']['ipa']['bobot_criteria'] as $kuser => $peruser) {
			foreach ($peruser as $kcri => $bob) {
				if (!isset($bobot_criteria_dm[$kcri])) {
					$bobot_criteria_dm[$kcri]=0;
				}
				// $bobot_criteria_dm[$kcri]=$bobot_criteria_dm[$kcri]+($bob*$data_porsi[$kuser]/100);
				$bobot_criteria_dm[$kcri]=$bobot_criteria_dm[$kcri]+($bob*1/(sizeof($data_user)));
			}
		}

		$bobot_subcriteria_dm=[];
		if (!isset($view['perhitungan']['ipa']['bobot_subcriteria'])) {
			$view['perhitungan']['ipa']['bobot_subcriteria']=[];
		}
		foreach ($view['perhitungan']['ipa']['bobot_subcriteria'] as $kuser => $peruser) {
			foreach ($peruser as $kcri => $cri) {
				foreach ($cri as $ksubcri => $bob) {
					if (!isset($bobot_subcriteria_dm[$kcri][$ksubcri])) {
						$bobot_subcriteria_dm[$kcri][$ksubcri]=0;
					}
					// $bobot_subcriteria_dm[$kcri][$ksubcri]=$bobot_subcriteria_dm[$kcri][$ksubcri]+($bob*$data_porsi[$kuser]/100);
					$bobot_subcriteria_dm[$kcri][$ksubcri]=$bobot_subcriteria_dm[$kcri][$ksubcri]+($bob*1/(sizeof($data_user)));
				}
			}
		}
//============================		
		$ans_1=[];
		$ans_2=[];
		foreach ($data_responden as $key => $value) {
			$exp_answers_1=explode(',', $value['answers_1']);
			$exp_answers_2=explode(',', $value['answers_2']);
			
			foreach ($data_subcriteria as $key => $value1) {
				if(!isset($exp_answers_1[$key]) || !isset($exp_answers_2[$key]))
				{
					echo '<script type="text/javascript">'.
					'alert("Terjadi Kesalahan, Mohon periksa kembali data isian jawaban responden");'
					.'window.open("'.site_url('admin/responden').'","_self");'
					.'</script>';
					break 1;
				}
				$ans_1[$value['id_responden']][$value1['id_criteria_fk']][$value1['id_subcriteria']]=$exp_answers_1[$key];
				$ans_2[$value['id_responden']][$value1['id_criteria_fk']][$value1['id_subcriteria']]=$exp_answers_2[$key];
			}
		}
		$ans_1_jum_rata=[];
		$ans_2_jum_rata=[];
		$ans_1_rata_subcri_berbobot=[];
		$ans_2_rata_subcri_berbobot=[];
		foreach ($ans_1 as $key => $resp) {
			foreach ($resp as $kc => $cri) {
				foreach ($cri as $ksc => $sc) {
					if (!isset($ans_1_jum_rata[$kc][$ksc]['sum'])) {
						$ans_1_jum_rata[$kc][$ksc]['sum']=0;
					}	
					if (!isset($ans_1_jum_rata[$kc][$ksc]['avg'])) {
						$ans_1_jum_rata[$kc][$ksc]['avg']=0;
					}
					if (!isset($ans_1_jum_rata[$kc][$ksc]['berbobot'])) {
						$ans_1_jum_rata[$kc][$ksc]['berbobot']=0;
					}
					$ans_1_jum_rata[$kc][$ksc]['sum']+=$sc;
					$ans_1_jum_rata[$kc][$ksc]['avg']=$ans_1_jum_rata[$kc][$ksc]['sum']/sizeof($ans_1);
					$ans_1_jum_rata[$kc][$ksc]['berbobot']=$ans_1_jum_rata[$kc][$ksc]['avg']*$bobot_subcriteria_dm[$kc][$ksc];
				}
			}
		}
		
		foreach ($ans_1_jum_rata as $kc => $cri) {
			$sum=0;
			foreach ($cri as $ksc => $sc) {
				$sum=$sum+$sc['berbobot'];
			}
			$ans_1_rata_subcri_berbobot[$kc]=$sum/sizeof($cri);
		}
		foreach ($ans_2 as $key => $resp) {
			foreach ($resp as $kc => $cri) {
				foreach ($cri as $ksc => $sc) {
					if (!isset($ans_2_jum_rata[$kc][$ksc]['sum'])) {
						$ans_2_jum_rata[$kc][$ksc]['sum']=0;
					}	
					if (!isset($ans_2_jum_rata[$kc][$ksc]['avg'])) {
						$ans_2_jum_rata[$kc][$ksc]['avg']=0;
					}
					if (!isset($ans_2_jum_rata[$kc][$ksc]['berbobot'])) {
						$ans_2_jum_rata[$kc][$ksc]['berbobot']=0;
					}
					$ans_2_jum_rata[$kc][$ksc]['sum']+=$sc;
					$ans_2_jum_rata[$kc][$ksc]['avg']=$ans_2_jum_rata[$kc][$ksc]['sum']/sizeof($ans_2);
					$ans_2_jum_rata[$kc][$ksc]['berbobot']=$ans_2_jum_rata[$kc][$ksc]['avg']*$bobot_subcriteria_dm[$kc][$ksc];
				}
			}
		}
		foreach ($ans_2_jum_rata as $kc => $cri) {
			$sum=0;
			foreach ($cri as $ksc => $sc) {
				$sum=$sum+$sc['berbobot'];
			}
			$ans_2_rata_subcri_berbobot[$kc]=$sum/sizeof($cri);
		}
		$analisisipa=[];
		$analisisipa_total[1]=0;
		$analisisipa_total[2]=0;
		$analisisipa_total['kesesuaian']=0;
		foreach ($data_subcriteria as $key => $value) {
			if (!isset($analisisipa[$value['id_criteria_fk']][$value['id_subcriteria']])) {
				$analisisipa[$value['id_criteria_fk']][$value['id_subcriteria']][1]=0;
				$analisisipa[$value['id_criteria_fk']][$value['id_subcriteria']][2]=0;
			
			}
			if(!isset($ans_1_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot']) || !isset($ans_2_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot']))
			{
				$ans_1_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot']=0;
				$ans_2_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot']=0;
			}
			$analisisipa[$value['id_criteria_fk']][$value['id_subcriteria']][1]=$ans_1_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot'];
			$analisisipa[$value['id_criteria_fk']][$value['id_subcriteria']][2]=$ans_2_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot'];
			
			$analisisipa_total[1]=$analisisipa_total[1]+$ans_1_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot'];
			$analisisipa_total[2]=$analisisipa_total[2]+$ans_2_jum_rata[$value['id_criteria_fk']][$value['id_subcriteria']]['berbobot'];
			
		}
		$sumbu['x']=0;
		$sumbu['y']=0;

		if(sizeof($data_subcriteria))
		{
			$sumbu['x']=$analisisipa_total[1]/sizeof($data_subcriteria);
			$sumbu['y']=$analisisipa_total[2]/sizeof($data_subcriteria);

		}

				
		$kuadran=[];
		foreach ($analisisipa as $kc => $cri) {
			foreach ($cri as $ksc => $subc) {
				$kuadran[$kc][$ksc][1]=$subc[1];
				$kuadran[$kc][$ksc][2]=$subc[2];
				$posisi="";
				if(($kuadran[$kc][$ksc][1]<$sumbu['x']))
				{
					if($kuadran[$kc][$ksc][2]<$sumbu['y'])
					{
						$posisi ="3";
					}else
					{
						$posisi = "1";
					}
				}else
				{
					if($kuadran[$kc][$ksc][2]<$sumbu['y'])
					{
						$posisi ="4";
					}else
					{
						$posisi = "2";
					}
				}
				$kuadran[$kc][$ksc]['posisi']=$posisi;
				
			}
		}
		//perhitungan libqual
		$data_diskretisasi= $this->m_diskretisasi->getdiskretisasi([]);
		$data['diskretisasi']=$data_diskretisasi;
		$diskretisasi2=[];
		$batas_awal=1*10;
		foreach ($data_diskretisasi as $key => $value) {
			for ($i=$batas_awal; $i <= ($value['batas_akhir']*10); $i+=(0.5*10)) { 
				$diskretisasi2[$i]=$value;
			}
			$batas_awal=($value['batas_akhir']*10)+(0.5*10);
		}
		$data['diskretisasi2']=$diskretisasi2;
		$diskretisasi3=[];
		foreach ($data_diskretisasi as $key => $value) {
			$diskretisasi3[$value['id_diskretisasi']]=$value;
		}
		$data['diskretisasi3']=$diskretisasi3;
		
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
			if(array_sum($hitung2_sum))
			{
				$hitung2prosentase[$key]=$value/array_sum($hitung2_sum)*100;
			}else
			{
				$hitung2prosentase[$key]=0;
			}
			
		}
		// echo '<pre>';
		// print_r($hitung2prosentase);
		// break 1;
		$view['perhitungan']['ipa']['bobot_criteria_dm']= $bobot_criteria_dm;
		$view['perhitungan']['ipa']['bobot_subcriteria_dm']= $bobot_subcriteria_dm;
		$view['perhitungan']['ipa']['responden'][1]= $ans_1;
		$view['perhitungan']['ipa']['responden'][2]= $ans_2;
		$view['perhitungan']['ipa']['responden']['sum_jum_1']= $ans_1_jum_rata;
		$view['perhitungan']['ipa']['responden']['sum_jum_2']= $ans_2_jum_rata;
		$view['perhitungan']['ipa']['responden']['rata_subcri_berbobot_1']= $ans_1_rata_subcri_berbobot;
		$view['perhitungan']['ipa']['responden']['rata_subcri_berbobot_2']= $ans_2_rata_subcri_berbobot;
		$view['perhitungan']['libq']['bobot_criteria']= $view['perhitungan']['ipa']['bobot_criteria'];
		$view['perhitungan']['libq']['bobot_subcriteria']=$view['perhitungan']['ipa']['bobot_subcriteria'];
		$view['perhitungan']['libq']['bobot_criteria_dm']= $bobot_criteria_dm;
		$view['perhitungan']['libq']['bobot_subcriteria_dm']= $bobot_subcriteria_dm;
		$view['perhitungan']['libq']['responden']= $ans_1;
		$view['perhitungan']['libq']['responden_diskretisasi']= $jadidiskretisasi;
		$view['perhitungan']['libq']['olahdiskretisasi']= $olahdiskretisasi;
		$view['perhitungan']['libq']['hitung1']= $hitung1;
		$view['perhitungan']['libq']['hitung1_sum']= $hitung1_sum;
		$view['perhitungan']['libq']['hitung2']= $hitung2;
		$view['perhitungan']['libq']['hitung2_sum']= $hitung2_sum;
		$view['hasil']['ipa']['tingkatkesesuaian']= $analisisipa;
		$view['hasil']['ipa']['tingkatkesesuaian_total']= $analisisipa_total;
		$view['hasil']['ipa']['sumbu']= $sumbu;
		$view['hasil']['ipa']['kuadran']= $kuadran;
		$view['hasil']['libq']['prosentase']= $hitung2prosentase;
		// echo '<pre>';
		// print_r($ans_1_jum_rata);
		// print_r($ans_1_rata_subcri_berbobot);
		// print_r($ans_2_jum_rata);
		// print_r($ans_2_rata_subcri_berbobot);
		// print_r($analisisipa);
		// print_r($analisisipa_total);
		// print_r($sumbu);
		// print_r($kuadran);
		// print_r($view['perhitungan']['bobot']);
		// print_r($view['perhitungan']['bobot_dm']);
		// print_r($view['perhitungan']);
		// break 1;
		$data['view']=$view;
		$data['page']='Perhitungan';
		return $data;
	}

	public function pembobotangdss()
	{
		$data=[];
		$view['hasil']=null;
		$view['perhitungan']=null;
		$view['perhitungan']['bobot']=null;
		$parResp=[];
		$data_responden=$this->m_responden->getresponden($parResp);
		$parCri=[];
		$data_criteria = $this->m_criteria->getcriteria($parCri);
		$parSubCri=[];
		$data_subcriteria = $this->m_criteria->getsubcriteria($parSubCri);
		
		$paruser['role !='] = 1;
		$data_user= $this->m_user->getuser($paruser);
		// $data_porsi=[];
		$data_subcriteria2=[];
		foreach ($data_subcriteria as $key => $value) {
			$data_subcriteria2[$value['id_subcriteria']]=$value;
		}
		$data['subcriteria']=$data_subcriteria;
		$data['subcriteria2']=$data_subcriteria2;
		$data_criteria2=[];
		foreach ($data_criteria as $key => $value) {
			$data_criteria2[$value['id_criteria']]=$value;
		}
		$data['criteria']=$data_criteria2;
		$data_user2=[];
		foreach ($data_user as $key => $value) {
			$data_user2[$value['id_user']]=$value;
		}
		$data['user']=$data_user2;
		foreach ($data_user as $key => $valueuser) {
			// $data_porsi[$valueuser['id_user']]=$valueuser['porsi_bobot'];
			// if($valueuser['porsi_bobot']!="")
			// {
			if($valueuser['role']!=1)
			{
				$parbobot['id_user_fk']=$valueuser['id_user'];
				$data_bobot = $this->m_bobot->getbobot($parbobot);
				
				////atur bobot
				$bobot2=null;
				foreach ($data_bobot as $key => $value) {
					$bobot2[$value['type']][$value['id_target_1']][$value['id_target_2']][1]=(($value['lebihpenting'] == 1) ? $value['bobot'] : 1) ;
					$bobot2[$value['type']][$value['id_target_1']][$value['id_target_2']][2]=(($value['lebihpenting'] == 2) ? $value['bobot'] : 1) ;
					
				}
				// echo '<pre>';
				// print_r($bobot2);
				// break 1;
				$tbl_criteria=[];
				$tbl_subcriteria=[];
				foreach ($data_criteria as $i => $value1) {
					foreach ($data_criteria as $j => $value2) {
						$isi1=0;
						$isi2=0;
						if ($value1['id_criteria']==$value2['id_criteria']) {
							$isi1=1;
							$isi2=1;
						}
						else{
							if (isset($bobot2[1][$value1['id_criteria']][$value2['id_criteria']][1])) {
								$isi1=$bobot2[1][$value1['id_criteria']][$value2['id_criteria']][1];
								$isi2=$bobot2[1][$value1['id_criteria']][$value2['id_criteria']][2];
							}else
							{
								$isi1=$bobot2[1][$value2['id_criteria']][$value1['id_criteria']][2];
								$isi2=$bobot2[1][$value2['id_criteria']][$value1['id_criteria']][1];
							}
							
						}	
						$tbl_criteria[$value1['id_criteria']][$value2['id_criteria']][1]=$isi1;	
						$tbl_criteria[$value1['id_criteria']][$value2['id_criteria']][2]=$isi2;	
					}
					$tbl_subcriteria[$value1['id_criteria']]=[];
					$datasubberidcriteria=null;
					foreach ($data_subcriteria as $key => $valuesub) {
						if ($value1['id_criteria']==$valuesub['id_criteria_fk']) {
							$datasubberidcriteria[]=$valuesub;
							// echo $valuesub['id_subcriteria'].' masuk. count: '.sizeof($datasubberidcriteria).'<br>';
						}
						
					}
					foreach ($datasubberidcriteria as $key => $valu1) {
						foreach ($datasubberidcriteria as $key => $valu2) {
							$isi1=0;
							$isi2=0;
							if ($valu1['id_subcriteria']==$valu2['id_subcriteria']) {
								$isi1=1;
								$isi2=1;
							}
							else{
								if (isset($bobot2[2][$valu1['id_subcriteria']][$valu2['id_subcriteria']][1])) {
									$isi1=$bobot2[2][$valu1['id_subcriteria']][$valu2['id_subcriteria']][1];
									$isi2=$bobot2[2][$valu1['id_subcriteria']][$valu2['id_subcriteria']][2];
								}else
								{
									// echo $value2['id_criteria'].' - '.$value1['id_criteria'];
									$isi1=$bobot2[2][$valu2['id_subcriteria']][$valu1['id_subcriteria']][2];
									$isi2=$bobot2[2][$valu2['id_subcriteria']][$valu1['id_subcriteria']][1];
								}
								
							}	
							$tbl_subcriteria[$value1['id_criteria']][$valu1['id_subcriteria']][$valu2['id_subcriteria']][1]=$isi1;	
							$tbl_subcriteria[$value1['id_criteria']][$valu1['id_subcriteria']][$valu2['id_subcriteria']][2]=$isi2;	
						}
					}
				}
				
				$bobotcriteria=[];
				$criteria_sum=[];
				$criteria_perkalian=[];
				$nilai_akar_3=[];
				$sum_nilai_akar_3=0;
				$normalisasi=[];
				foreach ($tbl_criteria as $key => $value) {
					foreach ($value as $key1 => $va) {
						$nil=0;
						if(($va[1]=="") && ($va[2]==""))
						{
							$nil=0;
						}else
						{
							$nil=($va[1]/$va[2]);
						}
						if (isset($criteria_sum[$key1])) {
							$criteria_sum[$key1]=$criteria_sum[$key1]+$nil;
						}else
						{
							$criteria_sum[$key1]=$nil;
						}
						if (isset($criteria_perkalian[$key])) {
							$criteria_perkalian[$key]= $criteria_perkalian[$key]*$nil;
						}else
						{
							$criteria_perkalian[$key]=$nil;
						}
								
					}
				}
				
				foreach ($criteria_perkalian as $key => $value) {
					$nilai_akar_3[$key]=pow($value, (1/sizeof($tbl_criteria)));
					
				}
				$sum_nilai_akar_3=array_sum($nilai_akar_3);
				foreach ($nilai_akar_3 as $key => $value) {
					if($sum_nilai_akar_3)
					{
						$normalisasi[$key]=$value/$sum_nilai_akar_3;
					}else
					{
						$normalisasi[$key]=0;	
					}
					
					
				}
				$bobotcriteria=$normalisasi;
				$view['perhitungan']['ipa']['bobot_criteria'][$valueuser['id_user']]=$bobotcriteria;
				//menghitung bobot sub
				$bobotsubcriteria=[];
				foreach ($tbl_subcriteria as $kcri => $valpersub) {
					$criteria_sum=[];
					$criteria_perkalian=[];
					$nilai_akar_3=[];
					$sum_nilai_akar_3=0;
					$normalisasi=[];
					foreach ($valpersub as $key => $value) {
						foreach ($value as $key1 => $va) {
							$nil=0;
							if(($va[1]=="") && ($va[2]==""))
							{
								$nil=0;
							}else
							{
								$nil=($va[1]/$va[2]);
							}
							if (isset($criteria_sum[$key1])) {
								$criteria_sum[$key1]=$criteria_sum[$key1]+$nil;
							}else
							{
								$criteria_sum[$key1]=$nil;
							}
							if (isset($criteria_perkalian[$key])) {
								$criteria_perkalian[$key]= $criteria_perkalian[$key]*$nil;
							}else
							{
								$criteria_perkalian[$key]=$nil;
							}
							
						}
					}
					foreach ($criteria_perkalian as $key => $value) {
						$nilai_akar_3[$key]=pow($value, (1/sizeof($valpersub)));
						
					}
					$sum_nilai_akar_3=array_sum($nilai_akar_3);
					foreach ($nilai_akar_3 as $key => $value) {
						if($sum_nilai_akar_3)
						{
							$normalisasi[$key]=$value/$sum_nilai_akar_3;
						}else
						{
							$normalisasi[$key]=0;
						}
						
					}
					
					$bobotsubcriteria[$kcri]=$normalisasi;
				}
				// echo '<pre>';
				// print_r($bobotcriteria);
				// print_r($bobotsubcriteria);
				//menghitung DM
				$bobot_global=[];
				foreach ($bobotsubcriteria as $kcri => $vcri) {
					foreach ($vcri as $key => $value) {
						$bobot_global[$kcri][$key]=$value*$bobotcriteria[$kcri];
					}
				}
				// echo '<pre>';
				// print_r($bobot_dm);
				// break 1;
				$view['perhitungan']['ipa']['bobot_subcriteria'][$valueuser['id_user']]=$bobot_global;
			}
		}
		$bobot_criteria_dm=[];
		if (!isset($view['perhitungan']['ipa']['bobot_criteria'])) {
			$view['perhitungan']['ipa']['bobot_criteria']=[];
		}

		$peembagi=1;
		foreach ($view['perhitungan']['ipa']['bobot_criteria'] as $kuser => $peruser) {
			foreach ($peruser as $kcri => $bob) {
				if (!isset($bobot_criteria_dm[$kcri])) {
					$bobot_criteria_dm[$kcri]=0;
				}
				//$bobot_criteria_dm[$kcri]=$bobot_criteria_dm[$kcri]+($bob*$data_porsi[$kuser]/100);
				$bobot_criteria_dm[$kcri]=$bobot_criteria_dm[$kcri]+($bob*1/(sizeof($data_user)));
			}
		}
		$bobot_subcriteria_dm=[];
		if (!isset($view['perhitungan']['ipa']['bobot_subcriteria'])) {
			$view['perhitungan']['ipa']['bobot_subcriteria']=[];
		}
		foreach ($view['perhitungan']['ipa']['bobot_subcriteria'] as $kuser => $peruser) {
			foreach ($peruser as $kcri => $cri) {
				foreach ($cri as $ksubcri => $bob) {
					if (!isset($bobot_subcriteria_dm[$kcri][$ksubcri])) {
						$bobot_subcriteria_dm[$kcri][$ksubcri]=0;
					}
					//$bobot_subcriteria_dm[$kcri][$ksubcri]=$bobot_subcriteria_dm[$kcri][$ksubcri]+($bob*$data_porsi[$kuser]/100);
					$bobot_subcriteria_dm[$kcri][$ksubcri]=$bobot_subcriteria_dm[$kcri][$ksubcri]+($bob*1/(sizeof($data_user)));
				}
			}
		}
		// echo '<pre>';
		// print_r($view['perhitungan']['ipa']['bobot_criteria']);
		// print_r($view['perhitungan']['ipa']['bobot_subcriteria']);
		// print_r($bobot_criteria_dm);
		// print_r($bobot_subcriteria_dm);
		// break 1;
		$data['bobot_criteria']=$view['perhitungan']['ipa']['bobot_criteria'];
		$data['bobot_subcriteria']=$view['perhitungan']['ipa']['bobot_subcriteria'];
		$data['bobot_criteria_dm']=$bobot_criteria_dm;
		$data['bobot_subcriteria_dm']=$bobot_subcriteria_dm;
		$data['page']='Bobot Total GDSS-AHP';
		$this->load->view('admin/base_admin',$data);
	}
	public function pembobotan()
	{
		$data_subcriteria=$this->m_criteria->getsubcriteria([]);
		if(sizeof($data_subcriteria)==0	)
		{
			echo "<script>
		alert('Subcriteria masih kosong.');
		window.location.href='".site_url('admin')."';
		</script>";
			//redirect('admin');
		}
		
		$parCri=[];
		$data_criteria = $this->m_criteria->getcriteria($parCri);
		$parSubCri=[];
		$data_subcriteria = $this->m_criteria->getsubcriteria($parSubCri);
		$parbobot['id_user_fk']=$this->ses_id;
		$data_bobot = $this->m_bobot->getbobot($parbobot);
		$pardiskretisasi=[];
		$data_diskretisasi = $this->m_diskretisasi->getdiskretisasi($pardiskretisasi);
	
		////atur bobot
		$bobot2=null;
		foreach ($data_bobot as $key => $value) {
			$bobot2[$value['type']][$value['id_target_1']][$value['id_target_2']][1]=(($value['lebihpenting'] == 1) ? $value['bobot'] : 1) ;
			$bobot2[$value['type']][$value['id_target_1']][$value['id_target_2']][2]=(($value['lebihpenting'] == 2) ? $value['bobot'] : 1) ;
		}
		$view_criteria['list']=null;
		$view_criteria['table']=null;
		$view_criteria['form']=null;
		$view_subcriteria['list']=null;
		$view_subcriteria['table']=null;
		$view_subcriteria['form']=null;
		$view_pembobotan[1]=null;
		$view_pembobotan[2]=null;
		///view
		foreach ($data_criteria as $key => $value) {
			$view_criteria['list'][$value['id_criteria']]['id_criteria']=$value['id_criteria'];
			$view_criteria['list'][$value['id_criteria']]['criteria']=$value['criteria'];
		}
		foreach ($data_subcriteria as $key => $value) {
			$subcriteria_a['id_subcriteria'] = $value['id_subcriteria'];
			$subcriteria_a['subcriteria'] = $value['subcriteria'];
			$view_subcriteria['list'][$value['id_criteria_fk']][$value['id_subcriteria']] = $subcriteria_a;
		}
		////////tbl empty
		foreach ($data_criteria as $i => $value1) {
			foreach ($data_criteria as $j => $value2) {
				$isi="";
				if ($value1['id_criteria']==$value2['id_criteria']) {
					$isi=1;
				}	
				$view_criteria['table'][$value1['id_criteria']][$value2['id_criteria']][1]=$isi;	
				$view_criteria['table'][$value1['id_criteria']][$value2['id_criteria']][2]=$isi;	
			}
		}
		foreach ($view_subcriteria['list'] as $key => $value) {
			foreach ($data_subcriteria as $i => $value1) {
				foreach ($data_subcriteria as $j => $value2) {
					if (($value1['id_criteria_fk']==$key) && ($value2['id_criteria_fk']==$key)) {
						$isi="";
						if ($value1['id_subcriteria']==$value2['id_subcriteria']) {
							$isi=1;
						}	
						$view_subcriteria['table'][$key][$value1['id_subcriteria']][$value2['id_subcriteria']][1]=$isi;
						$view_subcriteria['table'][$key][$value1['id_subcriteria']][$value2['id_subcriteria']][2]=$isi;	
					}
				}
			}
		}
		///////fill tbl
		///criteria
		if (isset($bobot2[1])) {
			foreach ($bobot2[1] as $key1 => $value) {
				foreach ($value as $key2 => $bobo) {
					$view_criteria['table'][$key1][$key2][1]=$bobo[1];
					$view_criteria['table'][$key1][$key2][2]=$bobo[2];
					$view_criteria['table'][$key2][$key1][1]=$bobo[2];
					$view_criteria['table'][$key2][$key1][2]=$bobo[1];
				}
			}
		}
		if (isset($bobot2[2])) {
			foreach ($bobot2[2] as $key1 => $value) {
				foreach ($value as $key2 => $bobo) {
					
					foreach ($view_subcriteria['table'] as $key => $value) {
						if(isset($value[$key1][$key2][1]))
						{
							$view_subcriteria['table'][$key][$key1][$key2][1] = $bobo[1];
							$view_subcriteria['table'][$key][$key1][$key2][2] = $bobo[2];
							$view_subcriteria['table'][$key][$key2][$key1][1] = $bobo[2];
							$view_subcriteria['table'][$key][$key2][$key1][2] = $bobo[1];
						}
					}
				}
			}
		}
		
			
		//form
		///criteria
		foreach ($view_criteria['list'] as $key1 => $value1) {
			foreach ($view_criteria['list'] as $key2 => $value2) {
				if (!isset($view_criteria['form'][$value1['id_criteria']][$value2['id_criteria']]) 
					&& !isset($view_criteria['form'][$value2['id_criteria']][$value1['id_criteria']]) 
					&& ($value1['id_criteria']!=$value2['id_criteria'])) {
					
					$atasbawah[1]=$view_criteria['table'][$value1['id_criteria']][$value2['id_criteria']][1];
					$atasbawah[2]=$view_criteria['table'][$value1['id_criteria']][$value2['id_criteria']][2];
					$view_criteria['form'][$value1['id_criteria']][$value2['id_criteria']]['nilai']= ($atasbawah[2]==1) ? $atasbawah[1] : $atasbawah[2] ;
					$view_criteria['form'][$value1['id_criteria']][$value2['id_criteria']]['lebihpenting']= ($atasbawah[2]==1) ? 1 : 2 ;
					
				}
			}
		}
		///subcriteria
		foreach ($view_subcriteria['list'] as $key => $value) {
			foreach ($value as $key1 => $value1) {
				foreach ($view_subcriteria['list'][$key] as $key2 => $value2) {
					if (!isset($view_subcriteria['form'][$key][$value1['id_subcriteria']][$value2['id_subcriteria']]) 
						&& !isset($view_subcriteria['form'][$key][$value2['id_subcriteria']][$value1['id_subcriteria']]) 
						&& ($value1['id_subcriteria']!=$value2['id_subcriteria'])) {
						$atasbawah[1]=$view_subcriteria['table'][$key][$value1['id_subcriteria']][$value2['id_subcriteria']][1];
						$atasbawah[2]=$view_subcriteria['table'][$key][$value1['id_subcriteria']][$value2['id_subcriteria']][2];
						$view_subcriteria['form'][$key][$value1['id_subcriteria']][$value2['id_subcriteria']]['nilai']= ($atasbawah[2]==1) ? $atasbawah[1] : $atasbawah[2] ;
						$view_subcriteria['form'][$key][$value1['id_subcriteria']][$value2['id_subcriteria']]['lebihpenting']= ($atasbawah[2]==1) ? 1 : 2 ;
					}
				}
			}
		}
		
		$view_subcriteria_aturulang=[];
		foreach ($view_criteria['list'] as $key => $value) {
			if(isset($view_subcriteria['list'][$key]) && isset($view_subcriteria['table'][$key]) && isset($view_subcriteria['form'][$key]))
			{
				$view_subcriteria_aturulang[$key]['list']=$view_subcriteria['list'][$key];
				$view_subcriteria_aturulang[$key]['table']=$view_subcriteria['table'][$key];
				$view_subcriteria_aturulang[$key]['form']=$view_subcriteria['form'][$key];
			}else
			{
				$view_subcriteria_aturulang[$key]['list']=null;
				$view_subcriteria_aturulang[$key]['table']=null;
				$view_subcriteria_aturulang[$key]['form']=null;
			}
			
		}
		$validasi_criteria=null;
		$criteria_sum=null;
		$tbl_bobot_vector=null;
		$bobot_vector_bobot=null;
		$nilai_lambda=null;
		$ci=null;
		$cr=null;
		$konsistensi="";
		$criteria_perkalian=null;
		$nilai_akar_3=[];
		$sum_nilai_akar_3=0;
		$normalisasi=[];
		foreach ($view_criteria['table'] as $key => $value) {
			foreach ($value as $key1 => $va) {
				$nil=0;
				if(($va[1]=="") && ($va[2]==""))
				{
					$nil=0;
				}else
				{
					$nil=($va[1]/$va[2]);
				}
				if (isset($criteria_sum[$key1])) {
					$criteria_sum[$key1]=$criteria_sum[$key1]+$nil;
				}else
				{
					$criteria_sum[$key1]=$nil;
				}
				if (isset($criteria_perkalian[$key])) {
					$criteria_perkalian[$key]= $criteria_perkalian[$key]*$nil;
				}else
				{
					$criteria_perkalian[$key]=$nil;
				}
				
			}
		}
		foreach ($criteria_perkalian as $key => $value) {
			$nilai_akar_3[$key]=pow($value, (1/sizeof($data_criteria)));
			
		}
		$sum_nilai_akar_3=array_sum($nilai_akar_3);
		foreach ($nilai_akar_3 as $key => $value) {
			if($sum_nilai_akar_3)
			{
				$normalisasi[$key]=$value/$sum_nilai_akar_3;
			}else
			{
				$normalisasi[$key]=0;	
			}
			
		}
		$lambda_max=0;
		foreach ($normalisasi as $key => $value) {
			$lambda_max=$lambda_max+($value*$criteria_sum[$key]);
		}
		// foreach ($view_criteria['table'] as $key => $value) {
		// 	foreach ($value as $key1 => $va) {
		// 		$nil=0;
		// 		if(($va[1]=="") && ($va[2]==""))
		// 		{
		// 			$nil=0;
		// 		}else
		// 		{
		// 			$nil=($va[1]/$va[2])/$criteria_sum[$key1];
		// 		}
		// 		$tbl_bobot_vector[$key][$key1] = $nil;
		// 	}
		// }
		
		// foreach ($tbl_bobot_vector as $key => $value) {
		// 	foreach ($value as $key1 => $va) {
		// 		if (isset($bobot_vector_bobot[$key])) {
		// 			$bobot_vector_bobot[$key]=$bobot_vector_bobot[$key]+$va;
		// 		}else
		// 		{
		// 			$bobot_vector_bobot[$key]=$va;
		// 		}
		// 	}
		// }
		// foreach ($bobot_vector_bobot as $key => $value) {
		// 	$bobot_vector_bobot[$key]=$value/count($bobot_vector_bobot);
		// }
		// $lambda_max=0;
		// foreach ($bobot_vector_bobot as $key => $value) {
		// 	$nilai_lambda[$key]=$value*$criteria_sum[$key];
		// 	$lambda_max=$lambda_max+$nilai_lambda[$key];
		// }
		// $ci=($lambda_max-sizeof($bobot_vector_bobot))/(count($bobot_vector_bobot)-1);
		// $cr=$ci/$ri[count($bobot_vector_bobot)];
		$ci=($lambda_max-sizeof($normalisasi))/(sizeof($normalisasi)-1);
// Tabel RI
		$ri[1]=0;
		$ri[2]=0;
		$ri[3]=0.58;
		$ri[4]=0.9;
		$ri[5]=1.12;
		$ri[6]=1.24;
		$ri[7]=1.32;
		$ri[8]=1.41;
		$ri[9]=1.46;
		$ri[10]=1.49;
		
		$cr=$ci/$ri[sizeof($normalisasi)];
		$konsistensi=(($cr<=0.1) ? 'Telah Konsisten' : 'Tidak Konsisten');
		// echo '<pre>';
		// print_r($view_criteria['table']);
		// print_r($criteria_sum);
		// print_r($tbl_bobot_vector);
		// print_r($bobot_vector_bobot);
		// print_r($nilai_lambda);
		// echo '<br>lambda max: '.$lambda_max;
		// echo '<br>CI: '.$ci;
		// echo '<br>CR: '.$cr;
		// echo '<br>Konsistensi: '.$konsistensi;
		// break 1;
		$view_criteria['konsistensi']['lambda']=$lambda_max;
		$view_criteria['konsistensi']['ci']=$ci;
		$view_criteria['konsistensi']['cr']=$cr;
		$view_criteria['konsistensi']['konsisten']=$konsistensi;
		$data['view_pembobotan'][1] = $normalisasi;
		$tampung_bobot=[];
		foreach ($view_subcriteria_aturulang as $keyz => $valuez) {
			$validasi_criteria=null;
			$criteria_sum=null;
			$tbl_bobot_vector=null;
			$bobot_vector_bobot=null;
			$nilai_lambda=null;
			$ci=null;
			$cr=null;
			$konsistensi="";
			$criteria_perkalian=null;
			$nilai_akar_3=[];
			$sum_nilai_akar_3=0;
			$normalisasi=[];

			if (!isset($valuez['table'])) {
				$valuez['table']=[];
			}

			foreach ($valuez['table'] as $key => $value) {
				foreach ($value as $key1 => $va) {
					$nil=0;
					if(($va[1]=="") && ($va[2]==""))
					{
						$nil=0;
					}else
					{
						$nil=($va[1]/$va[2]);
					}
					if (isset($criteria_sum[$key1])) {
						$criteria_sum[$key1]=$criteria_sum[$key1]+$nil;
					}else
					{
						$criteria_sum[$key1]=$nil;
					}
					if (isset($criteria_perkalian[$key])) {
						$criteria_perkalian[$key]= $criteria_perkalian[$key]*$nil;
					}else
					{
						$criteria_perkalian[$key]=$nil;
					}
					
				}
			}
			if (!isset($criteria_perkalian)) {
				$criteria_perkalian=[];
			}
			foreach ($criteria_perkalian as $key => $value) {
				$nilai_akar_3[$key]=pow($value, (1/sizeof($valuez['table'])));
				
			}
			$sum_nilai_akar_3=array_sum($nilai_akar_3);
			foreach ($nilai_akar_3 as $key => $value) {
				if($sum_nilai_akar_3)
				{
					$normalisasi[$key]=$value/$sum_nilai_akar_3;
				}else
				{
					$normalisasi[$key]=0;
				}
				
				
			}
			$lambda_max=0;
			foreach ($normalisasi as $key => $value) {
				$lambda_max=$lambda_max+($value*$criteria_sum[$key]);
			}
			$ci=($lambda_max-sizeof($normalisasi))/(sizeof($normalisasi)-1);

			if (!isset($ri[sizeof($normalisasi)])) {
				$ri[sizeof($normalisasi)]=0;
			}

			if(!$ri[sizeof($normalisasi)])
			{
				$ri[sizeof($normalisasi)]=1;
			}
			$cr=$ci/$ri[sizeof($normalisasi)];
			$konsistensi=(($cr<=0.1) ? 'Telah Konsisten' : 'Tidak Konsisten');
			// echo '<pre>';
			// print_r($view_criteria['table']);
			// print_r($criteria_sum);
			// print_r($tbl_bobot_vector);
			// print_r($bobot_vector_bobot);
			// print_r($nilai_lambda);
			// echo '<br>lambda max: '.$lambda_max;
			// echo '<br>CI: '.$ci;
			// echo '<br>CR: '.$cr;
			// echo '<br>Konsistensi: '.$konsistensi;
			
			$view_subcriteria_aturulang[$keyz]['konsistensi']['lambda']=$lambda_max;
			$view_subcriteria_aturulang[$keyz]['konsistensi']['ci']=$ci;
			$view_subcriteria_aturulang[$keyz]['konsistensi']['cr']=$cr;
			$view_subcriteria_aturulang[$keyz]['konsistensi']['konsisten']=$konsistensi;
			$tampung_bobot[$keyz]=$normalisasi;
		}

		// echo '<pre>';
		// print_r($view_subcriteria_aturulang[1]['konsistensi']);
		// break 1;
		$data['page']='Pembobotan';
		// $data['criteriansub']=$data_criteriaAndSub;
		$data['criteria']=$data_criteria;
		$data['subcriteria']=$data_subcriteria;
		$data['diskretisasi']=$data_diskretisasi;
		$data['view_criteria'] = $view_criteria;
		$data['view_subcriteria'] = $view_subcriteria_aturulang;
		
		$data['view_pembobotan'][2] = $tampung_bobot;
		//echo '<pre>';
		//print_r($data['view_pembobotan']);
		//break 1;
		// ////////////////////////////////////////////////////////////////////
		// echo '<pre>';
		// // print_r($view_criteria);
		// print_r($view_subcriteria);
		// echo '<pre>';
		// print_r($data['view_pembobotan']);
		// break 1;
		$this->load->view('admin/base_admin',$data);
	}
	public function kriteriadansub()
	{
		$parCri=[];
		$data_criteria = $this->m_criteria->getcriteria($parCri);
		$parC=[];
		$data_criteriaAndSub = $this->m_criteria->getcriteria_subcriteria($parC);
		$data['page']='Kriteria dan Sub Kriteria';
		$data['criteriansub']=$data_criteriaAndSub;
		$data['criteria']=$data_criteria;
		$this->load->view('admin/base_admin',$data);
	}
	public function tambahuser()
	{
		// if($this->cekvalidasi_porsibobot($_POST['porsi_bobot']))
		// {
			if($this->m_user->tambahuser($_POST))
			{
				$this->session->set_flashdata('msg',"Tambah User successed.");
				redirect("admin/usermanagement");
			}
			else
			{
				$this->session->set_flashdata('error',"Tambah User failed.");
				redirect("admin/usermanagement");
			}
		// }else
		// {
		// 	$this->session->set_flashdata('error',"Total porsi bobot tidak boleh lebih dari 100");
		// 	redirect("admin/usermanagement");
		// }
		
	}
	public function tambahdiskretisasi()
	{
		if($this->m_diskretisasi->tambahdiskretisasi($_POST))
		{
			$this->session->set_flashdata('msg',"Tambah Diskretisasi successed.");
			redirect("admin/diskretisasi");
		}
		else
		{
			$this->session->set_flashdata('error',"Tambah Diskretisasi failed.");
			redirect("admin/diskretisasi");
		}	
	}
	public function tambahsubcriteria()
	{
		$parresponden=[];
		$data_responden = $this->m_responden->getresponden($parresponden);
		$data_subcriteria=$this->m_criteria->getsubcriteria([]);
		if((sizeof($data_subcriteria)<22) && (sizeof($data_responden)==0))
		{
			if($this->m_criteria->tambahsubcriteria($_POST))
			{
				$this->session->set_flashdata('msg',"Tambah Sub Criteria successed.");
				redirect("admin/kriteriadansub");
			}
			else
			{
				$this->session->set_flashdata('error',"Tambah Sub Criteria failed.");
				redirect("admin/kriteriadansub");
			}	
		}else
		{
			$this->session->set_flashdata('error',"Tidak bisa mengubah data subcriteria.");
			redirect("admin/kriteriadansub");
		}
		
	}
	public function ubahuser($id_user)
	{
		$paruser['id_user']=$id_user;
		$data_user= $this->m_user->getuser($paruser);
		// echo (($_POST['porsi_bobot'])-$data_user[0]['porsi_bobot']);
		// break 1;
		if($this->cekvalidasi_porsibobot($_POST['porsi_bobot']-$data_user[0]['porsi_bobot']))
		{
			if($this->m_user->ubahuser($id_user,$_POST))
			{
				$this->session->set_flashdata('msg',"Edit User successed.");
				redirect("admin/usermanagement");
			}
			else
			{
				$this->session->set_flashdata('error',"Edit User failed.");
				redirect("admin/usermanagement");
			}
		}else
		{
			$this->session->set_flashdata('error',"Total porsi bobot tidak boleh lebih dari 100");
			redirect("admin/usermanagement");
		}
	}
	public function ubahsubcriteria($id_subcriteria)
	{
		$parresponden=[];
		$data_responden = $this->m_responden->getresponden($parresponden);
		if((sizeof($data_responden)==0))
		{
			if($this->m_criteria->ubahsubcriteria($id_subcriteria,$_POST))
			{
				$this->session->set_flashdata('msg',"Edit Sub Criteria successed.");
				redirect("admin/kriteriadansub");
			}
			else
			{
				$this->session->set_flashdata('error',"Edit Sub Criteria failed.");
				redirect("admin/kriteriadansub");
			}
		}
		else
		{
			$this->session->set_flashdata('error',"Tidak bisa mengubah data subcriteria.");
			redirect("admin/kriteriadansub");
		}
		
	}
	public function hapususer($id_user)
	{
		$par['id_user']=$id_user;
		if($this->m_user->hapususer($par))
		{
			$this->session->set_flashdata('msg',"Remove User successed.");
			redirect("admin/usermanagement");
		}
		else
		{
			$this->session->set_flashdata('error',"Remove User failed.");
			redirect("admin/usermanagement");
		}
	}
	public function hapusresponden($id_responden)
	{
		// echo 'asdads';
		// break 1;
		// $par['id_responden']=$id_responden;
		if($this->m_responden->hapusresponden_transc($id_responden))
		{
			$this->session->set_flashdata('msg',"Remove Responden successed.");
			redirect("admin/responden");
		}
		else
		{
			$this->session->set_flashdata('error',"Remove Responden failed.");
			redirect("admin/responden");
		}
	}
	public function hapusdiskretisasi($id_diskretisasi)
	{
		$par['id_diskretisasi']=$id_diskretisasi;
		if($this->m_diskretisasi->hapusdiskretisasi($par))
		{
			$this->session->set_flashdata('msg',"Hapus Diskretisasi successed.");
			redirect("admin/diskretisasi");
		}
		else
		{
			$this->session->set_flashdata('error',"Hapus Diskretisasi failed.");
			redirect("admin/diskretisasi");
		}	
	}
	//dirubah yoo
	public function cekvalidasi_porsibobot($bobotbaru)
	{
		$sumdatauser=0;
		$datauser=$this->m_user->getuser([]);
		$datauserselected=$this->m_user->getuser($paruserselected);
		foreach ($datauser as $key => $value) {
			$sumdatauser=$sumdatauser+$value['porsi_bobot'];
		}
		if(($sumdatauser+$bobotbaru)<=100)
		{
			return 1;
		}else
		{
			return 0;
		}
	}
	public function hapussubcriteria($id_subcriteria)
	{
		$parresponden=[];
		$data_responden = $this->m_responden->getresponden($parresponden);
		if((sizeof($data_responden)==0))
		{
			$par['id_subcriteria']=$id_subcriteria;
			if($this->m_criteria->hapussubcriteria($par))
			{
				$this->session->set_flashdata('msg',"Remove Sub Criteria successed.");
				redirect("admin/kriteriadansub");
			}
			else
			{
				$this->session->set_flashdata('error',"Remove Sub Criteria failed.");
				redirect("admin/kriteriadansub");
			}
		}
		else
		{
			$this->session->set_flashdata('error',"Tidak bisa mengubah data subcriteria.");
			redirect("admin/kriteriadansub");
		}
		
	}
	public function submitbobot($type,$id_kriteria)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		// break 1;
		$bobots=$_POST;
		$id_user=$this->ses_id;
		if($this->m_bobot->ubahbobot_transc($bobots, $id_user, $type))
		{
			$this->session->set_flashdata('msg',"Remove Edit Bobot Kriteria successed.");
			$this->session->set_flashdata('tab',$id_kriteria);
			redirect("admin/pembobotan");
		}
		else
		{
			$this->session->set_flashdata('error',"Remove Edit Bobot Kriteria failed.");
			redirect("admin/pembobotan");
		}
	}

	public function tonewtable()
	{
		$data_responden=$this->m_responden->getresponden([]);
		foreach ($data_responden as $key => $value) {
			
			$jawaban1_exp=explode(',', $value['answers_1']);
			$jawaban2_exp=explode(',', $value['answers_2']);
			foreach ($jawaban1_exp as $key2 => $value2) {
				$par_jawaban['id_responden_fk']=$value['id_responden'];
				$par_jawaban['id_subcriteria_fk']=$key2+1;
				$par_jawaban['tipe']=1;
				$par_jawaban['jawaban']=$value2;
				$this->m_jawaban->tambahjawaban($par_jawaban);
			}
			foreach ($jawaban2_exp as $key2 => $value2) {
				$par_jawaban['id_responden_fk']=$value['id_responden'];
				$par_jawaban['id_subcriteria_fk']=$key2+1;
				$par_jawaban['tipe']=2;
				$par_jawaban['jawaban']=$value2;
				$this->m_jawaban->tambahjawaban($par_jawaban);
			}
		}
	}
}