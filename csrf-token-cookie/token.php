<?php
session_start();
$_SESSION["username"] = "SASITHA";
class token {	
	public static function generateToken(){

		$arr = array("session_id"=>session_id());
		$session_id = json_encode($arr);
		$url = 'http://localhost:5000/csrf';//call pyhton back-end genrate csrf token and return 
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");	
		curl_setopt($ch, CURLOPT_POSTFIELDS, $session_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json'                                                                     
		));                                                                                                                   			
        curl_setopt($ch, CURLOPT_HEADER, true);
		$curlResponse = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($curlResponse, $header_size);
        $result = json_decode($body, true);
		curl_close($ch);
		$cookie_name = 'csrf_token';
		$cookie_value = $result['token'];
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/") ;// set csrf token save cookie
		
		
	}//genarate token
}
?>