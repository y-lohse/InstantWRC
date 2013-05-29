<?php
class Overall extends AppModel{
	public $useTable = 'overall';
	public $alias = 'Overall';
	
	public function registerTime($driver_id, $rally_id, $time){
		$this->create();
		$this->set('fk_driver_id', $driver_id);
		$this->set('fk_rally_id', $rally_id);
		$this->set('overall_time', $time);
		$this->save();
	}
	
	public function retire($rally_id, $drivers){
		$fields = array('overall_retired'=>true);
		$conditions = array();
		$conditions['fk_rally_id'] = $rally_id;
		$conditions['fk_driver_id'] = $drivers;
		$this->updateAll($fields, $conditions);
	}
	
	public function updateOverall($driver_id, $rally_id, $time){
		App::uses('Sanitize', 'Utility');
		$fields = array('overall_time'=>"'".Sanitize::escape($time)."'");
		$conditions = array();
		$conditions['fk_driver_id'] = $driver_id;
		$conditions['fk_rally_id'] = $rally_id;
		
		$this->updateALl($fields,$conditions);
	}
}
?>