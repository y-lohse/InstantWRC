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
									 'time'=>$time['Overall']['time']));
		}
	
		$this->set('times', $times);
		$this->set('_serialize', array('times'));
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