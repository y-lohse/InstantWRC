<?php
class Stage extends AppModel{
	public $useTable = 'stage';
	public $alias = 'Stage';
	public $primaryKey = 'stage_id';
	
	//crée une nouvelle spéciale
	public function createStage($name, $distance, $order, $scheduled, $status, $rally){
		$this->create();
		$this->set('stage_name', $name);
		$this->set('stage_distance', $distance);
		$this->set('stage_order', $order);
		$this->set('stage_scheduled', $scheduled->format(DATETIME_SQL));
		$this->set('stage_updated', DboSource::expression('UTC_TIMESTAMP()'));
		$this->set('stage_status', $status);
		$this->set('fk_rally_id', $rally);
		return $this->save();
	}
	
	//mis a jour dustatus d'une spéciale
	public function updateStatus($stage_id, $status){
		$this->id = $stage_id;
		$this->set('stage_status', $status);
		$this->set('stage_updated', DboSource::expression('UTC_TIMESTAMP()'));
		$this->save();
	}
	
	//met a jout uniquement le champs update
	//ca arrive quand un pilote viens de finir une spéciale
	public function updateUpdate($stage_id){
		$this->id = $stage_id;
		$this->set('stage_updated', DboSource::expression('UTC_TIMESTAMP()'));
		$this->save();
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
						'stage_status'=>'status');
		
		$conditions = array('fk_rally_id'=>$rally_id);
		$order = array('stage_order');
		
		$params= array('fields'=>$this->fieldsAs($fields),
						'conditions'=>$conditions,
						'order'=>$order);
		return $this->find('all', $params);
	}
}
?>