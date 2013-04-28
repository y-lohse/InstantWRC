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
	
	public function getOverALlTimes($rally_id){
		$fields = array('Driver.driver_name'=>'name',
						'Driver.driver_id'=>'id',
						'Overall.overall_time'=>'time',
						'Overall.overall_retired'=>'retired',
						'MAX(StageTime.fk_stage_id)'=>'last_stage_id');
	
		$joins = array(
				array(
						'table'=>'driver',
						'alias'=>'Driver',
						'type'=>'LEFT',
						'conditions'=>array(
								'Driver.driver_id = '.$this->alias.'.fk_driver_id'
						)),
				array(
						'table'=>'stage',
						'alias'=>'Stage',
						'type'=>'LEFT',
						'conditions'=>array(
								'Stage.fk_rally_id = '.$this->alias.'.fk_rally_id'
						)),
				array(
						'table'=>'stage_time',
						'alias'=>'StageTime',
						'type'=>'LEFT',
						'conditions'=>array(
								'StageTime.fk_driver_id = '.$this->alias.'.fk_driver_id',
								'StageTime.fk_stage_id = Stage.stage_id',
						))
		);
	
		$conditions = array('Overall.fk_rally_id'=>$rally_id);
		$group = array('Driver.driver_id');
	
		$params = array('fields'=>$this->fieldsAs($fields),
						'joins'=>$joins,
						'conditions'=>$conditions,
						'group'=>$group);
		return $this->find('all', $params);
	}
}
?>