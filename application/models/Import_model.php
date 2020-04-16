<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Import_model extends CI_Model
{
	/**
	 * This function used to check the existance of domain in database
	 * @param string $domain_name
	 */
	function checkDomainExists($domain_name)
	{
		$query = "SELECT cust_id FROM fb_raw_cust WHERE domain_name = '".$domain_name."'";
		$stmt = $this->db->query($query);
		return $stmt->result();
	}

	/**
	 * This function used to push the new domain in database
	 * @param array $successRecords
	 */
	function pushNewRecord($successRecords)
	{
		$this->db->trans_start();
		$this->db->insert("fb_raw_cust", $successRecords);
		$this->db->trans_complete();
	}
	
	/**
	 * This function used to push all success domain records
	 * @param array $successRecords
	 */
	function pushSuccessRecords($successRecords)
	{
		$this->db->trans_start();
		$this->db->insert_batch("fb_raw_cust", $successRecords);
		$this->db->trans_complete();
	}

	/**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function importListingCount($searchText = '', $country = '')
    {
        $this->db->select('count(BaseTbl.cust_id) as count');
        $this->db->from('fb_raw_cust as BaseTbl');
        if(!empty($country)) { $this->db->where('BaseTbl.registrant_country', $country); }
        if(!empty($searchText))
        {
            $where = "( BaseTbl.domain_name LIKE '%$searchText%' OR BaseTbl.registrant_city LIKE '%$searchText%' OR BaseTbl.registrant_email LIKE '%$searchText%')";
            $this->db->where($where);
        }        
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->order_by('BaseTbl.create_date', "DESC");
        $query = $this->db->get();
        
        $count = $query->result();
        
        return $count[0]->count;
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function importListing($searchText = '', $country = '', $page, $segment)
    {
        $this->db->select('BaseTbl.cust_id, BaseTbl.domain_name, BaseTbl.create_date, BaseTbl.expiry_date,
        	BaseTbl.domain_registrar_name,BaseTbl.registrant_name,BaseTbl.registrant_company,
        	BaseTbl.registrant_address,BaseTbl.registrant_city,BaseTbl.registrant_state,
        	BaseTbl.registrant_zip,BaseTbl.registrant_country,BaseTbl.registrant_email,
        	BaseTbl.registrant_phone,BaseTbl.registrant_alt_email,BaseTbl.registrant_alt_phone,
        	BaseTbl.registrant_fax, BaseTbl.scr_img_mobile, BaseTbl.scr_img_desk');
        $this->db->from('fb_raw_cust as BaseTbl');
        if(!empty($country)) { $this->db->where('BaseTbl.registrant_country', $country); }
        if(!empty($searchText))
        {
            $where = "( BaseTbl.domain_name LIKE '%$searchText%' OR BaseTbl.registrant_city LIKE '%$searchText%' OR BaseTbl.registrant_email LIKE '%$searchText%')";
            $this->db->where($where);
        }
        $this->db->order_by('BaseTbl.create_date', "DESC");
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function used to get the list of distinct countries
     */
    function getDistictCountries()
    {
        $this->db->select("DISTINCT(BaseTbl.registrant_country)");
        $this->db->from("fb_raw_cust as BaseTbl");
        $this->db->order_by("BaseTbl.registrant_country");
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param string $country : This is string country name
     */
    function assignListingCount($searchText = '', $country="")
    {
    	$this->db->select('count(*) as count');
    	$this->db->from('fb_raw_cust as BaseTbl');
    	if(!empty($country)) { $this->db->where('BaseTbl.registrant_country', $country); }
    	$this->db->order_by('BaseTbl.create_date', "DESC");
    	$this->db->where('BaseTbl.is_deleted', 0);
    	$this->db->where('BaseTbl.assigned_to', 0);
    	if(!empty($searchText)){
    		$where = "( BaseTbl.domain_name LIKE '%$searchText%' OR BaseTbl.registrant_city LIKE '%$searchText%' OR BaseTbl.registrant_email LIKE '%$searchText%' OR BaseTbl.registrant_country LIKE '%$searchText%')";
    		$this->db->where($where);
    	}
    	$query = $this->db->get();
    
    	return $query->result();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param string $country : This is string country name
     * @param number $limit : This is records limit
     * @return array $result : This is result
     */
    function assignListing($searchText = '', $country="", $page, $segment)
    {
        $this->db->select('BaseTbl.cust_id, BaseTbl.domain_name, BaseTbl.create_date, BaseTbl.expiry_date,
            BaseTbl.domain_registrar_name,BaseTbl.registrant_name,BaseTbl.registrant_company,
            BaseTbl.registrant_address,BaseTbl.registrant_city,BaseTbl.registrant_state,
            BaseTbl.registrant_zip,BaseTbl.registrant_country,BaseTbl.registrant_email,
            BaseTbl.registrant_phone,BaseTbl.registrant_alt_email,BaseTbl.registrant_alt_phone,
            BaseTbl.registrant_fax, BaseTbl.scr_img_mobile, BaseTbl.scr_img_desk');
        $this->db->from('fb_raw_cust as BaseTbl');
        if(!empty($country)) { $this->db->where('BaseTbl.registrant_country', $country); }
        $this->db->order_by('BaseTbl.create_date', "DESC");
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.assigned_to', 0);
        if(!empty($searchText)){
        	$where = "( BaseTbl.domain_name LIKE '%$searchText%' OR BaseTbl.registrant_city LIKE '%$searchText%' OR BaseTbl.registrant_email LIKE '%$searchText%' OR BaseTbl.registrant_country LIKE '%$searchText%')";
        	$this->db->where($where);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    }


    /**
     * This function is used to get list of executives
     */
    function getExecutives()
    {
        $this->db->select("userId, name");
        $this->db->from("tbl_users");
        $this->db->where("roleId", ROLE_EMPLOYEE);
        $this->db->where("isDeleted", 0);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function used to assign customers to executives
     * @param array $data : This is updation data
     * @param number $cust_id : This is customer id
     * @return boolean TRUE
     */
    function assignCustomers($data, $cust_id)
    {
        $this->db->where("cust_id", $cust_id);
        $this->db->update("fb_raw_cust", $data);
    }

    /**
     * This function is used to get the customer listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function rawCustomerListingCount($searchText = '', $executiveId = NULL, $status)
    {
        $this->db->select('BaseTbl.cust_id, BaseTbl.domain_name, BaseTbl.create_date, BaseTbl.expiry_date,
            BaseTbl.domain_registrar_name,BaseTbl.registrant_name,BaseTbl.registrant_company,
            BaseTbl.registrant_address,BaseTbl.registrant_city,BaseTbl.registrant_state,
            BaseTbl.registrant_zip,BaseTbl.registrant_country,BaseTbl.registrant_email,
            BaseTbl.registrant_phone,BaseTbl.registrant_alt_email,BaseTbl.registrant_alt_phone,
            BaseTbl.registrant_fax, BaseTbl.scr_img_mobile, BaseTbl.scr_img_desk, BaseTbl.status');
        $this->db->from('fb_raw_cust as BaseTbl');
        if($executiveId != NULL) { $this->db->where('BaseTbl.assigned_to', $executiveId); }
        $this->db->where('BaseTbl.is_deleted', 0);
        if($status != 0) { $this->db->where('BaseTbl.status', $status); }
        $this->db->where('BaseTbl.assigned_to !=', 0);
        $this->db->order_by('BaseTbl.create_date', "DESC");
        if(!empty($searchText))
        {
            $where = "( BaseTbl.domain_name LIKE '%$searchText%' OR BaseTbl.registrant_city LIKE '%$searchText%' OR BaseTbl.registrant_email LIKE '%$searchText%' OR BaseTbl.registrant_country LIKE '%$searchText%')";
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        return count($query->result());
    }
    
    /**
     * This function is used to get the customer listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function rawCustomerListing($searchText = '', $executiveId = NULL, $status, $page, $segment)
    {
        $this->db->select('BaseTbl.cust_id, BaseTbl.domain_name, BaseTbl.create_date, BaseTbl.expiry_date,
            BaseTbl.domain_registrar_name,BaseTbl.registrant_name,BaseTbl.registrant_company,
            BaseTbl.registrant_address,BaseTbl.registrant_city,BaseTbl.registrant_state,
            BaseTbl.registrant_zip,BaseTbl.registrant_country,BaseTbl.registrant_email,
            BaseTbl.registrant_phone,BaseTbl.registrant_alt_email,BaseTbl.registrant_alt_phone,
            BaseTbl.registrant_fax, BaseTbl.scr_img_mobile, BaseTbl.scr_img_desk, BaseTbl.status');
        $this->db->from('fb_raw_cust as BaseTbl');
        if($executiveId != NULL) { $this->db->where('BaseTbl.assigned_to', $executiveId); }
        $this->db->order_by('BaseTbl.cust_id', "DESC");
        $this->db->where('BaseTbl.is_deleted', 0);
        if($status != 0) { $this->db->where('BaseTbl.status', $status); }
        $this->db->where('BaseTbl.assigned_to !=', 0);
        $this->db->order_by('BaseTbl.create_date', "DESC");
        if(!empty($searchText))
        {
        	$where = "( BaseTbl.domain_name LIKE '%$searchText%' OR BaseTbl.registrant_city LIKE '%$searchText%' OR BaseTbl.registrant_email LIKE '%$searchText%' OR BaseTbl.registrant_country LIKE '%$searchText%')";
        	$this->db->where($where);
        }
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get raw customer by id
     * @param number $cust_id : This is customer id
     * @return array $result : This is result
     */
    function getRawCustomer($cust_id)
    {
        $this->db->select('BaseTbl.cust_id, BaseTbl.domain_name, BaseTbl.create_date, BaseTbl.expiry_date,
            BaseTbl.domain_registrar_name,BaseTbl.registrant_name,BaseTbl.registrant_company,
            BaseTbl.registrant_address,BaseTbl.registrant_city,BaseTbl.registrant_state,
            BaseTbl.registrant_zip,BaseTbl.registrant_country,BaseTbl.registrant_email,
            BaseTbl.registrant_phone,BaseTbl.registrant_alt_email,BaseTbl.registrant_alt_phone,
            BaseTbl.registrant_fax, BaseTbl.scr_img_mobile, BaseTbl.scr_img_desk, BaseTbl.status');
        $this->db->from('fb_raw_cust as BaseTbl');
        $this->db->order_by('BaseTbl.cust_id', "DESC");
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.cust_id', $cust_id);
        $this->db->order_by('BaseTbl.create_date', "DESC");
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to get domain id by domain url
     * @param string $url : This is domain url
     * @return object $result : This is result object
     */
    function getDomainIdByUrl($url)
    {
        $this->db->select('BaseTbl.cust_id, BaseTbl.domain_name');
        $this->db->from('fb_raw_cust as BaseTbl');
        $this->db->order_by('BaseTbl.cust_id', "DESC");
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.domain_name', $url);
        $query = $this->db->get();
        
        return $query->result();
    }

	/**
	 * This function used to get customer followup records by customer id
	 * @param number $cust_id : This is customer id
	 */
    function getCustomerFollow($cust_id)
    {
        $this->db->select('BaseTbl.fp_id, BaseTbl.fp_type, BaseTbl.cust_id, BaseTbl.fp_dtm, BaseTbl.fp_summary, BaseTbl.fbt_id,
            BaseTbl.fp_next_call, BaseTbl.currently_served_by, User.name, FB.fbt_name');
        $this->db->from('fb_cust_followup as BaseTbl');
        $this->db->join('tbl_users as User', "User.userId = BaseTbl.currently_served_by");
        $this->db->join('fb_fbtype as FB', "BaseTbl.fbt_id = FB.fbt_id");
        $this->db->order_by('BaseTbl.fp_id', "DESC");
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.cust_id', $cust_id);
        $query = $this->db->get();
        
        return $query->result();
    }

	/**
	 * This function used to get customer requirements using customer id
	 * @param number $custId : This is customer id
	 */    	
    function getCustomerReq($custId)
    {
        $this->db->select('currently_served_by, rem_summary, interested_in, cust_cost, estimated_cost, conversion_cost');
        $this->db->from('fb_cust_reqment');
        $this->db->where('is_deleted', 0);
        $this->db->where('cust_id', $custId);
        $query = $this->db->get();

        return $query->result();
    }

    /**
     * This function is used to record the customers follow up
     * @param array $data : This is recorded data
     * @return number $insertId : This is last inserted records id
     */
    function recordNewFollowup($data)
    {
    	$update = array("fp_status"=>0, "updated_by"=>$data["created_by"], "updated_dtm"=>$data["created_dtm"]);
    	$this->db->where("fp_status", 1);
    	$this->db->where("fp_type", "CALL");
    	$this->db->where("cust_id", $data["cust_id"]);
    	$this->db->update("fb_cust_followup", $update);
    	
        $this->db->trans_start();
        $this->db->insert("fb_cust_followup", $data);
        $insertId = $this->db->insert_id();
        $this->db->trans_complete();

        return $insertId;
    }

    /**
     * This function is used to get all feedback types
     * @return object $result : This is result object
     */
    function getFeedbackTypes()
    {   
        $this->db->order_by("fbt_name","ASC");
        $query = $this->db->get("fb_fbtype");
        return $query->result();
    }

    /**
     * This function used to udpate customers status
     * @param number $custStatus : This is customers status
     * @param number $custId : This is customers id
     */
    function updateCustomerStatus($custData, $custId)
    {
        $this->db->where("cust_id", $custId);
        $this->db->update("fb_raw_cust", $custData);
        return $this->db->affected_rows();
    }

     /**
     * This function used to udpate customers status
     * @param number $custStatus : This is customers status
     * @param number $custId : This is customers id
     */
    function updateAlternatePhone($custData, $custId)
    {
        $this->db->where("cust_id", $custId);
        $this->db->update("fb_raw_cust", $custData);
        return $this->db->affected_rows();
    }

    /**
     * This function used to check whether we have previous requirment of customer or not
     * @param number $custId : This is customer id
     */
    function checkPreviousRequirements($custId)
    {
        $this->db->select("rem_id");
        $this->db->where("cust_id", $custId);
        $query = $this->db->get("fb_cust_reqment");

        return $query->result();
    }

    /**
     * This function used to update requirement of customer by id
     * @param number $custId : This is customer id
     * @param array $data : This is updated data
     */
    function updateRequirements($custId, $data)
    {
        $this->db->where("cust_id", $custId);
        $query = $this->db->update("fb_cust_reqment", $data);

        return $this->db->affected_rows();
    }

    /**
     * This function used to create requirement of customer
     * @param array $data : This is data
     */
    function createRequirements($data)
    {
        $this->db->trans_start();
        $this->db->insert("fb_cust_reqment", $data);
        $insertId = $this->db->insert_id();
        $this->db->trans_complete();

        return $insertId;
    }

    /**
     * This function used to get customer requirement and information by customer id
     * @param number $custId : This is customer id
     * @return array $result : This is rquirement result
     */
    function getCustomerWithRequirement($custId)
    {
        $this->db->select('BaseTbl.cust_id, BaseTbl.domain_name, BaseTbl.create_date, BaseTbl.expiry_date,
            BaseTbl.domain_registrar_name,BaseTbl.registrant_name,BaseTbl.registrant_company,
            BaseTbl.registrant_address,BaseTbl.registrant_city,BaseTbl.registrant_state,
            BaseTbl.registrant_zip,BaseTbl.registrant_country,BaseTbl.registrant_email,
            BaseTbl.registrant_phone,BaseTbl.registrant_alt_email,BaseTbl.registrant_alt_phone,
            BaseTbl.registrant_fax, BaseTbl.scr_img_mobile, BaseTbl.scr_img_desk, BaseTbl.status,
            REQ.rem_summary, REQ.interested_in, REQ.cust_cost, REQ.estimated_cost, REQ.conversion_cost');
        $this->db->from('fb_raw_cust as BaseTbl');
        $this->db->join('fb_cust_reqment as REQ', 'REQ.cust_id = BaseTbl.cust_id', "left");
        $this->db->where('BaseTbl.is_deleted', 0);
        $this->db->where('BaseTbl.cust_id', $custId);
        $query = $this->db->get();
        
        return $query->result();
    }
    
    /**
     * This function is used to get company list for dropdowns 
     */
    function getCompanyList()
    {
    	$this->db->select("BaseTbl.comp_id, BaseTbl.comp_name");
    	$this->db->from("fb_company AS BaseTbl");
    	$this->db->where("is_deleted", 0);
    	$query = $this->db->get();
    	return $query->result();
    }
    
    /**
     * This function is used to get attachment type list for dropdowns
     */
    function getTypeList()
    {
    	$this->db->select("BaseTbl.at_type_id, BaseTbl.at_type");
    	$this->db->from("fb_attach_type AS BaseTbl");
    	$query = $this->db->get();    	 
    	return $query->result();
    }
    
    
    /**
     * This function is used to get the customer listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function followCustomerListingCount($searchText = '', $executiveId = NULL, $toDate = NULL, $status)
    {
    	$this->db->select('CUST.cust_id');
    	$this->db->from('fb_cust_followup as BaseTbl');
    	$this->db->join('fb_raw_cust as CUST', 'CUST.cust_id = BaseTbl.cust_id');
    	$this->db->join('fb_fbtype as FBT', 'BaseTbl.fbt_id = FBT.fbt_id');
    	$this->db->join('tbl_users as USR', 'BaseTbl.currently_served_by = USR.userId');
    	if($executiveId != NULL) { $this->db->where('CUST.assigned_to', $executiveId); }
    	$this->db->where('CUST.is_deleted', 0);
    	if($status != 0) { $this->db->where('CUST.status', $status); }
    	$this->db->where('CUST.assigned_to !=', 0);
    	$this->db->where('BaseTbl.is_deleted', 0);
    	$this->db->where('BaseTbl.fp_status', 1);
    	$this->db->where('BaseTbl.fp_type', "CALL");
    	
    	if($toDate == NULL || empty($toDate)){
    		$this->db->where ("DATE_FORMAT(BaseTbl.fp_next_call,'%Y-%m-%d') <= ", date('Y-m-d'));
    	}
    	else{
    		$this->db->where ("DATE_FORMAT(BaseTbl.fp_next_call,'%Y-%m-%d') <= ", $toDate);
    	}
    	
    	if(!empty($searchText))
    	{
    		$this->db->like('CUST.domain_name', $searchText);
    		$this->db->or_like('CUST.registrant_city', $searchText);
    		$this->db->or_like('CUST.registrant_country', $searchText);
    	}
    	$this->db->order_by ("BaseTbl.fp_next_call");
    	$query = $this->db->get();
    
    	return count($query->result());
    }
    
    /**
     * This function is used to get the customer listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function followCustomerListing($searchText = '', $executiveId = NULL, $toDate = NULL, $status, $page, $segment)
    {
    	$this->db->select('CUST.cust_id, CUST.domain_name, CUST.registrant_name, CUST.registrant_company,
            CUST.registrant_phone, CUST.registrant_email, CUST.status,
    		DATE_FORMAT(BaseTbl.fp_dtm,"%d-%b-%Y %h:%i %p") as fp_dtm,
    		BaseTbl.fp_summary, BaseTbl.fbt_id,    		
    		DATE_FORMAT(BaseTbl.fp_next_call,"%d-%b-%Y %h:%i %p") as fp_next_call,
    		BaseTbl.fbt_id, FBT.fbt_name, BaseTbl.currently_served_by, USR.name',false);
    	$this->db->from('fb_cust_followup as BaseTbl');
    	$this->db->join('fb_raw_cust as CUST', 'CUST.cust_id = BaseTbl.cust_id');
    	$this->db->join('fb_fbtype as FBT', 'BaseTbl.fbt_id = FBT.fbt_id');
    	$this->db->join('tbl_users as USR', 'BaseTbl.currently_served_by = USR.userId');
    	if($executiveId != NULL) { $this->db->where('CUST.assigned_to', $executiveId); }
    	$this->db->where('CUST.is_deleted', 0);
    	if($status != 0) { $this->db->where('CUST.status', $status); }
    	$this->db->where('CUST.assigned_to !=', 0);
    	$this->db->where('BaseTbl.is_deleted', 0);
    	$this->db->where('BaseTbl.fp_status', 1);
    	$this->db->where('BaseTbl.fp_type', "CALL");
    	$this->db->order_by('BaseTbl.fp_next_call', "ASC");
    	if($toDate == NULL || empty($toDate)){
    		$this->db->where ("DATE_FORMAT(BaseTbl.fp_next_call,'%Y-%m-%d') <= ", date('Y-m-d'));
    	}
    	else{
    		$this->db->where ("DATE_FORMAT(BaseTbl.fp_next_call,'%Y-%m-%d') <= ", $toDate);
    	}
    	if(!empty($searchText))
    	{
    		$this->db->like('CUST.domain_name', $searchText);
    		$this->db->or_like('CUST.registrant_city', $searchText);
    		$this->db->or_like('CUST.registrant_country', $searchText);
    	}
    	$this->db->order_by ("BaseTbl.fp_next_call");
    	$this->db->limit($page, $segment);
    	$query = $this->db->get();
    
    	return $query->result();
    }
    
    /**
     * This function is used to get employee list
     */
    function getEmployeesList()
    {
    	$this->db->select("userId, name");
    	$this->db->where("isDeleted", 0);
    	$this->db->where("roleId", ROLE_EMPLOYEE);
    	$this->db->order_by("name");
    	$query = $this->db->get("tbl_users");
    	
    	return $query->result();
    }
    
    /**
     * This function used to change the status automatically by customer id
     * @param number $custId
     */
    function changeStatus($custId){
    	$this->db->set("status", PROCESSED);
    	$this->db->where("cust_id", $custId);
    	$this->db->where("status", RAW);
    	$this->db->update("fb_raw_cust");
    }


    function makeQuery()
    {
        $order_column = ['fbt_name', 'fp_next_call', 'fp_summary'];
        $this->db->select("FBType.fbt_name, BaseTbl.fp_next_call, BaseTbl.fp_summary");
        $this->db->from('fb_cust_followup as BaseTbl');
        $this->db->join('fb_fbtype as FBType', 'FBType.fbt_id = BaseTbl.fbt_id', "left");
        if(isset($_POST['search']['value'])){
            $this->db->like("FBType.fbt_name", $_POST['search']['value']);
            // $this->db->or_like("last_name", $_POST['search']['value']);
        }

        if(isset($_POST["order"])){
            $this->db->order_by($order_column[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
        }
        else {
            $this->db->order_by("BaseTbl.fp_id", "DESC");
        }
    }

    function makeFollowupDataTable()
    {
        $this->makeQuery();

        if($_POST["length"] != -1){
            $this->db->limit($_POST["length"], $_POST["start"]);
            // $this->db->limit(5, $_POST["start"]);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function getFilteredData() {
        $this->makeQuery();
        $query = $this->db->get();

        return $query->num_rows();

    }

    function getFollowupCount(){
        $table = 'fb_cust_followup';
        $this->db->select("*");
        $this->db->from($table);
        return $this->db->count_all_results();
    }
}