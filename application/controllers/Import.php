<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/third_party/vendor/autoload.php';
require APPPATH . '/libraries/mypdf.php';

use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;

ini_set('session.cache_limiter','public');
session_cache_limiter(false);

/**
 * Class : Import
 * @filesource : Import.php
 * @author Kishor Mali
 * @access public
 * 
 * This class is used to do miscellaneous operations like listing, importing files,
 * extracting data from files etc.
 */
class Import extends BaseController {
	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct ();
		$this->load->library ( 'user_agent' );
		$this->load->model ( 'import_model' );
		$this->isLoggedIn ();
	}
	
	/**
	 * This function used to load the default view
	 */
	function index() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$noOfRecords = $this->input->post ( "noOfRecords" ) == "" ? 10 : $this->input->post ( "noOfRecords" );
			$searchText = $this->input->post ( 'searchText' );
			$country = $this->input->post ( "country" );
			$data ['noOfRecords'] = $noOfRecords;
			$data ['searchText'] = $searchText;
			$data ["country"] = $country;
			
			$count = $this->import_model->importListingCount ( $searchText, $country );
			
			$returns = $this->paginationCompress ( "import/", $count, $noOfRecords );
			
			$data ['rawRecords'] = $this->import_model->importListing ( $searchText, $country, $returns["page"], $returns["segment"] );
			
			$data ['countries'] = $this->import_model->getDistictCountries ();
			
			$this->global ['pageTitle'] = 'Feedbacker : Imported Data';
			$this->loadViews("importedData", $this->global, $data, NULL);
		}
	}
	
	/**
	 * This function used to load the import excel view
	 */
	function importExcel() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$this->global ['pageTitle'] = 'Feedbacker : Import Raw Data';
			$this->loadViews("importing", $this->global, NULL, NULL);
		}
	}
	
	/**
	 * This function used to upload raw excel
	 * @return boolean $result : upload raw excel
	 */
	function uploadRawExcel() {
		set_time_limit ( 0 );
		$this->load->library ( "form_validation" );
		
		if (isset ( $_FILES ['impfile'] ) && ! empty ( $_FILES ['impfile'] ['name'] )) {
			$config = array (
					'upload_path' => './' . EXCEL_FILE,
					'allowed_types' => 'xls|xlsx',
					'max_size' => 204800,
					'encrypt_name' => true 
			);
			
			$this->load->library ( 'upload', $config );
			
			if (! $this->upload->do_upload ( 'impfile' )) {
				$this->form_validation->set_message ( 'impfile', $this->upload->display_errors () );
			} else {
				$upload_data = $this->upload->data ();
				
				$photo_path = $upload_data ['file_name'];
				$_POST ['impfile'] = $photo_path;
				if ($photo_path) {
					return array (
							"status" => true,
							"file_name" => $photo_path 
					);
				} else {
					$_POST ['impfile'] = '';
					$this->form_validation->set_message ( 'impfile', $this->upload->display_errors () );
					return array (
							"status" => false,
							"file_name" => "" 
					);
				}
			}
		}
	}
		
	/**
	 * This function used to upload raw data to database
	 */
	function uploadRawData() {
		set_time_limit ( 0 );
		
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$result = $this->uploadRawExcel ();
			
			if (! empty ( $result ) && $result ["status"] == true) {
				
				$importRes = $this->importUsingParser ( $result ["file_name"] );
				
				$this->session->set_flashdata ( 'success', 'Data imported successfully' );
				if ($importRes != false) {
					$this->session->set_flashdata ( 'file_path', $importRes );
				}
			} else {
				$this->session->set_flashdata ( 'error', 'Data import failed' );
			}
			
			redirect ( 'importExcel' );
		}
	}
	
	/**
	 * This function used to get records using excel parser
	 * @param string $file_name : This is file name 
	 * @return string $result : This is file path
	 */
	function importUsingParser($file_name) {
		set_time_limit ( 0 );
		$error_file_path = "";
		$file_path = "./" . EXCEL_FILE . $file_name;
		$errRecords = array ();
		$successRecords = array ();
		$date = date ( 'Y-m-d' );
		
		$workbook = SpreadsheetParser::open ( $file_path );
		
		$myWorksheetIndex = $workbook->getWorksheetIndex ( 'sheet1' );
		
		foreach ( $workbook->createRowIterator ( $myWorksheetIndex ) as $rowIndex => $domains ) {
			if ($rowIndex > 1) {
				$isExists = $this->import_model->checkDomainExists ( $domains [0] );

				if (empty ( $isExists )) {
					$push_records = array (
							"domain_name" => $domains [0],
							"domain_registrar_name" => $domains [1],
							"create_date"=> null,
							"expiry_date"=> null,
							"registrant_name" => null,
							"registrant_company" => null,
							"registrant_address" => null,
							"registrant_city" => null,
							"registrant_state" => null,
							"registrant_zip" => null,
							"registrant_country" => null,
							"registrant_email" => null,
							"registrant_phone" => null,
							"registrant_fax" => null,
							"created_by" => $this->vendorId,
							"created_dtm" => date ( 'Y-m-d H:i:s' ) 
					);
					
					if (gettype ( $domains [2] ) == "object") {
						$push_records ["create_date"] = $domains [2]->format ( 'Y-m-d H:i:s' );
					} else {
						$push_records ["create_date"] = date ( "Y-m-d H:i:s", strtotime ( $domains [2] ) );
					}
					
					if (gettype ( $domains [3] ) == "object") {
						$push_records ["expiry_date"] = $domains [3]->format ( 'Y-m-d H:i:s' );
					} else {
						$push_records ["expiry_date"] = date ( "Y-m-d H:i:s", strtotime ( $domains [3] ) );
					}

					if (isset ( $domains [4] )) {
						if (gettype ( $domains [4] ) == "object") {
							$push_records ["registrant_name"] = $domains [4]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_name"] = $domains [4];
						}
					}
					
					if (isset ( $domains [5] )) {
						if (gettype ( $domains [5] ) == "object") {
							$push_records ["registrant_company"] = $domains [5]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_company"] = $domains [5];
						}
					}
					
					if (isset ( $domains [6] )) {
						if (gettype ( $domains [6] ) == "object") {
							$push_records ["registrant_address"] = $domains [6]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_address"] = $domains [6];
						}
					}
					
					if (isset ( $domains [7] )) {
						if (gettype ( $domains [7] ) == "object") {
							$push_records ["registrant_city"] = $domains [7]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_city"] = $domains [7];
						}
					}
					
					if (isset ( $domains [8] )) {
						if (gettype ( $domains [8] ) == "object") {
							$push_records ["registrant_state"] = $domains [8]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_state"] = $domains [8];
						}
					}
					if (isset ( $domains [9] )) {
						if (gettype ( $domains [9] ) == "object") {
							$push_records ["registrant_zip"] = $domains [9]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_zip"] = $domains [9];
						}
					}
					
					if (isset ( $domains [10] )) {
						if (gettype ( $domains [10] ) == "object") {
							$push_records ["registrant_country"] = $domains [10]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_country"] = $domains [10];
						}
					}
					
					if (isset ( $domains [11] )) {
						if (gettype ( $domains [11] ) == "object") {
							$push_records ["registrant_email"] = $domains [11]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_email"] = $domains [11];
						}
					}
					
					if (isset ( $domains [12] )) {
						if (gettype ( $domains [12] ) == "object") {
							$push_records ["registrant_phone"] = $domains [12]->format ( 'Y-m-d H:i:s' );
						} else {
							$push_records ["registrant_phone"] = $domains [12];
						}
					}
										
					array_push ( $successRecords, $push_records );

					if (count ( $successRecords ) >= 2000) {
						$this->import_model->pushSuccessRecords ( $successRecords );
						
						$successRecords = array ();
					}
				} else {
					// array_push($errRecords, $domains);
				}
			}
		}
		
		if (! empty ( $successRecords )) {
			$this->import_model->pushSuccessRecords ( $successRecords );
		}

		if (! empty ( $errRecords )) {
			// $error_file_path = $this->createErrorRecords($errRecords);
		}
		
		if ($error_file_path != "") {
			return $error_file_path;
		}
	}
	
	/**
	 * This function used to get list of unassigned customers
	 */
	function unassignCustomers() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$data ["page"] = $this->input->post ( "page" ) == "" ? 20 : $this->input->post ( "page" );
			$data ["country"] = $this->input->post ( "country" );
			$data ["searchText"] = $this->input->post ( "searchText" );
			
			$countData = $this->import_model->assignListingCount ( $data ["searchText"], $data ["country"]);
			
			$returns = $this->paginationCompress("unassignCustomers", $countData[0]->count, $data ["page"]);

			$data ['rawRecords'] = $this->import_model->assignListing ( $data ["searchText"], $data ["country"], $returns ["page"], $returns ["segment"] );
			
			$data ['executives'] = $this->import_model->getExecutives ();
			$data ['countries'] = $this->import_model->getDistictCountries ();

			$this->global ['pageTitle'] = 'Feedbacker : Assign Customers to Executives';
			$this->loadViews("assign", $this->global, $data, NULL);
		}
	}
	
	/**
	 * This function used to assign the customers to executives
	 */
	function assignCustomers() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$cust_ids = $this->input->post ( "isChecked" );
			$executive_id = $this->input->post ( "executive" );
			
			for($i = 0; $i < count ( $cust_ids ); $i ++) {
				$data = array (
						"updated_by" => $this->vendorId,
						"updated_dtm" => date ( "Y-m-d H:i:s" ),
						"assigned_to" => $executive_id 
				);
				$this->import_model->assignCustomers ( $data, $cust_ids [$i] );
			}
			
			redirect ( 'unassignCustomers' );
		}
	}
	
	/**
	 * This function used to get customer information
	 * @param unknown $cust_id
	 */
	function rawCustomer($cust_id = NULL)
	{	
		$data ["rawCustomer"] = $this->import_model->getRawCustomer ( $cust_id );
		$data ["fupCustomer"] = $this->import_model->getCustomerFollow ( $cust_id );
		$data ["reqCustomer"] = $this->import_model->getCustomerReq ( $cust_id );
		$data ["companyList"] = $this->import_model->getCompanyList ();
		$data ["typeList"] = $this->import_model->getTypeList ();
		
		$data ["fbTypes"] = $this->import_model->getFeedbackTypes ();
		
		/* $address = $data ["rawCustomer"][0]->registrant_address." ".$data ["rawCustomer"][0]->registrant_city." ".$data ["rawCustomer"][0]->registrant_state." ".$data ["rawCustomer"][0]->registrant_country." ".$data ["rawCustomer"][0]->registrant_zip; */
		$address = $data ["rawCustomer"][0]->registrant_city." ".$data ["rawCustomer"][0]->registrant_state." ".$data ["rawCustomer"][0]->registrant_country." ".$data ["rawCustomer"][0]->registrant_zip;
		$geoData = file_get_contents(GEO_CODE_URL.urlencode($address).'&key='.GMAP_API_KEY);
		$geoDatos = json_decode($geoData, true);
		// pre($geoDatos);die;
		
		$data["lat"] = 0;
		$data["lng"] = 0;
		$data["timeZone"] = array();
		
		if( $geoDatos["status"] == "OK"){
			$data["lat"] = $geoDatos["results"][0]["geometry"]["location"]["lat"];
			$data["lng"] = $geoDatos["results"][0]["geometry"]["location"]["lng"];
			
			$timestamp = strtotime(date("Y-m-d H:i:s"));
// 			$timestamp = 1331766000;
			
			$timezoneData = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=".$data["lat"].",".$data["lng"]."&timestamp=".$timestamp."&key=".GMAP_API_KEY);
			$data["timeZone"] = json_decode($timezoneData, true);
			
			/* pre($data["timeZone"]);
			die; */
		}
		
		$this->global ['pageTitle'] = 'Feedbacker : Customer Details';
		$this->loadViews("custDetails", $this->global, $data, NULL);
	}
	
	/**
	 * This function used to get the customers list
	 */
	function rawCustomerListing() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$searchText = $this->input->post ( 'searchText' );
			$searchStatus = $this->input->post ( 'searchStatus' );
			$noOfRecords = $this->input->post ( "noOfRecords" ) == "" ? 10 : $this->input->post ( "noOfRecords" );
			$data ['searchText'] = $searchText;
			$data ['searchStatus'] = $searchStatus;
			$data ['noOfRecords'] = $noOfRecords;
			
			$count = $this->import_model->rawCustomerListingCount ( $searchText, NULL, $searchStatus );
			
			$returns = $this->paginationCompress ( "rawCustomerListing/", $count, $noOfRecords );
			
			$data ['rawRecords'] = $this->import_model->rawCustomerListing ( $searchText, NULL, $searchStatus, $returns ["page"], $returns ["segment"] );
			
			$this->global ['pageTitle'] = 'Feedbacker : Raw Customers Listing';
			$data ["listType"] = "Raw";
			$data ["paginationUrl"] = "rawCustomerListing/";
			
			$this->loadViews("rawCustomers", $this->global, $data, NULL);
		}
	}
	
	/**
	 * This function used to get another listing for unprocessed customers
	 */
	function rawListing() {
		$searchText = $this->input->post ( 'searchText' );
			$searchStatus = $this->input->post ( 'searchStatus' );
			$noOfRecords = $this->input->post ( "noOfRecords" ) == "" ? 10 : $this->input->post ( "noOfRecords" );
			$data ['searchText'] = $searchText;
			$data ['searchStatus'] = $searchStatus;
			$data ['noOfRecords'] = $noOfRecords;
		
		$count = $this->import_model->rawCustomerListingCount ( $searchText, $this->vendorId, $searchStatus );
		
		$returns = $this->paginationCompress ( "rawListing/", $count, $noOfRecords );
		
		$data ['rawRecords'] = $this->import_model->rawCustomerListing ( $searchText, $this->vendorId, $searchStatus, $returns ["page"], $returns ["segment"] );
		
		$this->global ['pageTitle'] = 'Feedbacker : Raw Customers List';
		$data ["listType"] = "Raw";
		$data ["paginationUrl"] = "rawListing/";
		
		$this->loadViews("rawCustomers", $this->global, $data, NULL);
	}
	
	/**
	 * This function used to record the followup of customers
	 */
	function recordNewFollowup() {
		$this->load->library ( "form_validation" );
		
		$this->form_validation->set_rules ( "callSummary", "Call summary", "required" );
		
		if ($this->form_validation->run () == FALSE) {
			echo (json_encode ( array (
					'status' => 'invalid',
					'errors' => validation_errors () 
			) ));
		} else {
			$custId = $this->security->xss_clean ( $this->input->post ( "custId" ) ); /*
			                                                                     * $rawCallDate = $this->security->xss_clean($this->input->post("callDate"));
			                                                                     * $rawCallTime = $this->security->xss_clean($this->input->post("callTime"));
			                                                                     */
			$callSummary = $this->security->xss_clean ( $this->input->post ( "callSummary" ) );
			$rawNextCallDate = $this->security->xss_clean ( $this->input->post ( "nextCallDate" ) );
			$rawNextCallTime = $this->security->xss_clean ( $this->input->post ( "nextCallTime" ) );
			$fbType = $this->security->xss_clean ( $this->input->post ( "fbType" ) );
			$createdBy = $this->vendorId;
			$createdDtm = date ( "Y-m-d H:i:s" );
			
			/*
			 * $callTime24 = date("H:i", strtotime($rawCallTime));
			 * $callDate = new DateTime(str_replace("/", "-", $rawCallDate));
			 * $split24 = explode(":", $callTime24);
			 * $callDate->add(new DateInterval('PT'.$split24[0].'H'.$split24[1]."M"));
			 * $callDate = $callDate->format("Y-m-d H:i:s");
			 */
			
			$nextCallDate = NULL;
			
			if (! empty ( $rawNextCallDate ) && ! empty ( $rawNextCallTime )) {
				$nextCallTime24 = date ( "H:i", strtotime ( $rawNextCallTime ) );
				$nextCallDate = new DateTime ( str_replace ( "/", "-", $rawNextCallDate ) );
				$nextSplit24 = explode ( ":", $nextCallTime24 );
				$nextCallDate->add ( new DateInterval ( 'PT' . $nextSplit24 [0] . 'H' . $nextSplit24 [1] . "M" ) );
				$nextCallDate = $nextCallDate->format ( "Y-m-d H:i:s" );
			}
			
			$data = array (
					"cust_id" => $custId,
					"currently_served_by" => $createdBy,
					"fp_dtm" => date ( "Y-m-d H:i:s" ),
					"fp_summary" => $callSummary,
					"fbt_id" => $fbType,
					"fp_next_call" => $nextCallDate,
					"fp_status" => 1,
					"created_by" => $createdBy,
					"created_dtm" => $createdDtm 
			);
			
			$this->import_model->changeStatus($custId);
			$insertId = $this->import_model->recordNewFollowup ( $data );
			
			if ($insertId > 0) {
				$this->session->set_flashdata ( 'success', 'Followup recorded successfully' );
			} else {
				$this->session->set_flashdata ( 'error', 'Followup failed' );
			}
			
			redirect ( $this->agent->referrer () );
		}
	}
	
	/**
	 * This function is used to update the customer status
	 */
	function updateCustomerStatus() {
		$custStatus = $this->security->xss_clean ( $this->input->post ( "custStatus" ) );
		$custId = $this->security->xss_clean ( $this->input->post ( "custId" ) );
		
		$data = array (
				"status" => $custStatus,
				"updated_by" => $this->vendorId,
				"updated_dtm" => date ( "Y-m-d H:i:s" ) 
		);
		
		$status = $this->import_model->updateCustomerStatus ( $data, $custId );
		
		if ($status) {
			$this->session->set_flashdata ( 'success', 'Status updated successfully' );
		} else {
			$this->session->set_flashdata ( 'error', 'Status updation failed' );
		}
		
		$this->load->library ( 'user_agent' );
		redirect ( $this->agent->referrer () );
	}
	
	/**
	 * This function used to update alternate phone number of customer
	 */
	function updateAlternatePhone() {
		$custAltPhone = $this->security->xss_clean ( $this->input->post ( "value" ) );
		$custId = $this->security->xss_clean ( $this->input->post ( "pk" ) );
		
		$data = array (
				"registrant_alt_phone" => $custAltPhone,
				"updated_by" => $this->vendorId,
				"updated_dtm" => date ( "Y-m-d H:i:s" ) 
		);
		
		$status = $this->import_model->updateAlternatePhone ( $data, $custId );
	}
	
	/**
	 * This function used to update alternate email id of customer
	 */
	function updateAlternateEmail() {
		$custAltEmail = $this->security->xss_clean ( $this->input->post ( "value" ) );
		$custId = $this->security->xss_clean ( $this->input->post ( "pk" ) );
		
		$data = array (
				"registrant_alt_email" => $custAltEmail,
				"updated_by" => $this->vendorId,
				"updated_dtm" => date ( "Y-m-d H:i:s" ) 
		);
		
		$status = $this->import_model->updateAlternatePhone ( $data, $custId );
	}
	
	/**
	 * This function is used to record the customers requirement
	 * Update if exist otherwise Insert
	 */
	function recordRequirement() {
		$this->load->library ( "form_validation" );
		
		$this->form_validation->set_rules ( "reqSummary", "Call summary", "required" );
		$this->form_validation->set_rules ( "custCost", "Call summary", "max_length[20]" );
		$this->form_validation->set_rules ( "estimatedCost", "Call summary", "max_length[20]" );
		$this->form_validation->set_rules ( "reqCustId", "Customer Id", "required|numeric" );
		
		if ($this->form_validation->run () == FALSE) {
			$this->rawCustomer ( $this->input->post ( "reqCustId" ) );
		} else {
			$reqSummary = $this->input->post ( "reqSummary" );
			$custCost = $this->security->xss_clean ( $this->input->post ( "custCost" ) );
			$estimatedCost = $this->security->xss_clean ( $this->input->post ( "estimatedCost" ) );
			$custId = $this->security->xss_clean ( $this->input->post ( "reqCustId" ) );
			
			$checkPrevious = $this->import_model->checkPreviousRequirements ( $custId );
			
			$status = false;
			
			if (! empty ( $checkPrevious )) {
				$data = array (
						"currently_served_by" => $this->vendorId,
						"rem_summary" => $reqSummary,
						"interested_in" => "",
						"cust_cost" => $custCost,
						"estimated_cost" => $estimatedCost,
						"updated_by" => $this->vendorId,
						"updated_dtm" => date ( "Y-m-d H:i:s" ) 
				);
				
				$status = $this->import_model->updateRequirements ( $custId, $data );
			} else {
				$data = array (
						"cust_id" => $custId,
						"currently_served_by" => $this->vendorId,
						"rem_summary" => $reqSummary,
						"interested_in" => "",
						"cust_cost" => $custCost,
						"estimated_cost" => $estimatedCost,
						"created_by" => $this->vendorId,
						"created_dtm" => date ( "Y-m-d H:i:s" ) 
				);
				
				$status = $this->import_model->createRequirements ( $data );
			}
			
			if ($status) {
				$this->session->set_flashdata ( 'success', 'Requirement recorded successfully' );
			} else {
				$this->session->set_flashdata ( 'error', 'Requirement failed' );
			}
			
			redirect ( "rawCustomer/" . $custId );
		}
	}
	
	/**
	 * This function is used to export requirements as PDF
	 */
	function reqExportAsPDF() {
		set_time_limit ( 0 );
		$custId = $this->input->post ( "custId" );
		
		$requirements = $this->import_model->getCustomerWithRequirement ( $custId );
		
		// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf = new MYPDF ( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );
		
		$fileName = "";
		
		if (! empty ( $requirements )) {
			foreach ( $requirements as $rc ) {
				// set document information
				$pdf->SetCreator ( PDF_CREATOR );
				$pdf->SetAuthor ( 'CodeInsect' );
				$pdf->SetTitle ( "" );
				$pdf->SetSubject ( 'Requirement Document for ' );
				
				$logo = 'logo100.png';
				
				// set default header data
				// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
				$pdf->SetHeaderData ( $logo, 10, $rc->domain_name, "by CodeInsect" );
				
				// set header and footer fonts
				$pdf->setHeaderFont ( Array (
						PDF_FONT_NAME_MAIN,
						'',
						PDF_FONT_SIZE_MAIN 
				) );
				$pdf->setFooterFont ( Array (
						PDF_FONT_NAME_DATA,
						'',
						PDF_FONT_SIZE_DATA 
				) );
				
				// set default monospaced font
				$pdf->SetDefaultMonospacedFont ( PDF_FONT_MONOSPACED );
				
				// set margins
				$pdf->SetMargins ( PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT );
				$pdf->SetHeaderMargin ( PDF_MARGIN_HEADER );
				$pdf->SetFooterMargin ( PDF_MARGIN_FOOTER );
				
				// set auto page breaks
				$pdf->SetAutoPageBreak ( TRUE, PDF_MARGIN_BOTTOM );
				
				// set image scale factor
				$pdf->setImageScale ( PDF_IMAGE_SCALE_RATIO );
				
				$pdf->AddPage ();
				
				if (isset ( $rc->rem_summary )) {
					$reqHTML = $rc->rem_summary;
					$brHTML = "<br><br>";
					
					$pdf->writeHTML ( $reqHTML, true, false, true, false, '' );
					$pdf->writeHTML ( $brHTML, true, false, true, false, '' );
					
					$pdf->Write ( 0, "Customer Cost : " . $rc->cust_cost, '', 0, 'L', true, 0, false, false, 0 );
					$pdf->Write ( 0, "Estimated Cost : " . $rc->estimated_cost, '', 0, 'L', true, 0, false, false, 0 );
					
					$pdf->lastPage ();
				}
				
				$fileName = $rc->domain_name;
			}
		}
		
		$pdf->Output ( $fileName . '.pdf', 'D' );
	}
	
	/**
	 * This function used to email the portfolio to customers
	 */
	function emailPortfolio() {
		$this->load->library ( "form_validation" );
		$this->form_validation->set_rules ( "companyList", "Company Name", "numeric|required" );
		$this->form_validation->set_rules ( "typeList", "Email Type", "numeric|required" );
		$this->form_validation->set_rules ( "email", "Email", "required" );
		$this->form_validation->set_rules ( "subject", "Subject", "required" );
		$this->form_validation->set_rules ( "emailHTML", "Email Contect", "required" );
		$this->form_validation->set_rules ( "extraAttFile", "Attachment", "callback_uploadExtraAttachment" );
		
		if ($this->form_validation->run () == FALSE) {
			$this->rawCustomer ( $this->input->post ( "custId" ) );
		} else {
			$this->load->model ( "cms_model" );
			
			$custId = $this->input->post ( "custId" );
			$companyId = $this->input->post ( "companyList" );
			$typeId = $this->input->post ( "typeList" );
			$to = $this->security->xss_clean ( $this->input->post ( "email" ) );
			$subject = $this->security->xss_clean ( $this->input->post ( "subject" ) );
			$emailHTML = $this->input->post ( "emailHTML" );
			$extraAttachment = $this->input->post ( "extraAttFile" );
			
			$companyCredentials = $this->cms_model->getCompanyCredentialsById ( $companyId );
			$companyAttachment = $this->cms_model->getCompanyAttachmentByIdAndType ( $companyId, $typeId );
			$attachType = $this->cms_model->getAttachTypeById ( $typeId );
			
			$result = emailPortfolio ( $to, $subject, $emailHTML, $companyCredentials, $companyAttachment, $extraAttachment );
			
			if ($result) {
				$feedHTML = "<b>From Company : </b>" . $companyCredentials [0]->comp_name . "<br>";
				$feedHTML .= "<b>Type : </b>" . $attachType [0]->at_type . "<br>";
				$feedHTML .= "<b>To Email : </b>" . $to . "<br>";
				$feedHTML .= "<b>Subject : </b>" . $subject;
				if (! empty ( $extraAttachment )) {
					$feedHTML .= "<br><b>Other attachment : </b>" . $extraAttachment;
				}
				
				$emailRecord = array (
						"fp_type" => "EMAIL",
						"cust_id" => $custId,
						"currently_served_by" => $this->vendorId,
						"fp_dtm" => date ( "Y-m-d H:i:s" ),
						"fp_summary" => $feedHTML,
						"fbt_id" => 1,
						"created_by" => $this->vendorId,
						"created_dtm" => date ( "Y-m-d H:i:s" ) 
				);
				
				$this->cms_model->recordEmailFollowup ( $emailRecord );
				$this->session->set_flashdata ( 'success', 'Email sent successfully' );
			} else {
				$this->session->set_flashdata ( 'error', 'Email sending failed' );
			}
			
			redirect ( $this->agent->referrer () );
		}
	}
	
	/**
	 * This function used to upload additional attachment and send with the email
	 */
	function uploadExtraAttachment() {
		if (isset ( $_FILES ['extraAttFile'] ) && ! empty ( $_FILES ['extraAttFile'] ['name'] )) {
			$config = array (
					'upload_path' => './' . ATTACHMENT_PATH,
					'allowed_types' => 'pdf',
					'max_size' => 204800,
					'encrypt_name' => true 
			);
			
			$this->load->library ( 'upload', $config );
			
			if (! $this->upload->do_upload ( 'extraAttFile' )) {
				$this->form_validation->set_message ( 'extraAttFile', $this->upload->display_errors () );
			} else {
				$upload_data = $this->upload->data ();
				$photo_path = $upload_data ['file_name'];
				$_POST ['extraAttFile'] = $photo_path;
				if (! $photo_path) {
					$this->form_validation->set_message ( 'extraAttFile', $this->upload->display_errors () );
				}
				return $photo_path;
			}
		}
	}
	
	
	/**
	 * This function used to get the customers list
	 */
	function followCustomerListing() {
		
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$searchText = $this->input->post ( 'searchText' );
			$searchStatus = $this->input->post ( 'searchStatus' );
			$toDate = $this->input->post ( 'toDate' );
			$executiveId = $this->input->post ( 'executiveId' );
			
			$data ['searchText'] = $searchText;
			$data ['searchStatus'] = $searchStatus;
			$data ['toDate'] = $toDate;
			$data ['executiveId'] = $executiveId;
			
			if(!empty($toDate) || $toDate != NULL){
				$toDate = date("Y-m-d",strtotime(str_replace("/","-", $toDate)));
			}
			if(empty($executiveId) || $executiveId == NULL){
				$executiveId = NULL;
			}
			
			$count = $this->import_model->followCustomerListingCount ( $searchText, $executiveId, $toDate, $searchStatus );
		
			$returns = $this->paginationCompress ( "followCustomerListing/", $count, 10 );
		
			$data ['rawRecords'] = $this->import_model->followCustomerListing ( $searchText, $executiveId, $toDate, $searchStatus, $returns["page"], $returns["segment"] );
		
			$this->global ['pageTitle'] = 'Feedbacker : Followup Customers Data';
			$data ["listType"] = "Follow Up";
			$data ["paginationUrl"] = "followCustomerListing/";
			
			$data ["employeeList"] = $this->import_model->getEmployeesList();
		
			$this->loadViews("followCustomers", $this->global, $data, NULL);
		}
	}
	
	
	/**
	 * This function used to get another listing for unprocessed customers
	 */
	function followListing() {
		$searchText = $this->input->post ( 'searchText' );
		$searchStatus = $this->input->post ( 'searchStatus' );
		$toDate = $this->input->post ( 'toDate' );
		$data ['searchText'] = $searchText;
		$data ['searchStatus'] = $searchStatus;
		$data ['toDate'] = $toDate;
		
		if(!empty($toDate) || $toDate != NULL){
			$toDate = date("Y-m-d",strtotime(str_replace("/","-", $toDate)));
		}
		
		$count = $this->import_model->followCustomerListingCount ( $searchText, $this->vendorId, $toDate, $searchStatus );
		
		$returns = $this->paginationCompress ( "followListing/", $count, 10);
		
		$data ['rawRecords'] = $this->import_model->followCustomerListing ( $searchText, $this->vendorId, $toDate, $searchStatus, $returns ["page"], $returns ["segment"] );
		
		$this->global ['pageTitle'] = 'Feedbacker : Followup Customers Data';
		$data ["listType"] = "Follow Up";
		$data ["paginationUrl"] = "followListing/";
		
		$this->loadViews("followCustomers", $this->global, $data, NULL);
	}
	
	/**
	 * This function used to refresh the current domain Data
	 */
	function refreshDomainData(){
		set_time_limit ( 0 );
		$cust_id = $this->input->post("custId");
		$domain_name = $this->input->post("domainName");
		$Bw = 1366;
		$Bh = 768;
		$Mw = 320;
		$Mh = 480;
		
		$this->load->model("cron_model");
		
		$data = array (
				"scr_img_desk" => base64_encode ( $domain_name ) . ".jpg",
				"scr_img_mobile" => base64_encode ( $domain_name ) . ".jpg",
				"scr_dtm" => date ( "Y-m-d H:i:s" ),
				"updated_by" => 1,
				"updated_dtm" => date ( "Y-m-d H:i:s" )
		);
			
		$this->screenDemo ( $domain_name, $Mw, $Mh, MOBILE_UA, CAPTURE_MOBILE );
		$this->screenDemo ( $domain_name, $Bw, $Bh, BROWSER_UA, CAPTURE_BROWSER );
			
		$this->cron_model->mapSiteImage ( $data, $cust_id );
		
		echo(json_encode(array("image"=>base64_encode($domain_name). ".jpg")));
	}


	function getCustomerFollowupData()
	{
		$fetch_data = $this->import_model->makeFollowupDataTable();

		$data = array();
		
		foreach($fetch_data as $row){
            $sub_array = array();
            $sub_array[] = $row->fbt_name;
			$sub_array[] = $row->fp_next_call;
			$sub_array[] = $row->fp_summary;
            // $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs">Update</button>';
            // $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs">Delete</button>';

            $data[] = $sub_array;
		}
		
		$output = array(
            "draw"              => intval($_POST['draw']),
            "recordsTotal"      => $this->import_model->getFollowupCount(),
            "recordsFiltered"   => $this->import_model->getFilteredData(),
            "data"              => $data
        );

        echo(json_encode($output));
	}
}