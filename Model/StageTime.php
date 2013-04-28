<?php
class StageTime extends AppModel{
	public $useTable = 'stage_time';
	public $alias = 'StageTime';
	
	public function isRegistered($driver_id, $stage_id){
		$conditions = array('fk_driver_id'=>$driver_id,
							 'fk_stage_id'=>$stage_id);
		return $this->find('count', array('conditions'=>$conditions));
	}
	
	public function registerTime($driver_id, $stage_id, $time){
		$this->create();
		$this->set('fk_driver_id', $driver_id);
		$this->set('fk_stage_id', $stage_id);
		$this->set('stage_time_time', $time);
		
		return $this->save();
	}
	
	public function getStageTimes($stage_id){
		$fields = array('Driver.driver_name'=>'name',
						'StageTime.stage_time_time'=>'time');
	
		$joins = array(
				array(
						'table'=>'driver',
						'alias'=>'Driver',
						'type'=>'LEFT',
						'conditions'=>array(
								'Driver.driver_id = '.$this->alias.'.fk_driver_id'
						))
		);
	
		$conditions = array('StageTime.fk_stage_id'=>$stage_id);
	
		$params = array('fields'=>$this->fieldsAs($fields),
						'joins'=>$joins,
						'conditions'=>$conditions);
		return $this->find('all', $params);
	}
}
?>