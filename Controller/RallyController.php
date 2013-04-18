<?php
class RallyController extends AppController {
	public $uses = array('Stage');
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function view($id){
		$id = (int)$id;
		
		$times = array();
		array_push($times, array('driver'=>'S. Loeb', 'time'=>'01:34.5'));
		array_push($times, array('driver'=>'S. Ogier', 'time'=>'01:36.5'));
		
		$rawStages = $this->Stage->getSTages($id);
		$stages= array();
		foreach ($rawStages as $stage){
			array_push($stages, $stage['Stage']);
		}
	
		$this->set('times', $times);
		$this->set('stages', $stages);
		$this->set('_serialize', array('times', 'stages'));
	}
}
?>