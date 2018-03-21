<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Cms_model extends CI_Model {
	
	/**
	 * This function is used to get the email template listing count
	 * 
	 * @param string $searchText
	 *        	: This is optional search text
	 * @return number $count : This is row count
	 */
	function emailTemplatesCount($searchText = '') {
		$this->db->select ( 'BaseTbl.temp_id, BaseTbl.comp_id, BaseTbl.temp_name, BaseTbl.temp_html,
        	BaseTbl.temp_type, CMP.comp_name' );
		$this->db->from ( 'fb_email_template as BaseTbl' );
		$this->db->join ( 'fb_company as CMP', 'CMP.comp_id = BaseTbl.comp_id' );
		$this->db->where ( 'BaseTbl.is_deleted', 0 );
		$this->db->where ( 'CMP.is_deleted', 0 );
		if (! empty ( $searchText )) {
			$this->db->like ( 'BaseTbl.temp_name', $searchText );
		}
		
		$query = $this->db->get ();
		
		return count ( $query->result () );
	}
	
	/**
	 * This function is used to get the email template listing count
	 * 
	 * @param string $searchText
	 *        	: This is optional search text
	 * @param number $page
	 *        	: This is pagination offset
	 * @param number $segment
	 *        	: This is pagination limit
	 * @return array $result : This is result
	 */
	function emailTemplates($searchText = '', $page, $segment) {
		$this->db->select ( 'BaseTbl.temp_id, BaseTbl.comp_id, BaseTbl.temp_name, BaseTbl.temp_html,
        	BaseTbl.temp_type, CMP.comp_name' );
		$this->db->from ( 'fb_email_template as BaseTbl' );
		$this->db->join ( 'fb_company as CMP', 'CMP.comp_id = BaseTbl.comp_id' );
		$this->db->where ( 'BaseTbl.is_deleted', 0 );
		$this->db->where ( 'CMP.is_deleted', 0 );
		if (! empty ( $searchText )) {
			$this->db->like ( 'BaseTbl.temp_name', $searchText );
		}
		
		$this->db->limit ( $page, $segment );
		$query = $this->db->get ();
		
		return $query->result ();
	}
	
	/**
	 * This function is used to get template by id
	 * 
	 * @param number $temp_id
	 *        	: This is template id
	 */
	function getTemplateById($tempId) {
		$this->db->select ( "BaseTbl.temp_id, BaseTbl.temp_html, BaseTbl.temp_name, CMP.comp_name" );
		$this->db->from ( "fb_email_template as BaseTbl" );
		$this->db->join ( "fb_company as CMP", "CMP.comp_id = BaseTbl.comp_id" );
		$this->db->where ( "BaseTbl.temp_id", $tempId );
		$this->db->where ( "BaseTbl.is_deleted", 0);
		$query = $this->db->get ();
		return $query->result ();
	}
	
	/**
	 *
	 * @param unknown $tempData        	
	 * @param unknown $tempId        	
	 */
	function updateEmailTemplate($tempData, $tempId) {
		$this->db->where ( "temp_id", $tempId );
		$this->db->update ( "fb_email_template", $tempData );
	}
	
	/**
	 * This function is used to get the company listing count
	 * 
	 * @param string $searchText
	 *        	: This is optional search text
	 * @return number $count : This is row count
	 */
	function companyListingCount($searchText = '') {
		$this->db->select ( 'BaseTbl.comp_id, BaseTbl.comp_name, BaseTbl.comp_url, BaseTbl.address,
        	BaseTbl.contact, BaseTbl.comp_email' );
		$this->db->from ( 'fb_company as BaseTbl' );
		$this->db->where ( 'BaseTbl.is_deleted', 0 );
		if (! empty ( $searchText )) {
			$this->db->like ( 'BaseTbl.comp_name', $searchText );
			$this->db->or_like ( 'BaseTbl.comp_url', $searchText );
			$this->db->or_like ( 'BaseTbl.address', $searchText );
			$this->db->or_like ( 'BaseTbl.contact', $searchText );
			$this->db->or_like ( 'BaseTbl.comp_email', $searchText );
		}
		$query = $this->db->get ();
		
		return count ( $query->result () );
	}
	
	/**
	 * This function is used to get the company listing
	 * 
	 * @param string $searchText
	 *        	: This is optional search text
	 * @param number $page
	 *        	: This is pagination offset
	 * @param number $segment
	 *        	: This is pagination limit
	 * @return array $result : This is result
	 */
	function companyListing($searchText = '', $page, $segment) {
		$this->db->select ( 'BaseTbl.comp_id, BaseTbl.comp_name, BaseTbl.comp_url, BaseTbl.address,
        	BaseTbl.contact, BaseTbl.comp_email' );
		$this->db->from ( 'fb_company as BaseTbl' );
		$this->db->where ( 'BaseTbl.is_deleted', 0 );
		if (! empty ( $searchText )) {
			$this->db->like ( 'BaseTbl.comp_name', $searchText );
			$this->db->or_like ( 'BaseTbl.comp_url', $searchText );
			$this->db->or_like ( 'BaseTbl.address', $searchText );
			$this->db->or_like ( 'BaseTbl.contact', $searchText );
			$this->db->or_like ( 'BaseTbl.comp_email', $searchText );
		}
		$this->db->limit ( $page, $segment );
		$query = $this->db->get ();
		
		return $query->result ();
	}
	
	/**
	 * This function is used to get the attachment listing count
	 * 
	 * @param string $searchText
	 *        	: This is optional search text
	 * @return number $count : This is row count
	 */
	function attachmentListingCount($searchText = '') {
		$this->db->select ( 'BaseTbl.at_id, BaseTbl.comp_id, BaseTbl.at_type_id, BaseTbl.at_path,
        	CMP.comp_name, ATC.at_type' );
		$this->db->from ( 'fb_attachments as BaseTbl' );
		$this->db->join ( 'fb_company as CMP', 'CMP.comp_id = BaseTbl.comp_id');
		$this->db->join ( 'fb_attach_type as ATC', 'ATC.at_type_id = BaseTbl.at_type_id', 'left' );
		$this->db->order_by ( "BaseTbl.at_id", "DESC" );
		$this->db->where ( 'BaseTbl.is_deleted', 0 );
		$this->db->where ( 'CMP.is_deleted', 0 );
		if (! empty ( $searchText )) {
			$this->db->like ( 'CMP.comp_name', $searchText );
			$this->db->or_like ( 'ATC.at_type', $searchText );
		}
		$query = $this->db->get ();
		
		return count ( $query->result () );
	}
	
	/**
	 * This function is used to get the attachment listing count
	 * 
	 * @param string $searchText
	 *        	: This is optional search text
	 * @param number $page
	 *        	: This is pagination offset
	 * @param number $segment
	 *        	: This is pagination limit
	 * @return array $result : This is result
	 */
	function attachmentListing($searchText = '', $page, $segment) {
		$this->db->select ( 'BaseTbl.at_id, BaseTbl.comp_id, BaseTbl.at_type_id, BaseTbl.at_path,
        	CMP.comp_name, ATC.at_type' );
		$this->db->from ( 'fb_attachments as BaseTbl' );
		$this->db->join ( 'fb_company as CMP', 'CMP.comp_id = BaseTbl.comp_id' );
		$this->db->join ( 'fb_attach_type as ATC', 'ATC.at_type_id = BaseTbl.at_type_id', 'left' );
		$this->db->order_by ( "BaseTbl.at_id", "DESC" );
		$this->db->where ( 'BaseTbl.is_deleted', 0 );
		$this->db->where ( 'CMP.is_deleted', 0 );
		if (! empty ( $searchText )) {
			$this->db->like ( 'CMP.comp_name', $searchText );
			$this->db->or_like ( 'ATC.at_type', $searchText );
		}
		$this->db->limit ( $page, $segment );
		$query = $this->db->get ();
		
		return $query->result ();
	}
	
	/**
	 * This function used to get attachment data by id
	 * 
	 * @param number $atId
	 *        	: This is attachment id
	 * @return object $result : This is result
	 */
	function getAttachmentDataById($atId) {
		$this->db->select ( 'BaseTbl.at_id, BaseTbl.comp_id, BaseTbl.at_type_id, BaseTbl.at_path,
        	CMP.comp_name, ATC.at_type' );
		$this->db->from ( 'fb_attachments as BaseTbl' );
		$this->db->join ( 'fb_company as CMP', 'CMP.comp_id = BaseTbl.comp_id', 'left' );
		$this->db->join ( 'fb_attach_type as ATC', 'ATC.at_type_id = BaseTbl.at_type_id', 'left' );
		$this->db->where ( 'BaseTbl.is_deleted', 0 );
		$this->db->where ( 'BaseTbl.at_id', $atId );
		$query = $this->db->get ();
		
		return $query->result ();
	}
	
	/**
	 * This function is used to update attachment data by attachment id
	 * 
	 * @param array $data
	 *        	: This is udpation information
	 * @param number $atId
	 *        	: This is attachment id
	 */
	function updateAttachment($data, $atId) {
		$this->db->where ( "at_id", $atId );
		$this->db->update ( "fb_attachments", $data );
		return $this->db->affected_rows ();
	}
	
	/**
	 * This function used to get template by company id
	 * 
	 * @param number $companyId
	 *        	: this is company id
	 * @return object $result : this is result object
	 */
	function getTemplateByCompId($companyId) {
		$this->db->select ( "BaseTbl.temp_id, BaseTbl.comp_id, BaseTbl.temp_html" );
		$this->db->from ( "fb_email_template AS BaseTbl" );
		$this->db->where ( "BaseTbl.is_deleted", 0 );
		$this->db->where ( "BaseTbl.comp_id", $companyId );
		$query = $this->db->get ();
		
		return $query->result ();
	}
	
	/**
	 * This function is used to get company credentials by id
	 * 
	 * @param number $companyId
	 *        	: This is company id
	 */
	function getCompanyCredentialsById($companyId) {
		$this->db->select ( "comp_id, comp_name, comp_email, comp_pass" );
		$this->db->where ( "comp_id", $companyId );
		$this->db->where ( "is_deleted", 0 );
		$query = $this->db->get ( "fb_company" );
		
		return $query->result ();
	}
	
	/**
	 * This function used to get attachment by type and company id
	 * 
	 * @param unknown $companyId : This is company id
	 * @param unknown $typeId : This is attachment type id
	 */
	function getCompanyAttachmentByIdAndType($companyId, $typeId) {
		$this->db->select ( "comp_id, at_type_id, at_path" );
		$this->db->where ( "comp_id", $companyId );
		$this->db->where ( "at_type_id", $typeId );
		$this->db->where ( "is_deleted", 0 );
		$query = $this->db->get ( "fb_attachments" );
		
		return $query->result ();
	}
	
	/**
	 * This function used to get attachment type by id
	 * 
	 * @param number $typeId : This is type id
	 */
	function getAttachTypeById($typeId) {
		$this->db->select ( "at_type_id, at_type" );
		$this->db->where ( "at_type_id", $typeId );
		$query = $this->db->get ( "fb_attach_type" );
		
		return $query->result ();
	}
	
	/**
	 * This function used to insert email records as followup
	 * 
	 * @param array $emailRecord : This is record array
	 */
	function recordEmailFollowup($emailRecord) {
		$this->db->trans_start ();
		$this->db->insert ( "fb_cust_followup", $emailRecord );
		$this->db->trans_complete ();
	}
	
	/**
	 * This function used to get customer count by status
	 * Finalize means the customer who purchased services from us
	 * @param number $status
	 * @param number $role
	 * @param number $vendorId
	 * @return number $count
	 */
	function getCustomerCountByStatus($status, $role, $vendorId) {
		$this->db->select ( "cust_id" );
		$this->db->where ( "is_deleted", 0 );
		$this->db->where ( "status", $status );
		if ($role == ROLE_EMPLOYEE) {
			$this->db->where ( "assigned_to", $vendorId );
		}
		$query = $this->db->get ( "fb_raw_cust" );
		
		return count ( $query->result () );
	}
	
	/**
	 * This function used to get customer count by assign status
	 * Finalize means the customer who purchased services from us
	 * @param number $assigned
	 * @param number $tot
	 * @return number
	 */
	function getCustomerCountByAssignement($assigned, $tot) {
		$this->db->select ( "cust_id" );
		$this->db->where ( "is_deleted", 0 );
		if ($tot == 0) {
			if ($assigned == 0) {
				$this->db->where ( "assigned_to", $assigned );
			} else {
				$this->db->where ( "assigned_to >=", $assigned );
			}
		}
		$this->db->where ( "status !=", DEAD );
		$query = $this->db->get ( "fb_raw_cust" );
		
		return count ( $query->result () );
	}
	
	/**
	 * This function is used to get the active admin users count
	 */
	function getAdminUsersCount() {
		$this->db->select ( "userId" );
		$this->db->where ( "isDeleted", 0 );
		$this->db->where ( "userId !=", 1 );
		$query = $this->db->get ( "tbl_users" );
		
		return count ( $query->result () );
	}
	
	/**
	 * This function used to get the count of followup users
	 * @param number $vendorId
	 * @param number $role
	 */
	function getFollowupCount($vendorId, $role)
	{
		$this->db->select ( "count(*) as count" );
		$this->db->where ( "fp_type", "CALL");
		$this->db->where ( "fp_status", 1);
		$this->db->where ( "DATE_FORMAT(fp_next_call,'%Y-%m-%d') <= ", date('Y-m-d'));
		if($role != ROLE_ADMIN){
			$this->db->where ( "currently_served_by", $vendorId);
		}
		$query = $this->db->get ( "fb_cust_followup" );
		$result = $query->result ();
		return $result[0]->count;
	}

	/**
	 * This function is used to get company list
	 */
	function getCompanies()
	{
		$this->db->select ( "comp_id, comp_name" );
		$this->db->where ( "is_deleted", 0);
		$query = $this->db->get ( "fb_company" );
		$result = $query->result ();

		return $result;
	}

	/**
	 * This function is used to get attachment type
	 */
	function getAttachmentTypes()
	{
		$this->db->select ( "at_type_id, at_type" );
		$this->db->where ( "is_deleted", 0);
		$query = $this->db->get ( "fb_attach_type" );
		$result = $query->result ();

		return $result;
	}

	/**
	 * This function used to save attachment details
	 * @param array $attachmentData
	 */
	function addNewAttachment($attachmentData)
	{
		$this->db->trans_start();
		$this->db->insert("fb_attachments", $attachmentData);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		return $insert_id;
	}
}

