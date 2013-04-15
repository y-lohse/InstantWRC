<?php
class RallysController extends AppController {
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function index(){
		$rallys = array();
		
		for ($i = 0; $i < 5; $i++){
			$rally = 'Simple Rally';
			array_push($rallys, $rally);
		}
		
		$this->set('rallys', $rallys);
		$this->set('_serialize', array('rallys'));
	}
	
	public function view($id){
		$this->set('rallys', array('name'));
		$this->set('_serialize', array('rallys'));
	}
	
}
?>