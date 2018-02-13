<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @filesource : Report_model.php
 * @author Kishor Mali
 *
 * This class used to do the database operations for reports
 */
class Report_model extends CI_Model{
	
	/**
	 * This function used to get all active employees
	 */
	function getActiveEmployees(){
		$this->db->select("userId, email, name");
		$this->db->from("tbl_users");
		$this->db->where("roleId", ROLE_EMPLOYEE);
		$this->db->where("isDeleted", 0);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function generateEmployeeReport($employeeId, $reportDate = NULL){
		$this->db->select("BaseTbl.fp_id, BaseTbl.fp_type, BaseTbl.cust_id, BaseTbl.currently_served_by,
				BaseTbl.fp_dtm, BaseTbl.fp_summary, BaseTbl.fp_summary, BaseTbl.fbt_id, BaseTbl.fp_next_call,
				USR.email, USR.name,
				CUST.domain_name, CUST.registrant_name");
		$this->db->from("fb_cust_followup as BaseTbl");
		$this->db->join("tbl_users as USR", "USR.userId = BaseTbl.currently_served_by", "left");
		$this->db->join("fb_raw_cust as CUST", "CUST.cust_id = BaseTbl.cust_id");
		$this->db->join("fb_fbtype as FBT", "FBT.fbt_id = BaseTbl.fbt_id", "left");
		if($reportDate == NULL || empty($reportDate)){
			$this->db->where ("DATE_FORMAT(BaseTbl.fp_dtm,'%Y-%m-%d')", date('Y-m-d'));
		} else {
			$this->db->where ("DATE_FORMAT(BaseTbl.fp_dtm,'%Y-%m-%d')", $reportDate);
		}
		$this->db->where("BaseTbl.currently_served_by", $employeeId);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function getEmployeeById($employeeId){
		$this->db->select("userId, email, name");
		$this->db->from("tbl_users");
		$this->db->where("roleId", ROLE_EMPLOYEE);
		$this->db->where("userId", $employeeId);
		$this->db->where("isDeleted", 0);
		$query = $this->db->get();
		
		return $query->result();
	}
}