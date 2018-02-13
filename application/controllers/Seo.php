<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/libraries/SeoReport.php';


class Seo extends BaseController
{
	function __construct(){
		parent::__construct();
		$this->isLoggedIn ();
	}
	
	function generateSeoReport($url = NULL){
		
		if(!empty($url) || $url !== NULL){
			$seoReport = new SeoReport(htmlentities(str_replace("-","/",$url)));
			$seoReport->getSeoReport();
		}
	}
	
	function formatCheckLinks(){
		$url = "www.google.com";
		$seoReport = new SeoReport($url);
		$seoReport->getSeoReport();
	}
	
	
}