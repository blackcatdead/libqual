<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginadmin extends CI_Controller {

	public function index()
	{
		$this->load->view('admin/login_admin');
	}

}
