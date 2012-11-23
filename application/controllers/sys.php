<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys extends CI_Controller {

	/**
	* Developer : Vic Omar TM
	* @v_omar
	*/

	public function index()
	{
		$data['css'] = $this->vic->css();
		$data['js'] = $this->vic->js();
		$this->load->view('html/head.php',$data);
		$this->load->view('html/menu.php');
		$this->load->view('html/foot.php');
	}
}

/* End of file Sys.php */
/* Location: ./application/controllers/Sys.php */
