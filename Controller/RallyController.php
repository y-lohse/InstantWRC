<?php
class RallyController extends AppController {
	public $uses = array('Stage', 'Overall', 'StageTime', 'Rally');
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function running(){
		$running = $this->Rally->getRunningRally(new DateTime());
		if (count($running) > 0){
			$this->set('id', $running['Rally']['id']);
			$this->set('name', $running['Rally']['name']);
		}
		else
			$this->set('id', NULL);
		
		$this->set('_serialize', array('id', 'name'));
	}
	
	public function view($rally_id){
		$rally_id = (int)$rally_id;
		App::import('Vendor', 'WrcTime');
		
		$rawTimes = $this->Rally->getOverAllTimes($rally_id);
		
		$times = array();
		foreach ($rawTimes as $time){	
			array_push($times, array('driver'=>$time['Driver']['name'],
									 'timestamp'=>WrcTime::toTimestamp($time['StageTime']['time']),
									 //'retired'=>(bool)$time['Overall']['retired'],
									 'retired'=>false,
									 'last_stage'=>$time['MaxStage']['last_stage_id']));
		}
		
		usort($times, array($this, 'sortTimes'));
		
		$best = $previous = $times[0]['timestamp'];
		
		foreach ($times as $index=>&$time){
			if ($time['retired']) continue;
			
			$time['rank'] = $index+1;
			$time['best'] = WrcTime::toTimestring($time['timestamp'] - $best);
			$time['previous'] = WrcTime::toTimestring($time['timestamp'] - $previous);
			$previous = $time['timestamp'];
		}
		
		//récupération du nom de la dernire spéciale
		$stage = $this->Stage->findByStageId($times[0]['last_stage']);
		
		$this->set('times', $times);
		$this->set('stagename', $stage['Stage']['stage_name']);
		$this->set('_serialize', array('times'));
	}
	
	//classement des pilotes par différents critères
	private function sortTimes($a, $b){
		//comapraison par élmination
		if ($a['retired'] != $b['retired']){
			return ($a['retired']) ? 1 : -1;
		}
		
		//par derniere spéciale terminée
		if ($a['last_stage'] != $b['last_stage']){
			return ($a['last_stage'] < $b['last_stage']) ? 1 : -1;
		}
		
		//comparaison au temps
		return ($a['timestamp'] > $b['timestamp']) ? 1 : -1;
	}
	
	public function stages($stage_id){
		$stage_id = (int)$stage_id;
		$stage = $this->Stage->findByStageId($stage_id);
		
		//récupération de la timezone
		$rally_id = $stage['Stage']['fk_rally_id'];
		$timezone = $this->Rally->getTimezone($rally_id);
		
		$rawStages = $this->Stage->getStages($stage_id);
		$stages= array();
		foreach ($rawStages as &$stage){
			$scheduled = new DateTime($stage['Stage']['scheduled']);
			$scheduled->setTimezone(new DateTimeZone($timezone));
			$stage['Stage']['scheduled'] = $scheduled->format('H:i');
			
			array_push($stages, $stage['Stage']);
		}
		
		$this->set('stages', $stages);
		$this->set('_serialize', array('stages'));
	}
}
?>