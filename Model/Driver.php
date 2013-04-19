<?php
class Driver extends AppModel{
	public $useTable = 'driver';
	public $alias = 'Driver';
	public $primaryKey = 'driver_id';
	
	public function getOverALlTimes($rally_id){
		$fields = array('Driver.driver_name'=>'name',
						'Overall.overall_time'=>'time');
		
		$joins = array(
				array(
						'table'=>'overall',
						'alias'=>'Overall',
						'type'=>'LEFT',
						'conditions'=>array(
								'Overall.fk_driver_id = '.$this->alias.'.'.$this->primaryKey
						))
		);
		
		$conditions = array('Overall.fk_rally_id'=>$rally_id);
		
		$params = array('fields'=>$this->fieldsAs($fields),
						'joins'=>$joins,
						'conditions'=>$conditions);
		return $this->find('all', $params);
	}
}
?>