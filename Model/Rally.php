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
	
	public function getOverallTimes($rally_id){
/*

     SELECT driver.driver_name, driver.driver_id, stage_time.stage_time_overall, max_stage.stage
FROM rally AS rally
LEFT JOIN stage AS stage ON (stage.fk_rally_id = rally.rally_id)
LEFT JOIN (

SELECT MAX(stage_time.fk_stage_id) AS stage, stage_time.fk_driver_id
FROM stage_time
GROUP BY stage_time.fk_driver_id

) 
AS max_stage ON (max_stage.stage = stage.stage_id)
LEFT JOIN stage_time ON (stage_time.fk_stage_id = max_stage.stage AND stage_time.fk_driver_id = max_stage.fk_driver_id)
LEFT JOIN driver AS driver ON (driver.driver_id = max_stage.fk_driver_id)
WHERE max_stage.stage IS NOT NULL
GROUP BY max_stage.fk_driver_id
        */
        
        $fields = array('Driver.driver_name'=>'name',
						'Driver.driver_id'=>'id',
						'StageTime.stage_time_overall'=>'time',
						'Overall.overall_retired'=>'retired',
						'MaxStage.stage_id'=>'last_stage_id');
					
        //@TODO : faire la subquery en plus propre	
        $joins = array(
				array(
						'table'=>'stage',
						'alias'=>'Stage',
						'type'=>'LEFT',
						'conditions'=>array(
								'Stage.fk_rally_id = '.$this->alias.'.'.$this->primaryKey
						)),
				array(
						'table'=>'(SELECT MAX(stage_time.fk_stage_id) AS stage_id, stage_time.fk_driver_id as driver_id
                                    FROM stage_time
                                    GROUP BY stage_time.fk_driver_id)',
						'alias'=>'MaxStage',
						'type'=>'LEFT',
						'conditions'=>array(
								'MaxStage.stage_id = Stage.stage_id',
						)),
				array(
						'table'=>'stage_time',
						'alias'=>'StageTime',
						'type'=>'LEFT',
						'conditions'=>array(
								'StageTime.fk_stage_id = MaxStage.stage_id',
								'StageTime.fk_driver_id = MaxStage.driver_id'
						)),
                array(
						'table'=>'driver',
						'alias'=>'Driver',
						'type'=>'LEFT',
						'conditions'=>array(
								'Driver.driver_id = StageTime.fk_driver_id'
						)),
				array(
						'table'=>'overall',
						'alias'=>'Overall',
						'type'=>'LEFT',
						'conditions'=>array(
								'Overall.fk_driver_id = MaxStage.driver_id',
								'Overall.fk_rally_id = '.$this->alias.'.'.$this->primaryKey
						)),
		);
    
        $conditions = array();
        $conditions[$this->alias.'.'.$this->primaryKey] = $rally_id;
        $conditions['MaxStage.stage_id !='] = NULL;
        
		$group = array('MaxStage.driver_id');
	
		$params = array('fields'=>$this->fieldsAs($fields),
						'joins'=>$joins,
						'conditions'=>$conditions,
						'group'=>$group);
		return $this->find('all', $params);
    }
}
?>