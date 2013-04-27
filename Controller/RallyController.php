<?php
class RallyController extends AppController {
	public $uses = array('Stage', 'Driver');
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($id){
		$id = (int)$id;
		
		$rawTimes = $this->Driver->getOverALlTimes($id);
		$times = array();
		foreach ($rawTimes as $time){
			array_push($times, array('driver'=>$time['Driver']['name'],
									  'time'=>$time['Overall']['time']));
		}
	
		$this->set('times', $times);
		$this->set('_serialize', array('times'));
	}
}
?>