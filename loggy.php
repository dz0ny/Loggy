<?php
/*
Plugin Name: Loggy
Description: Loggy is simple express server for remote logging with REST API and Wordpress plugin.
Author: Janez Troha
Version: 1.1s
Author URI: http://github.com/dz0ny/Loggy

(The MIT License)

Copyright (c) 2011 Janez Troha <janez.troha@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the 'Software'), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

class Loggy {
	
	//CHANGE THIS
	var $secret_key = "test";

	//HOSTNAME AND PORT OF YOUR LOGGY SERVER
	var $loggy_server = "localhost:3000";

	//default expiration for debug requests (default one hour)
	var $default_expiration = 3600;

	//send new line on one session(page refresh)
	var $new_line_on_refresh = true;
	  
	function Loggy()
	{
		global $_GET;
		$this->server = $this->loggy_server;  

		if ((bool)$_GET["Loggy"] && is_admin()) {
			if ($_GET["Loggy"] == $this->secret_key) {
				set_transient("Loggy", $this->loggy_server, $expiration);
				$this->info("PING :)");
				die("Secret successfully set! Check your Loggy at http://".$this->loggy_server.", for debug messages. Loggy will stop sending messanges after ".(int)$this->default_expiration." seconds.");
			}else{
				$this->info("PONG :(");
				delete_transient("Loggy");
				die("Loggy successfully deactivated!");
			}
		}
	}
	
	/**
	 * Info function only sends message
	 *
	 * @return void
	 * @author Janez Troha
	 **/
	function info($mes)
	{
		$this->send(__FUNCTION__, false, $mes);
	}
	/**
	 * Debug function, also sends trace date
	 *
	 * @return void
	 * @author Janez Troha
	 **/
	function debug($mes)
	{
		$this->send(__FUNCTION__, debug_backtrace(false), $mes);
	}
	/**
	 * Sends specific request to specific server, if get request contains loggy
	 *
	 * @return bool
	 * @author Janez Troha
	 **/
	private function send($type, $trace, $mes)
	{

		if (false !== get_transient('Loggy') ) {

			if ($this->new_line_on_refresh) {
				$this->new_line_on_refresh = false;
				$this->send("info", false, "--MARK--");
			}

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
