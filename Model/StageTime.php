<?php
class StageTime extends AppModel{
	public $useTable = 'stage_time';
	public $alias = 'StageTime';
	
	public function registerTime($driver_id, $stage_id, $time){
		$this->create();
		$this->set('fk_driver_id', $driver_id);
		$this->set('fk_stage_id', $stage_id);
		$this->set('stage_time_time', $time);
		
		return $this->save();
	}
}
?>