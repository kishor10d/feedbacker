<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

require APPPATH . '/libraries/BaseController.php';
class Cms extends BaseController {
	/**
	 * This is default constructor of the class
	 */
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'cms_model' );
		$this->load->library ( "user_agent" );
		$this->isLoggedIn ();
	}
	
	/**
	 * This function is used to render the html template in browser
	 * 
	 * @param number $tempId
	 *        	: This is template id
	 */
	public function templateWrapper($tempId = NULL) {
		if ($tempId) {
			$html = $this->cms_model->getTemplateById ( $tempId );
			$data ["html"] = $html [0]->temp_html;
		} else {
			$data ["html"] = "Directory Access Forbidden";
		}
		
		$this->load->view ( "templateWrapper", $data );
	}
	
	/**
	 * This function used to load the default view
	 */
	function emailTemplates() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$searchText = $this->input->post ( 'searchText' );
			$data ['searchText'] = $searchText;
			
			$this->load->library ( 'pagination' );
			
			$count = $this->cms_model->emailTemplatesCount ( $searchText );
			
			$returns = $this->paginationCompress ( "rawCustomerListing/", $count, 10 );
			
			$data ['rawRecords'] = $this->cms_model->emailTemplates ( $searchText, $returns ["page"], $returns ["segment"] );
			
			$this->global ['pageTitle'] = 'Feedbacker : Email Templates';
			
			$this->load->view ( "includes/header", $this->global );
			$this->load->view ( "emailTemplates", $data );
			$this->load->view ( "includes/footer" );
		}
	}
	
	/**
	 * This function used to get template for edit
	 * 
	 * @param number $tempId
	 *        	: This is template id
	 */
	function editTemplate($tempId = NULL) {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			if ($tempId) {
				$data ["rawRecords"] = $this->cms_model->getTemplateById ( $tempId );
			} else {
				$data ["rawRecords"] = "Directory Access Forbidden";
			}
			
			$this->global ['pageTitle'] = 'Feedbacker : Edit Email Templates';
			
			$this->load->view ( "includes/header", $this->global );
			$this->load->view ( "editTemplate", $data );
			$this->load->view ( "includes/footer" );
		}
	}
	
	/**
	 * This function is used to update email template
	 */
	function updateEmailTemplate() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$this->load->library ( "form_validation" );
			
			$this->form_validation->set_rules ( "tempId", "Template Id", "numeric|required" );
			$this->form_validation->set_rules ( "emailTemplate", "Template HTML", "required" );
			
			if ($this->form_validation->run () == FALSE) {
				$this->editTemplate ( $this->input->post ( "tempId" ) );
			} else {
				$tempId = $this->input->post ( "tempId" );
				$tempHTML = $this->input->post ( "emailTemplate" );
				
				$data = array (
						"temp_html" => $tempHTML,
						"updated_by" => $this->vendorId,
						"updated_dtm" => date ( "Y-m-d H:i:s" ) 
				);
				
				$result = $this->cms_model->updateEmailTemplate ( $data, $tempId );
				
				$this->load->library ( "user_agent" );
				redirect ( "emailTemplates" );
			}
		}
	}
	
	/**
	 * This function used to load the company listing
	 */
	function companyListing() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$searchText = $this->input->post ( 'searchText' );
			$data ['searchText'] = $searchText;
			$this->load->library ( 'pagination' );
			$count = $this->cms_model->companyListingCount ( $searchText );
			$returns = $this->paginationCompress ( "companyListing/", $count, 10 );
			$data ['rawRecords'] = $this->cms_model->companyListing ( $searchText, $returns ["page"], $returns ["segment"] );
			$this->global ['pageTitle'] = 'Feedbacker : Company Listing';
			$this->load->view ( "includes/header", $this->global );
			$this->load->view ( "companyListing", $data );
			$this->load->view ( "includes/footer" );
		}
	}
	
	/**
	 * This function used to load the attachment listing
	 */
	function attachmentListing() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$searchText = $this->input->post ( 'searchText' );
			$data ['searchText'] = $searchText;
			$this->load->library ( 'pagination' );
			$count = $this->cms_model->attachmentListingCount ( $searchText );
			$returns = $this->paginationCompress ( "attachmentListing/", $count, 10 );
			$data ['rawRecords'] = $this->cms_model->attachmentListing ( $searchText, $returns ["page"], $returns ["segment"] );
			
			$this->global ['pageTitle'] = 'Feedbacker : Company Listing';
			$this->load->view ( "includes/header", $this->global );
			$this->load->view ( "attachmentListing", $data );
			$this->load->view ( "includes/footer" );
		}
	}
	
	/**
	 * This function used to edit attachment by id
	 * 
	 * @param number $atId        	
	 */
	function editAttachment($atId = NULL) {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$data ["rawData"] = $this->cms_model->getAttachmentDataById ( $atId );
			
			$this->global ['pageTitle'] = 'Feedbacker : Edit Attachment';
			$this->load->view ( "includes/header", $this->global );
			$this->load->view ( "editAttachment", $data );
			$this->load->view ( "includes/footer" );
		}
	}
	
	/**
	 * This function is used to update the attachment
	 */
	function updateAttachment() {
		if ($this->isAdmin () == TRUE) {
			$this->loadThis ();
		} else {
			$this->load->library ( "form_validation" );
			
			$this->form_validation->set_rules ( "atId", "Attachment Id", "numeric|required" );
			$this->form_validation->set_rules ( "attFile", "Attachment File", "callback_uploadAttachment" );
			
			if ($this->form_validation->run () == FALSE) {
				$this->editAttachment ( $this->input->post ( "atId" ) );
			} else {
				$attFile = $this->input->post ( "attFile" );
				$atId = $this->input->post ( "atId" );
				
				$data = array (
						"at_path" => $attFile,
						"updated_by" => $this->vendorId,
						"updated_dtm" => date ( "Y-m-d H:i:s" ) 
				);
				$result = $this->cms_model->updateAttachment ( $data, $atId );
				
				if ($result) {
					$this->session->set_flashdata ( 'success', 'Attachment updated successfully' );
				} else {
					$this->session->set_flashdata ( 'error', 'Attachment updation failed' );
				}
				
				redirect ( $this->agent->referrer () );
			}
		}
	}
	
	/**
	 * This funciton used to upload the attachment file
	 * 
	 * @return boolean[]|unknown[]|boolean[]|string[] : This is miscellaneous data
	 */
	function uploadAttachment() {
		if (isset ( $_FILES ['attFile'] ) && ! empty ( $_FILES ['attFile'] ['name'] )) {
			$config = array (
					'upload_path' => './' . ATTACHMENT_PATH,
					'allowed_types' => 'pdf',
					'max_size' => '100000',
					'encrypt_name' => true 
			);
			
			$this->load->library ( 'upload', $config );
			
			if (! $this->upload->do_upload ( 'attFile' )) {
				$this->form_validation->set_message ( 'attFile', $this->upload->display_errors () );
			} else {
				$upload_data = $this->upload->data ();
				$photo_path = $upload_data ['file_name'];
				$_POST ['attFile'] = $photo_path;
				if (! $photo_path) {
					$this->form_validation->set_message ( 'attFile', $this->upload->display_errors () );
				}
				return $photo_path;
			}
		}
	}
	
	/**
	 * This function used to get the email template by company id 
	 */
	function getTemplateByCompId() {
		$companyId = $this->input->post ( "companyId" );
		
		if ($companyId) {
			$result = $this->cms_model->getTemplateByCompId ( $companyId );
			echo (json_encode ( array (
					"status" => true,
					"data" => $result 
			) ));
		} else {
			echo (json_encode ( array (
					"status" => false,
					"data" => "" 
			) ));
		}
	}
}