<?php
class RallyController extends AppController {
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function index(){
		$speciales = array();
		array_push($speciales, array('name'=>'lol', 'distance'=>'14,22km'));
		array_push($speciales, array('name'=>'blop', 'distance'=>'18,34km'));
		
		$this->set('stages', $speciales);
		$this->set('_serialize', 'stages');
	}
}
?>