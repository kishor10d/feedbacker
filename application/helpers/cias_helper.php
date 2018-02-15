<?php
function pre($data) {
	echo "<pre>";
	print_r ( $data );
	echo "</pre>";
}
function setProtocol() {
	$CI = &get_instance ();
	
	$CI->load->library ( 'email' );
	
	$config ['protocol'] = PROTOCOL;
	$config ['mailpath'] = MAIL_PATH;
	$config ['smtp_host'] = SMTP_HOST;
	$config ['smtp_port'] = SMTP_PORT;
	$config ['smtp_user'] = EMAIL_FROM;
	$config ['smtp_pass'] = EMAIL_PASS;
	$config ['charset'] = "utf-8";
	$config ['mailtype'] = "html";
	$config ['newline'] = "\r\n";
	
	$CI->email->initialize ( $config );
	
	return $CI;
}
function setDynamicProtocol($user, $pass) {
	$CI = &get_instance ();
	
	$CI->load->library ( 'email' );
	
	$config ['protocol'] = PROTOCOL;
	$config ['mailpath'] = MAIL_PATH;
	$config ['smtp_host'] = SMTP_HOST;
	$config ['smtp_port'] = SMTP_PORT;
	$config ['smtp_user'] = $user;
	$config ['smtp_pass'] = $pass;
	$config ['charset'] = "utf-8";
	$config ['mailtype'] = "html";
	$config ['newline'] = "\r\n";
	
	$CI->email->initialize ( $config );
	
	return $CI;
}

if (! function_exists ( 'emailDemoFile' )) {
	function emailDemoFile($to, $file_path) {
		$data ["data"] = array ();
		
		$CI = setProtocol ();
		$CI->email->from ( EMAIL_FROM, FROM_NAME );
		$CI->email->to ( $to );
		$CI->email->subject ( DEMO_SUBJECT );
		$CI->email->message ( $CI->load->view ( 'email/userguide', $data, TRUE ) );
		$CI->email->attach ( $file_path );
		
		if ($CI->email->send ()) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * This function is used to generate the GUID
 * 
 * @return {string} $guid : This is global unique identifier
 */
if (! function_exists ( 'getGUID' )) {
	function getGUID() {
		if (function_exists ( 'com_create_guid' )) {
			return trim ( com_create_guid (), '{}' );
		} else {
			mt_srand ( ( double ) microtime () * 10000 ); // optional for php 4.2.0 and up.
			$charid = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
			$hyphen = chr ( 45 ); // "-"
			$uuid = chr ( 123 ) . // "{"
substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 ) . chr ( 125 ); // "}"
			return trim ( $uuid, '{}' );
		}
	}
}

if (! function_exists ( 'emailPortfolio' )) {
	function emailPortfolio($to, $subject, $html, $companyCredentials, $companyAttachment, $extraAttachment) {
		$data ["html"] = $html;
		
		if (! empty ( $companyCredentials )) {
			$user = $companyCredentials [0]->comp_email;
			$pass = $companyCredentials [0]->comp_pass;
			
			$CI = setDynamicProtocol ( $user, $pass );
			
			$CI->email->from ( $user, "Support" );
			$CI->email->to ( $to );
			$CI->email->subject ( $subject );
			$CI->email->message ( $CI->load->view ( 'email/emailWrapper', $data, TRUE ) );
			if (! empty ( $companyAttachment )) {
				$file_path = base_url () . ATTACHMENT_PATH . $companyAttachment [0]->at_path;
				$CI->email->attach ( $file_path );
			}
			if (! empty ( $extraAttachment )) {
				$attach_path = base_url () . ATTACHMENT_PATH . $extraAttachment;
				$CI->email->attach ( $attach_path );
			}
			
			if ($CI->email->send ()) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        
        $CI = setProtocol();        
        
        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

?>