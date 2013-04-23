<?php

App::import('Vendor', 'URLFetcher');

class WrcDotCom{
	
	private $baseUrl;
	const STAGE_SEGMENT = '/stage-times/?category=wrc&stageno=';
	const STAGE_LIST_SEGENT = '/itinerary/';
	
	public function __construct($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getStages(){
// 		$url = $this->baseUrl.$this::STAGE_LIST_SEGENT;
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
	public function getStage($num){
		
	}
	
}