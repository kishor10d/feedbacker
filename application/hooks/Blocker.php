<?php

class Blocker {
	
	function Blocker(){
	}
	
	/**
	 * This function used to block the every request except allowed ip address
	 */
	function requestBlocker(){
		
		if($_SERVER["REMOTE_ADDR"] != "49.248.51.230"){
			echo "not allowed";
			die;
		}
	}
}