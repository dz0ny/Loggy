<?php
/*
Plugin Name: Loggy
Description: PHP+NODE.js logger 
Author: Janez Troha
Version: 1.0
Author URI: http://www.dz0ny.info
*/

class Loggy {
	
	var $secret_key = "test";

	function Loggy()
	{
		global $_GET;
		$this->server = "localhost:3000";  
		$this->new_line_on_refesh = true;  

		if ($_GET["Loggy"] == $this->secret_key) {
			setcookie(md5($this->secret_key), 1, time()+3600, SITECOOKIEPATH, COOKIE_DOMAIN, false, true);
		}
	}
	
	/**
	 * Info function
	 *
	 * @return void
	 * @author Janez Troha
	 **/
	function info($mes)
	{
		$trace=false;
		if ($this->new_line_on_refesh) {
			$this->send(__FUNCTION__, $trace, "--MARK--");
			$this->new_line_on_refesh = false;
		}
		$this->send(__FUNCTION__, $trace, $mes);
	}
	/**
	 * Debug function
	 *
	 * @return void
	 * @author Janez Troha
	 **/
	function debug($mes)
	{
		$trace=debug_backtrace(false);
		if ($this->new_line_on_refesh) {
			$this->send(__FUNCTION__, $trace, "--MARK--");
			$this->new_line_on_refesh = false;
		}
		$this->send(__FUNCTION__, $trace, $mes);
	}
	/**
	 * Sends specific request to specific server, if get request contains loggy
	 *
	 * @return bool
	 * @author Janez Troha
	 **/
	private function send($type, $trace, $mes)
	{
		global $_COOKIE;

		if ((bool)$_COOKIE[md5($this->secret_key)]) {
			$url = "http://".$this->server."/1/".$type;
			$timeout = 10;
			
			$options = array();
			$options['timeout'] = $timeout;
			if (is_array($mes) || is_object($mes)) {
				$mes = json_encode($mes);
			}
			if (!$trace) {
				$trace = array("type"=>$type);
			}
			$options['body'] = "stack=".urlencode(json_encode($trace))."&info=".urlencode($mes);
			
			$response = wp_remote_post( $url, $options );

			return is_wp_error( $response );
		}
	}
}
add_action("init", "LoggyInit");
function LoggyInit() {
    global $Loggy; $Loggy = new Loggy();
}
