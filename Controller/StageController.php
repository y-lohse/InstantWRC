<?php
class StageController extends AppController {
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($id){
		$times = array();
		array_push($times, array('driver'=>'S. Loeb', 'time'=>'00:34.5'));
		array_push($times, array('driver'=>'S. Ogier', 'time'=>'00:36.5'));
	
		$this->set('times', $times);
		$this->set('_serialize', array('times'));
	}
}
?>