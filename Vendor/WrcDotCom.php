<?php

App::import('Vendor', 'URLFetcher');

class WrcDotCom{
	
	private $baseUrl;
	const STAGE_SEGMENT = '/stage-times/?category=wrc&stageno=';
	const STAGE_LIST_SEGMENT = '/itinerary/';
	
	public function __construct($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getStages(){
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
// 		foreach ($lines as $index=>$line){
// 			if ($index < 2) continue;
			
// 			if ($line->getAttribute('class') != 'leg'){
// 				array_push($stageList, $line);
// 			}
// 		}
		
// 		//convertis les spéciales en tableaux
// 		$stages = array();
// 		foreach ($stageList as $stageNode){
// 			$infos = $stageNode->childNodes;
			
// 			$name = $infos->item(0)->nodeValue.' '.$infos->item(1)->nodeValue;
// 			$km = $infos->item(2)->nodeValue;
// 			$passage = $infos->item(3)->nodeValue;
// 			$statut = $infos->item(4)->nodeValue;
			
// 			$stage = array( 'name'=>$name,
// 							'distance'=>$km,
// 							'scheduled'=>$passage,
// 							'status'=>$statut);
// 			array_push($stages, $stage);
// 		}

		$stages = array();
		array_push($stages, array('name'=>'SS1 LE MOULINON - ANTRAIGUES 1',
								'distance'=>'37.10',
								'scheduled'=>'09:03',
								'status'=>'COMPLETED'
						));
		array_push($stages, array('name'=>'SS2 BURZET - ST MARTIAL 1',
				'distance'=>'30.60',
				'scheduled'=>'10:21',
				'status'=>'COMPLETED'
		));
		
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
	}
	
}