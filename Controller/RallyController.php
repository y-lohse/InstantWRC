<?php
class RallyController extends AppController {
	public $uses = array('Stage', 'Overall', 'StageTime');
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		//$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($rally_id){
		$rally_id = (int)$rally_id;
		
		$rawTimes = $this->Overall->getOverALlTimes($rally_id);
		$times = array();
		foreach ($rawTimes as $time){
			array_push($times, array('driver'=>$time['Driver']['name'],
									 'time'=>$time['Overall']['time'],
									 'retired'=>(bool)$time['Overall']['retired'],
									 'last_stage'=>$time[0]['last_stage_id']));
		}
		//debug($times);
		usort($times, array($this, 'sortTimes'));
	
		$this->set('times', $times);
		$this->set('_serialize', array('times'));
	}
	
	//classement parchrno
	private function sortTimes($a, $b){
		//comapraison par élmination
		if ($a['retired'] != $b['retired']){
			return ($a['retired']) ?1 : -1;
		}
		
		//comparaison au temps
		if (strlen($a['time']) === strlen($b['time'])){
			return ($a['time'] > $b['time']) ? 1 : -1;
		}
		else{
			return (strlen($a['time']) > strlen($b['time'])) ? 1 : -1;
		}
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