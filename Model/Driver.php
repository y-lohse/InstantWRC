<?php
class Driver extends AppModel{
	public $useTable = 'driver';
	public $alias = 'Driver';
	public $primaryKey = 'driver_id';
	
	public function registerDriver($name){
		$this->create();
		$this->set('driver_name', $name);
		return $this->save();
	}
	
	//calcule les abandons entre 2 spéciales
	public function computeRetirements($current_stage, $previous_stage){
		$fields = array('Driver.driver_id'=>'id');
		
		$joins = array(
				array(
						'table'=>'stage_time',
						'alias'=>'Stage',
						'type'=>'LEFT',
						'conditions'=>array(
								'Stage.fk_driver_id = '.$this->alias.'.'.$this->primaryKey,
								'Stage.fk_stage_id = '.$current_stage
						)),
				array(
						'table'=>'stage_time',
						'alias'=>'PreviousStage',
						'type'=>'LEFT',
						'conditions'=>array(
								'PreviousStage.fk_driver_id = '.$this->alias.'.'.$this->primaryKey
						)),
		);
		
		$conditions = array();
		$conditions['PreviousStage.fk_stage_id'] = $previous_stage;
		$conditions['Stage.fk_driver_id'] = NULL;
		
		$group = array('Driver.driver_id');
		
		$params = array('fields'=>$this->fieldsAs($fields),
						'joins'=>$joins,
						'conditions'=>$conditions,
						'group'=>$group);
		$results = $this->find('all', $params);
		$retirees = array();
		
		foreach ($results as $result){
			array_push($retirees, $result['Driver']['id']);
		}
		
		return $retirees;
	}
	
	public function countStageTimes($stage_id){
		$joins = array(
				array(
						'table'=>'stage_time',
						'alias'=>'StageTime',
						'type'=>'LEFT',
						'conditions'=>array(
								'StageTime.fk_driver_id = '.$this->alias.'.'.$this->primaryKey
						))
		);
	
		$conditions = array('StageTime.fk_stage_id'=>$stage_id);
	
		$params = array('joins'=>$joins,
						'conditions'=>$conditions);
		return $this->find('count', $params);
	}
}
?>