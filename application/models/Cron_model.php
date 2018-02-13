<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Cron_Model
 * @filesource : Cron_model.php
 * @author Kishor Mali
 * @access : Access to command line request only
 * @todo : Access restrict for non-cli requests
 * 
 * This class is used to handle the command line to database
 */
class Cron_model extends CI_Model
{
	/**
	 * This function used to get the domain count
	 */
	function getDomainCount()
	{
		$this->db->select("count(*) as count");
		$this->db->from("fb_raw_cust AS BaseTbl");
		$this->db->order_by('BaseTbl.cust_id', "DESC");
		$this->db->where("is_deleted", 0);
		$query = $this->db->get();
		 
		return $query->result();
	}
	
	/**
	 * This function used to get the domain by pagination
	 * @param number $page : This is page size
	 * @param number $limit : This is segment
	 */
	function getDomains($page, $limit)
	{
		$this->db->select("BaseTbl.cust_id, BaseTbl.domain_name");
		$this->db->from("fb_raw_cust AS BaseTbl");
		$this->db->order_by('BaseTbl.cust_id', "DESC");
		$this->db->where("is_deleted", 0);
		$this->db->limit($page, $limit);
		$query = $this->db->get();
	
		return $query->result();
	}
	
	/**
	 * This function is used to store the image for domain
	 * @param array $data : This is updation data
	 * @param number $cust_id : This is customer id
	 */
	function mapSiteImage($data, $cust_id)
	{
		$this->db->where("cust_id", $cust_id);
		$this->db->update("fb_raw_cust", $data);
	}
	
	/**
	 * This function used to get the previous offset count
	 */
	function getOffsetCount()
	{
		$this->db->select("fb_ofcount");
		$this->db->from("fb_cron_counter");
		$this->db->where("is_deleted", 0);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/**
	 * This function used to update the cron offset in database
	 * @param array $offsetData
	 */
	function udpateNewOffset($offsetData)
	{
		$this->db->where("is_deleted", 0);
		$this->db->update("fb_cron_counter", $offsetData);
	}

	/**
	 * This function used to create new offset once previous cycle done
	 * @param array $offsetData
	 */
	function createNewOffset($offsetData)
	{
		$this->db->trans_start();
		$this->db->insert("fb_cron_counter", $offsetData);
		$this->db->trans_complete();
	}
}