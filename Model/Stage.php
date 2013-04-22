<?php
class Stage extends AppModel{
	public $useTable = 'stage';
	public $alias = 'Stage';
	public $primaryKey = 'stage_id';
	
	public function countStages($rally_id){
		$conditions = array('fk_rally_id'=>$rally_id);
	
		$params= array('conditions'=>$conditions);
		return $this->find('count', $params);
	}
	
	public function getStages($rally_id){
		$fields = array('stage_id'=>'id',
						'stage_name'=>'name',
						'stage_distance'=>'distance');
		$conditions = array('fk_rally_id'=>$rally_id);
		
		$params= array('fields'=>$this->fieldsAs($fields),
						'conditions'=>$conditions);
		return $this->find('all', $params);
	}
}
?>