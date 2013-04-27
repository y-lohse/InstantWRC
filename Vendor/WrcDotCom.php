<?php

App::import('Vendor', 'URLFetcher');

class WrcDotCom{
	
	private $baseUrl;
	const STAGE_SEGMENT = '/stage-times/?category=wrc&stageno=';
	const STAGE_LIST_SEGMENT = '/itinerary/';
	
	public function __construct($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getStages($timezone){
// 		$url = $this->baseUrl.$this::STAGE_LIST_SEGMENT;
// 		$page = URLFetcher::getFile($url);
		
// 		//isole le body
// 		$start = strpos($page, '<body');
// 		$end = strrpos($page, '</body>');
// 		$domstr = substr($page, $start, $end+7);
		
// 		//recupere le tableau de stpéciales
// 		$dom = DOMDocument::loadHTML($domstr);
// 		$tables = $dom->getElementsByTagName('table');
// 		$resultTable = NULL;
		
// 		foreach ($tables as $tableNode){
// 			if ((string)$tableNode->getAttribute('class') === 'results'){
// 				$resultTable = $tableNode;
// 				break;
// 			}
// 		}
		
// 		//isole les spéciales
// 		$lines = $tableNode->childNodes;
// 		$stageList = array();
// 		$currentDay = NULL;
		
// 		foreach ($lines as $index=>$line){
// 			if ($index < 1) continue;//onzappe la premiere ligne
			
// 			if ($line->getAttribute('class') == 'leg'){
// 				$currentDay = $line->childNodes->item(0)->nodeValue;
// 				$currentDay = substr($currentDay, strpos($currentDay, '-')+2);
// 			}
// 			else{
// 				$line->setAttribute('day', $currentDay);
// 				array_push($stageList, $line);
// 			}
// 		}
		
// 		//convertis les spéciales en tableaux
// 		$stages = array();
// 		foreach ($stageList as $stageNode){
// 			$infos = $stageNode->childNodes;
			
// 			$name = $infos->item(0)->nodeValue.' '.$infos->item(1)->nodeValue;
// 			$km = $infos->item(2)->nodeValue;
// 			$passage = $stageNode->getAttribute('day').' '.$infos->item(3)->nodeValue;
			
// 			switch ($infos->item(4)->nodeValue){
// 				case 'COMPLETED':
// 					$status = RALLy_STATUS_COMPLETED;
// 					break;
// 				case 'CANCELLED':
// 					$status = RALLy_STATUS_CANCELLED;
// 					break;
// 				default:
// 					$status = RALLy_STATUS_UPCOMING;
// 					break;
// 			}
			
// 			//création dela date de début avec le fuseau horaire local
// 			$schedule = new DateTime($passage, new DateTimeZone($timezone));
// 			//conversion au fuseau du serveur
// 			$schedule->setTimezone(new DateTimeZone(date_default_timezone_get()));
			
// 			$stage = array( 'name'=>$name,
// 							'distance'=>$km,
// 							'scheduled'=>$schedule,
// 							'status'=>$status);
// 			array_push($stages, $stage);
// 		}
		$stages = array();
		$stages[] = array( 'name'=>'LE MOULINON - ANTRAIGUES 1',
 							'distance'=>'37.10',
 							'scheduled'=>new DateTime('27 Apr 13 15:00'),
 							'status'=>1);
		$stages[] = array( 'name'=>'BURZET - ST MARTIAL 1',
							'distance'=>'30.60',
							'scheduled'=>new DateTime('27 Apr 13 17:00'),
							'status'=>0);
		
		return $stages;
	}
	
	//récupere et analyse une page de stage
	//renvois un tableau contenant les résultas overall et spéciale
	public function getStage($num){
		$url = $this->baseUrl.$this::STAGE_SEGMENT.$num;
		$page = URLFetcher::getFile($url);
		
		//isole le body
		$start = strpos($page, '<body');
		$end = strrpos($page, '</body>');
		$domstr = substr($page, $start, $end+7);
		
		//recupere les tableaux
		$dom = DOMDocument::loadHTML($domstr);
		$tables = $dom->getElementsByTagName('table');
		
		$stageTable = NULL;
		$overallTable = NULL;
		
		foreach ($tables as $index=>$tableNode){
			if ((string)$tableNode->getAttribute('class') === 'results'){
				if ($index == 1) $stageTable = $tableNode;
				else if ($index == 2) $overallTable = $tableNode;
			}
		}
		
		//isole les temps de la spéciale
		$lines = $stageTable->childNodes;
		$timeList = array();
		foreach ($lines as $index=>$line){
			if ($index < 1) continue;
			array_push($timeList, $line);
		}
		
		//convertis les temps de spéciale en tableau
		$stageTimes = array();
		foreach ($timeList as $timeNode){
			$infos = $timeNode->childNodes;
	
			$position = $infos->item(0)->nodeValue;
			$driver = $infos->item(2)->nodeValue;
			$time = $infos->item(3)->nodeValue;
	
			$time = array( 'driver'=>$driver,
							'position'=>$position,
							'time'=>$time);
			array_push($stageTimes, $time);
		}
		
		//isole les temps généraux
		$lines = $overallTable->childNodes;
		$overallList = array();
		foreach ($lines as $index=>$line){
			if ($index < 1) continue;
			array_push($overallList, $line);
		}
		
		//convertis les temps en tableau
		$overallTimes = array();
		foreach ($overallList as $timeNode){
			$infos = $timeNode->childNodes;
		
			$position = $infos->item(0)->nodeValue;
			$driver = $infos->item(2)->nodeValue;
			$time = $infos->item(4)->nodeValue;
		
			$time = array( 'driver'=>$driver,
					'position'=>$position,
					'time'=>$time);
			array_push($overallTimes, $time);
		}
		
		return array('stage'=>$stageTimes, 'overall'=>$overallTimes);
	}
	
}