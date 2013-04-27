<?php
class Stage extends AppModel{
	public $useTable = 'stage';
	public $alias = 'Stage';
	public $primaryKey = 'stage_id';
	
	public function createStage($name, $distance, $order, $scheduled, $status, $rally){
		$now = new DateTime();
		
		$this->create();
		$this->set('stage_name', $name);
		$this->set('stage_distance', $distance);
		$this->set('stage_order', $order);
		$this->set('stage_scheduled', $scheduled->format(DATETIME_SQL));
		$this->set('stage_updated', $now->format(DATETIME_SQL));
		$this->set('stage_status', $status);
		$this->set('fk_rally_id', $rally);
		return $this->save();
	}
	
	public function countStages($rally_id){
		$conditions = array('fk_rally_id'=>$rally_id);
	
		$params= array('conditions'=>$conditions);
		return $this->find('count', $params);
	}
	
	public function getStages($rally_id){
		$fields = array('stage_id'=>'id',
						'stage_name'=>'name',
						'stage_distance'=>'distance',
						'stage_scheduled'=>'scheduled',
						'stage_status'=>'status',
						'stage_order'=>'order');
		$conditions = array('fk_rally_id'=>$rally_id);
		
		$params= array('fields'=>$this->fieldsAs($fields),
						'conditions'=>$conditions);
		return $this->find('all', $params);
	}
}
?>