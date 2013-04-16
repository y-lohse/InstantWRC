<?php
class RallysController extends AppController {
	public $components = array('RequestHandler');
	
	public function beforeFilter(){
		$this->RequestHandler->renderAs($this, 'json');
	}
	
	public function index(){
	}
}
?>