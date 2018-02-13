<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

require APPPATH . '/libraries/BaseController.php';


class Caching extends BaseController {
	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct ();
		$this->isLoggedIn ();
	}
	
	function index(){
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			
			$this->global ['pageTitle'] = 'CodeInsect : Cache Management';
			$this->load->view("includes/header", $this->global);
			$this->load->view("caching");
			$this->load->view("includes/footer");
		}
	}
	
	function deleteCache(){
		$path = $this->input->post("path");
		$this->output->clear_path_cache($path);
		echo(json_encode(array("status"=>"success")));
	}
	
	function deleteAllCache(){
		$this->output->clear_all_cache();
		echo(json_encode(array("status"=>"success")));
	}
}