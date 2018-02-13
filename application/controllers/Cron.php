<?php
require APPPATH . '/third_party/vendor/autoload.php';

/**
 * Class : Cron
 * @filesource : Cron.php
 * @author Kishor Mali
 * @access : Access to command line request only
 * @todo : Access restrict for non-cli requests
 *
 * This class is used to handle the command line to database
 */
class Cron extends CI_Controller {
	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'cron_model' );
	}
	
	/**
	 * This function used to refresh all the domain images using cron
	 */
	function siteDemo() {
		set_time_limit ( 0 );
		
		$Bw = 1366;
		$Bh = 768;
		$Mw = 320;
		$Mh = 480;
		
		$page = 100;
		$segment = 0;
		
		$count = $this->cron_model->getDomainCount ();
		
		if (! empty ( $count )) {
			$totCount = $count [0]->count;
			
			while ( $totCount > 0 ) {
				$domains = $this->cron_model->getDomains ( $page, $segment );
				if (! empty ( $domains )) {
					foreach ( $domains as $do ) {
						$data = array (
								"scr_img_desk" => base64_encode ( $do->domain_name ) . ".jpg",
								"scr_img_mobile" => base64_encode ( $do->domain_name ) . ".jpg",
								"scr_dtm" => date ( "Y-m-d H:i:s" ),
								"updated_by" => 1,
								"updated_dtm" => date ( "Y-m-d H:i:s" ) 
						);
						$this->cron_model->mapSiteImage ( $data, $do->cust_id );
						$this->screenDemo ( $do->domain_name, $Mw, $Mh, MOBILE_UA, CAPTURE_MOBILE );
						$this->screenDemo ( $do->domain_name, $Bw, $Bh, BROWSER_UA, CAPTURE_BROWSER );
					}
				}
				
				$segment = $segment + $page;
				$totCount = $totCount - $page;
				
				pre ( "slow down for 1 minute" );
				sleep ( 60 );
			}
		}
	}
	
	/**
	 * This function used to capture Actual Image of website
	 * @param string $url : This is domain url
	 * @param number $w : This is image width
	 * @param number $h : This is image height
	 * @param string $user_agent : This is browser user agent
	 * @param number $type : This is device type - MOBILE or BROWSER
	 */
	function screenDemo($url, $w, $h, $user_agent, $type) {
		set_time_limit ( 0 );
		
		$screen = new Screen\Capture ( $url );
		$screen->setWidth ( intval ( $w ) );
		$screen->setHeight ( intval ( $h ) );
		$screen->setUserAgentString ( $user_agent );
		
		$filename = base64_encode ( $url ) . ".jpg";
		$fileLocation = WEBSITE_CAPTURE . MOBILE . $filename;
		
		if ($type == CAPTURE_BROWSER) {
			$fileLocation = WEBSITE_CAPTURE . BROWSER . $filename;
		}
		
		$screen->save ( $fileLocation );
	}
	
	/**
	 * This function called by cron job after some time interval
	 */
	function siteOffsetScreenGrab() {
		
		set_time_limit ( 0 );
		
		$Bw = 1366;
		$Bh = 768;
		$Mw = 320;
		$Mh = 480;
		
		$page = 5;
		$segment = 0;
		
		$count = $this->cron_model->getDomainCount();
		
		$offsetCount = $this->cron_model->getOffsetCount();
		
		if (! empty ( $count )) {
			$totCount = $count [0]->count;
			if(!empty($offsetCount)){
				$segment = $offsetCount[0]->fb_ofcount;
			}
			
			$domains = $this->cron_model->getDomains ( $page, $segment );
			
			$segment = $segment + $page;
				
			$offsetData = array("fb_ofcount"=>$segment, "fb_totcount"=>$totCount, "updated_dtm"=>date("Y-m-d H:i:s"));
				
			if($segment == $totCount){
				$offsetData["is_deleted"] = 1;
				$this->cron_model->udpateNewOffset($offsetData);
				$newOffsetData = array("fb_ofcount"=>0, "fb_totcount"=>$totCount, "created_dtm"=>date("Y-m-d H:i:s"));
				$this->cron_model->createNewOffset($newOffsetData);
			}
			else{
				$this->cron_model->udpateNewOffset($offsetData);
			}
			
			if (! empty ( $domains )) {
				foreach ( $domains as $do ) {
					
					$data = array (
							"scr_img_desk" => base64_encode ( $do->domain_name ) . ".jpg",
							"scr_img_mobile" => base64_encode ( $do->domain_name ) . ".jpg",
							"scr_dtm" => date ( "Y-m-d H:i:s" ),
							"updated_by" => 1,
							"updated_dtm" => date ( "Y-m-d H:i:s" )
					);
					
					$this->screenDemo ( $do->domain_name, $Mw, $Mh, MOBILE_UA, CAPTURE_MOBILE );
					$this->screenDemo ( $do->domain_name, $Bw, $Bh, BROWSER_UA, CAPTURE_BROWSER );
					
					$this->cron_model->mapSiteImage ( $data, $do->cust_id );
				}
			}			
			
		}
	}
}
