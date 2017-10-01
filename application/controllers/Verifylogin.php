<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifylogin extends CI_Controller {

 	function __construct()
 	{
   		parent::__construct();
   		$this->load->model('m_responden','',TRUE);
   		$this->load->model('m_criteria','',TRUE);
 	}

 	function starting()
 	{

 		$parSubCri=[];
		$data_subcriteria = $this->m_criteria->getsubcriteria($parSubCri);

		if(sizeof($data_subcriteria))
		{
			$_POST['responden_status']=1;

	 		$ins_responden = $this->m_responden->tambahresponden($_POST);
	 		if ($ins_responden) {
	 			$sess_array = array();
		     	
	       		$sess_array = array(
	        		'id' => $ins_responden,
	        		'nama' => $_POST['nama'],
	        		'email' => $_POST['email'],
	        		'no' => $_POST['no_anggota'],
	        		'status' => $_POST['responden_status']
	       		);
		    	
	        	$this->session->unset_userdata('logged_in');
	        	$this->session->set_userdata('logged_in', $sess_array);
	 			redirect("main");
	 		}else
			{
				$this->session->set_flashdata('error',"Registrasi tidak berhasil. Silahkan coba lagi.");
				redirect("starter");
			}
		}else
		{
			$this->session->set_flashdata('error',"Criteria masih kosong. Silakan hubungi admin.");
			redirect("starter");
		}
 		//print_r($_POST);
 		
   		//Field validation succeeded.  Validate against database
   	// 	$email = $this->input->post('email');
   	// 	$password = $this->input->post('password');

   	// 	//query the database
   	// 	$result = $this->m_responden->login($email, $password);

   	// 	if($result)
   	// 	{
   	// 		$start_timer=null;
    //  		$sess_array = array();
	   //   	foreach($result as $row)
	   //   	{
	   //     		$sess_array = array(
	   //      		'id' => $row['id_responden'],
	   //      		'group' => $row['group']
	   //     		);
	   //     		$start_timer=  $row['start_timer'];
	   //  	}
    //     	$this->session->unset_userdata('logged_in_reac');
    //     	$this->session->set_userdata('logged_in_reac', $sess_array);

    //     	$this->m_responden->starttimeriffirst($sess_array['id'], $start_timer);
    //     	redirect("");
	   //  	return TRUE;
	   // 	}
	   // 	else
	   // 	{
	   //  	$this->session->set_flashdata('error',"Invalid email or password.");
	   //  	redirect("login");
	   //  	//$this->form_validation->set_message('check_database', 'Invalid username or password');
	   //  	return false;
	  	// }
	}
}
?>