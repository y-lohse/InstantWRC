<?php
class Rally extends AppModel{
	public $useTable = 'rally';
	public $alias = 'Rally';
	public $primaryKey = 'rally_id';
	
	public function getTimezone($rally_id){
		$fields = array('Rally.rally_timezone'=>'timezone');
		$conditions = array('Rally.rally_id'=>$rally_id);
		
		$params = array('fields'=>$this->fieldsAs($fields),
						'conditions'=>$conditions);
		$result = $this->find('first', $params);
		return $result['Rally']['timezone'];
	}
	
	public function getRunningRally($when){
		$fields = array('Rally.rally_id'=>'id',
						'Rally.rally_name'=>'name',
						'Rally.rally_url'=>'url');
		
		$conditions = array('Rally.rally_start <='=>$when->format(DATETIME_SQL),
							 'Rally.rally_end >='=>$when->format(DATETIME_SQL));
		
		$params = array('fields'=>$this->fieldsAs($fields),
						'conditions'=>$conditions);
		return $this->find('first', $params);
	}
}
?>