<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Starter extends CI_Controller {

	public function index()
	{
		$this->load->view('main/main_starter');
	}

}
