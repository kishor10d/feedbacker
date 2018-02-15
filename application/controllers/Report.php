<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/third_party/vendor/autoload.php';
require APPPATH . '/libraries/mypdf.php';

/**
 * @filesource : Report.php
 * @author Kishor Mali
 * 
 * This class is used to generate various reports
 */
class Report extends BaseController{
	
	/**
	 * This if default constructor of class
	 */
	function __construct(){
		parent::__construct();
		$this->isLoggedIn ();
		$this->load->model("report_model");
	}
	
	/**
	 * This functio is used to laod the employee report screen
	 */
	function employeeReport(){
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$data["activeEmployees"] = $this->report_model->getActiveEmployees();
			$this->global ['pageTitle'] = 'Feedbacker : Empoyee-wise Report';
			$this->loadViews("report/employeeReport", $this->global, $data, NULL);
		}
	}
	
	function generateEmployeeReport(){
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			
			$this->load->library("form_validation");
			
			$this->form_validation->set_rules("employees", "Employee", "required");
			
			if($this->form_validation->run() === false){
				$this->employeeReport();
			} else {
				
				$employeeId = $this->security->xss_clean($this->input->post("employees"));
				$reportDate = $this->security->xss_clean($this->input->post("reportDate"));
				
				if(!empty($reportDate) || $reportDate != NULL){
					$reportDate = date("Y-m-d",strtotime(str_replace("/","-", $reportDate)));
				} else {
					$reportDate = date("Y-m-d");
				}
				
				$reportData = $this->report_model->generateEmployeeReport($employeeId, $reportDate);
				
				$employeeData = $this->report_model->getEmployeeById($employeeId);
				
				$this->generateEmployeeWisePDF($employeeData, $reportData, $reportDate);
			}
		}
	}
	
	function generateEmployeeWisePDF($employeeData, $reportData, $reportDate){
		
		set_time_limit ( 0 );
		ob_start();
		
		$for = $employeeData[0]->name." (".$employeeData[0]->email.") ";
		
		/* pre($employeeData);
		pre($reportData); */
		
		$pdf = new MYPDF ( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false );
		
		$pdf->SetCreator ( PDF_CREATOR );
		$pdf->SetAuthor ( 'CodeInsect' );
		$pdf->SetTitle ( "Followup Report" );
		$pdf->SetSubject ( 'Followup Report for ' );
	
		$logo = 'logo100.png';
		$pdf->SetHeaderData ( $logo, 10, $for, "Report of date : ".date("d M Y", strtotime($reportDate)) );
		$pdf->setHeaderFont ( Array (PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN) );
		$pdf->setFooterFont ( Array (PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA) );		
		$pdf->SetDefaultMonospacedFont ( PDF_FONT_MONOSPACED );
		$pdf->SetMargins ( PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT );
		$pdf->SetHeaderMargin ( PDF_MARGIN_HEADER );
		$pdf->SetFooterMargin ( PDF_MARGIN_FOOTER );
		$pdf->SetAutoPageBreak ( TRUE, PDF_MARGIN_BOTTOM );
		$pdf->setImageScale ( PDF_IMAGE_SCALE_RATIO );
		$pdf->AddPage('L', 'A4');
		
		$pdfHTML = $this->employeeWiseHTML($reportData);
		
		$pdf->writeHTML($pdfHTML, true, false, false, false, '' );
		$pdf->lastPage ();
		
		$for = $for.$reportDate;
		$pdf->Output($for.'.pdf', 'D');
	}
	
	function employeeWiseHTML($reportData){
		
		$html = '<div style="margin:5px;">';
		$html .= '<table border="1" cellpadding="2" cellspacing="2">';
		$html .= '<thead>';
		$html .= '<tr style="background-color:red;">';
		$html .= '<th align="center" style="width:15%;font-size:10px;font-weight:bold">Followup Type</th>';
		$html .= '<th align="center" style="width:25%;font-size:10px;font-weight:bold">Domain Name</th>';
		$html .= '<th align="center" style="width:15%;font-size:10px;font-weight:bold">Registrant Name</th>';
		$html .= '<th align="center" style="width:45%;font-size:10px;font-weight:bold">Followup Summary</th>';
		$html .= '</tr>';
		$html .= '</thead>';
		$html .= '<tbody>';
		
		if(!empty($reportData)){
			foreach($reportData as $rep){
				$html .= '<tr>';
				$html .= '<td style="width:15%;text-align:center;font-size:10px;">'.$rep->fp_type.'</td>';
				$html .= '<td style="width:25%;text-align:center;font-size:10px;">'.$rep->domain_name.'</td>';
				$html .= '<td style="width:15%;text-align:center;font-size:10px;">'.$rep->registrant_name.'</td>';
				$html .= '<td style="width:45%;font-size:10px;">'.$rep->fp_summary.'</td>';
				$html .= '</tr>';
			}	
		} else {
			$html .= '<tr>';
			$html .= '<td colspan="4" style="text-align:center;font-size:10px;">No data found</td>';			
			$html .= '</tr>';
		}
		
		
		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
			
		return $html;
	}
}
