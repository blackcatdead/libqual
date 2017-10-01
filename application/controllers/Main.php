<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		
		parent::__construct();
		$this->load->model('m_responden','',TRUE);
		$this->load->model('m_criteria','',TRUE);

	   	if($this->session->userdata('logged_in'))
	   	{
	   		$session_data = $this->session->userdata('logged_in');
   			$this->ses_id = $session_data['id'];
   			$this->ses_nama = $session_data['nama'];
   			$this->ses_email = $session_data['email'];
   			$this->ses_no = $session_data['no'];
   			$this->ses_status = $session_data['status'];
		}else
		{
			redirect('starter', 'refresh');
		}
	}

	public function index()
	{	

		// $sess_array = array(
  //   		'id' => $this->ses_id,
  //   		'nama' => $this->ses_nama,
  //   		'email' => $this->ses_email,
  //   		'no' => $this->ses_no,
  //   		'status' => 1
  //  		);
  //   	$this->session->set_userdata('logged_in', $sess_array);
  //   	echo $this->ses_status;
		// break 1;
		if ($this->ses_status==1) {
			redirect("main/petunjuk");
		}else if($this->ses_status!=4)
		{
			redirect("main/kuesioner");
		}else
		{
			redirect("main/selesai");
		}	
	}

	public function petunjuk()
	{
		$data['page']='Petunjuk';

		$this->load->view('main/base_main',$data);
	}

	public function selesai()
	{
		$data['page']='Selesai';

		$this->load->view('main/base_main',$data);
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in');
	   	session_destroy();
		redirect('', 'refresh');
	}

	public function logoutdanhapus()
	{
		$par['id_responden']=$this->ses_id;
		if ($this->m_responden->hapusresponden($par)) {
			$this->session->unset_userdata('logged_in');
	   		session_destroy();
		}
		redirect('', 'refresh');
		
	}

	public function kuesioner()
	{
		if($this->ses_status == 4)
		{
			redirect("/");
		}else
		{
			$parresponden['id_responden']=$this->ses_id;
			$data_responden=$this->m_responden->getresponden($parresponden);

			// print_r($data_responden);
			// break 1;

			$data['page']='Kuesioner';
			
			//redirect("/");

			$parc['id_criteria']=$this->ses_status;
			$data_criteria= $this->m_criteria->getcriteria($parc);

			$parcriteria['id_criteria_fk']=$this->ses_status;
			$data['q']=$this->m_criteria->getcriteria_subcriteria($parcriteria);
			$data['criteria']=$data_criteria;
			// echo '<pre>';
			// print_r($data['q']);
			// break 1;
			$this->load->view('main/base_main',$data);
		}
		
	}

	public function submitkuesioner($tipe_q)
	{
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';
		// break 1;

		//validasi
		$validasi = true;
		foreach ($_POST['persepsi'] as $key => $value) {
			if ($value <1 ) {
				$validasi = false;
			}
		}
		foreach ($_POST['kepentingan'] as $key => $value) {
			if ($value <1 ) {
				$validasi = false;
			}
		}

		if ($validasi) {
			$parresponden['id_responden']=$this->ses_id;
			$data_responden=$this->m_responden->getresponden($parresponden);

			$parresponden['answers_1']=$data_responden[0]['answers_1'];
			$parresponden['answers_2']=$data_responden[0]['answers_2'];
			$parresponden['responden_status']=$tipe_q+1;
			foreach ($_POST['persepsi'] as $key => $value) {
				$parresponden['answers_1']=$parresponden['answers_1'].$value.',';
			}
			foreach ($_POST['kepentingan'] as $key => $value) {
				$parresponden['answers_2']=$parresponden['answers_2'].$value.',';
			}
			// echo '<pre>';
			// print_r($parresponden);
			// echo '</pre>';
			// break 1;

			if ($this->m_responden->ubahresponden($this->ses_id,$parresponden)) {
				$sess_array = array(
		    		'id' => $this->ses_id,
		    		'nama' => $this->ses_nama,
		    		'email' => $this->ses_email,
		    		'no' => $this->ses_no,
		    		'status' => $tipe_q+1
		   		);
		    	$this->session->set_userdata('logged_in', $sess_array);
				redirect('main/kuesioner');
	 		}else
			{
				$this->session->set_flashdata('error',"Gagal menyimpan.");
				redirect("main/kuesioner");
			}
		}else
		{
			$this->session->set_flashdata('error',"Mohon isikan semua jawaban Anda berdasarkan Persepsi dan Ekspektasi atas semua item pernyataan.");
			redirect("main/kuesioner");
		}


	}
}