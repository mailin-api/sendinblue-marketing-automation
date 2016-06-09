<?php
	class Sendinblue
	{
		public $api_key;
		public $base_url;
		public $curl_opts = array();
		public function __construct($api_key)
		{
		    if(!function_exists('curl_init'))
		    {
		        throw new Exception('Sendinblue requires CURL module');
		    }
		    $this->base_url = 'https://in-automate.sendinblue.com/p';
		    $this->api_key = $api_key;
		    //create a session cookie
		    if (!array_key_exists('session_id',$_COOKIE)) {		    	
				$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$parsed = parse_url($url);
				$host_parts = explode('.', $parsed['host']);
				$domain = implode('.', array_slice($host_parts, count($host_parts)-2));
		    	//store email_id cookie
		    	setcookie("session_id",$_COOKIE['session_id'] = md5(uniqid(time())),time() + 86400,"/",$domain);
		    }
		    
		}
		/**
		 * Do CURL request with authorization
		 */
		 
		private function do_request($input)
		{
		    $input['key'] = $this->api_key;
		    $input = http_build_query($input);
		    $ch = curl_init($this->base_url."?".$input);
		    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		        // Windows only over-ride
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    }
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_HEADER, 0);
		    $data = curl_exec($ch);
		    if(curl_errno($ch))
		    {
		        echo 'Curl error: ' . curl_error($ch). '\n';
		    }
		    curl_close($ch);
		    return json_decode($data,true);
		}
        public function identify($data)
        {
        	$data['sib_type'] = 'identify';

        	if (!array_key_exists('name',$data)) {
        		$data['name'] = "Contact Created";
        	}
			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	if (!array_key_exists('url',$data)) {
        		$data['url'] = $url;
        	}
        	if (isset($_COOKIE['session_id']) && $_COOKIE['session_id'] != '') {
		    	$data['session_id'] = $_COOKIE['session_id'];        	
        	}
			$parsed = parse_url($url);
			$host_parts = explode('.', $parsed['host']);
			$domain = implode('.', array_slice($host_parts, count($host_parts)-2));
        	//store email_id cookie
        	setcookie("email_id",$_COOKIE['email_id'] = $data['email_id'],time() + 86400,"/",$domain);
            return $this->do_request($data);
        }
        
        public function track($data)
        {
        	$data['sib_type'] = 'track';
			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	if (!array_key_exists('url',$data)) {
        		$data['url'] = $url;
        	}

        	if (!array_key_exists('sib_name',$data)) {
        		if (array_key_exists('name',$data)) {
        			$data['sib_name'] = $data['name'];
        		}
        	}
        	
        	//get email cookie
        	
        	if (isset($_COOKIE['email_id']) && $_COOKIE['email_id'] != '') {
		    	$data['email_id'] = $_COOKIE['email_id'];        	
        	}
        	if (isset($_COOKIE['session_id']) && $_COOKIE['session_id'] != '') {
		    	$data['session_id'] = $_COOKIE['session_id'];        	
        	}
        	
        	//store email cookie
			$obj = $this->do_request($data);        	
			if (isset($obj['email_id']) && $obj['email_id'] != '') {
				$parsed = parse_url($url);
				$host_parts = explode('.', $parsed['host']);
				$domain = implode('.', array_slice($host_parts, count($host_parts)-2));
		    	//store email_id cookie
		    	setcookie("email_id",$_COOKIE['email_id'] = $obj['email_id'],time() + 86400,"/",$domain);        	
			}
        }
        public function page($data)
        {
        	$data['sib_type'] = 'page';
			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	if (!array_key_exists('url',$data)) {
        		$data['url'] = $url;
        	}
        	//get email cookie
        	if (isset($_COOKIE['email_id']) && $_COOKIE['email_id'] != '') {
		    	$data['email_id'] = $_COOKIE['email_id'];        	
        	}
        	if (isset($_COOKIE['session_id']) && $_COOKIE['session_id'] != '') {
		    	$data['session_id'] = $_COOKIE['session_id'];        	
        	}
        	//referrer
        	if (!array_key_exists('referrer',$data) && array_key_exists('HTTP_REFERER',$_SERVER)) {
        		$data['referrer'] = $_SERVER['HTTP_REFERER'];
        	}
        	//pathname
        	if (!array_key_exists('pathname',$data)) {
        		$data['pathname'] = $_SERVER['REQUEST_URI'];
        	}
        	
        	//name
        	if (!array_key_exists('name',$data)) {
        		$data['name'] = $_SERVER['REQUEST_URI'];
        	}
        	
        	//store email cookie
			$obj = $this->do_request($data);        	
			if (isset($obj['email_id']) && $obj['email_id'] != '') {
				$parsed = parse_url($url);
				$host_parts = explode('.', $parsed['host']);
				$domain = implode('.', array_slice($host_parts, count($host_parts)-2));
		    	//store email_id cookie
		    	setcookie("email_id",$_COOKIE['email_id'] = $obj['email_id'],time() + 86400,"/",$domain);        	
			}
        }
        public function trackLink($data)
        {
        	$data['sib_type'] = 'trackLink';
        	//get email cookie
        	if (isset($_COOKIE['email_id']) && $_COOKIE['email_id'] != '') {
		    	$data['email_id'] = $_COOKIE['email_id'];        	
        	}
        	if (isset($_COOKIE['session_id']) && $_COOKIE['session_id'] != '') {
		    	$data['session_id'] = $_COOKIE['session_id'];        	
        	}
			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        	if (!array_key_exists('url',$data)) {
        		$data['url'] = $url;
        	}
        	//store email cookie
			$obj = $this->do_request($data);        	
			if (isset($obj['email_id']) && $obj['email_id'] != '') {
				$parsed = parse_url($url);
				$host_parts = explode('.', $parsed['host']);
				$domain = implode('.', array_slice($host_parts, count($host_parts)-2));
		    	//store email_id cookie
		    	setcookie("email_id",$_COOKIE['email_id'] = $obj['email_id'],time() + 86400,"/",$domain);        	
			}
        }
	}
?>
