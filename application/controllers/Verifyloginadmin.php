<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifyloginadmin extends CI_Controller {

 	function __construct()
 	{
   		parent::__construct();
   		$this->load->model('m_user','',TRUE);
 	}

 	function logingin()
 	{

   		//Field validation succeeded.  Validate against database
   		$username = $this->input->post('username');
   		$password = $this->input->post('password');

   		$user= $this->m_user->login($username,$password);
   		if($user)
   		{
     		$sess_array = array(
        		'id' => $user[0]['id_user'],
        		'username' => $user[0]['username'],
        		'name' => $user[0]['nama'],
            'role' => $user[0]['role']
       		);
        	$this->session->unset_userdata('logged_in_admin');
        	$this->session->set_userdata('logged_in_admin', $sess_array);

        	redirect("admin");
	    	return TRUE;
	   	}
	   	else
	   	{
	    	$this->session->set_flashdata('error',"Invalid username or password.");
	    	redirect("loginadmin");
	    	//$this->form_validation->set_message('check_database', 'Invalid username or password');
	    	return false;
	  	}
	}
}
?>