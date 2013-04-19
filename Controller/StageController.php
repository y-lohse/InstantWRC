<?php
class StageController extends AppController {
	public $uses = array('Driver');
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($id){
		$rawTimes = $this->Driver->getStageTimes($id);
		$times = array();
		
		foreach ($rawTimes as $time){
			array_push($times, array('driver'=>$time['Driver']['name'],
									  'time'=>$time['StageTime']['time']));
		}
	
		$this->set('times', $times);
		$this->set('_serialize', array('times'));
	}
}
?>