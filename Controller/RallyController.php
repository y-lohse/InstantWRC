<?php
class RallyController extends AppController {
	public $uses = array('Stage', 'Overall', 'StageTime');
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		//$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($rally_id){
		$rally_id = (int)$rally_id;
		App::import('Vendor', 'WrcTime');
		
		$rawTimes = $this->Overall->getOverALlTimes($rally_id);
		$times = array();
		foreach ($rawTimes as $time){	
			array_push($times, array('driver'=>$time['Driver']['name'],
									 'timestamp'=>WrcTime::toTimestamp($time['Overall']['time']),
									 'retired'=>(bool)$time['Overall']['retired'],
									 'last_stage'=>$time[0]['last_stage_id']));
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
	
		$this->set('times', $times);
		$this->set('_serialize', array('times'));
	}
	
	//classement des pilotes par différents critères
	private function sortTimes($a, $b){
		//comapraison par élmination
		if ($a['retired'] != $b['retired']){
			return ($a['retired']) ? 1 : -1;
		}
		
		//comparaison au temps
		return ($a['timestamp'] > $b['timestamp']) ? 1 : -1;
	}
	
	public function stages($id){
		$rawStages = $this->Stage->getSTages($id);
		$stages= array();
		foreach ($rawStages as $stage){
			array_push($stages, $stage['Stage']);
		}
		
		$this->set('stages', $stages);
		$this->set('_serialize', array('stages'));
	}
}
?>