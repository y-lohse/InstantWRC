<?php

class WrcTime{
	
	public static function toTimestamp($time){
		//conversion du chrono en timestamp (en dizieme de secondes)
		$splitted = preg_split('/[:.]/', $time);
		$timestamp = 0;
		$splitted = array_reverse($splitted);
			
		if (count($splitted) === 4) $timestamp += $splitted[3]*60*60*10;
		if (count($splitted) >= 3) $timestamp += $splitted[2]*60*10;
		$timestamp += $splitted[1]*10 + $splitted[0];
		
		return $timestamp;
	}
	
	public static function toTimestring($timestamp){
		//conversion inverse
		$hourconversion = (60*60*10);//une heure en dizieme de secondes
		$minuteconversion = (60*10);
		
		$heures = floor($timestamp / $hourconversion);
		$minutes = floor(($timestamp % $hourconversion) / $minuteconversion);
		$secs = floor(($timestamp % $hourconversion) % $minuteconversion / 10);
		$reste = ($timestamp % $hourconversion) % $minuteconversion % 10;
		
		$str = '';
		if ($heures > 0) $str .= abs($heures).':';
		if ($minutes > 0) $str .= abs($minutes).':';
		$str .= abs($secs).'.'.abs($reste);
		
		//symbole
		$str = ($timestamp < 0) ? '-'.$str : '+'.$str;
		
		return $str;
	}
	
}