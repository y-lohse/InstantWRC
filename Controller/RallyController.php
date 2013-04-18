<?php
class RallyController extends AppController {
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($id){
		$times = array();
		array_push($times, array('driver'=>'S. Loeb', 'time'=>'01:34.5'));
		array_push($times, array('driver'=>'S. Ogier', 'time'=>'01:36.5'));
		
		$stages = array();
		array_push($stages, array('id'=>1, 'name'=>'SS 1', 'distance'=>'14,22km'));
		array_push($stages, array('id'=>2, 'name'=>'SS 2', 'distance'=>'18,34km'));
	
		$this->set('times', $times);
		$this->set('stages', $stages);
		$this->set('_serialize', array('times', 'stages'));
	}
}
?>