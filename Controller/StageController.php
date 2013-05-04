<?php
class StageController extends AppController {
	public $uses = array('Stage', 'StageTime');
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($stage_id){
		$stage_id = (int)$stage_id;
		
		$rawTimes = $this->StageTime->getStageTimes($stage_id);
		$times = array();
		
		App::import('Vendor', 'WrcTime');
		
		foreach ($rawTimes as $time){
			array_push($times, array('driver'=>$time['Driver']['name'],
									  'timestamp'=>WrcTime::toTimestamp($time['StageTime']['time'])
			));
		}
	
		if (count($times) > 0){
			usort($times, array($this, 'sortTimes'));
			$best = $previous = $times[0]['timestamp'];
			
			foreach ($times as $index=>&$time){
				$time['rank'] = $index+1;
				$time['best'] = WrcTime::toTimestring($time['timestamp'] - $best);
				$time['previous'] = WrcTime::toTimestring($time['timestamp'] - $previous);
				$previous = $time['timestamp'];
			}	
		}
		
		//nom de la spéciale
		$stage = $this->Stage->findByStageId($stage_id);
		
		$this->set('times', $times);
		$this->set('stagename', $stage['Stage']['stage_name']);
		$this->set('_serialize', array('times', 'stagename'));
	}
	
	//classement des pilotes par chrono
	private function sortTimes($a, $b){
		return ($a['timestamp'] > $b['timestamp']) ? 1 : -1;
	}
}
?>