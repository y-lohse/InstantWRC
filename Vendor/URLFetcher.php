<?php

class URLFetcher{
	
	public static function getFile($url, $timeout = 5){
		$timeout = (int)$timeout;
		
		ini_set('max_execution_time', $timeout+1);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_ENCODING,'utf-8');
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$ua = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);
		
		$content = curl_exec($ch);
			
		if ($content === false){
			$content = '';
			
			//@TODO :faire quelque chose
			echo 'Erreur cURL : '.curl_error($ch);
		}
		
		curl_close($ch);
		
		return $content;
	}
}