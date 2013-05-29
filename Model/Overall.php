<?php
class Overall extends AppModel{
	public $useTable = 'overall';
	public $alias = 'Overall';
	
	public function register($driver_id, $rally_id){
		$this->create();
		$this->set('fk_driver_id', $driver_id);
		$this->set('fk_rally_id', $rally_id);
		$this->save();
	}
	
	public function retire($rally_id, $drivers){
		$fields = array('overall_retired'=>true);
		$conditions = array();
		$conditions['fk_rally_id'] = $rally_id;
		$conditions['fk_driver_id'] = $drivers;
		$this->updateAll($fields, $conditions);
	}
}
?>