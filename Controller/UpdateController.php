<?php
class UpdateController extends AppController {
	public $uses = array('Rally', 'Stage');
	
	//point d'entrée pour les MAJ
	public function index(){
		//on regarde si un rally est en cours
		$running = $this->Rally->getRunningRally(new DateTime());
		if (count($running) === 0) exit();//aucun rally en cours
		
		//on a le rally en cours
		$rally_id = $running['Rally']['id'];
		
		App::import('Vendor', 'WrcDotCom');
		$wrcInterface = new WrcDotCom($running['Rally']['url']);
		
		//création ou mAJ de la liste des spéciales
		$this->initStages($rally_id, $wrcInterface);
		
		$stages = $this->Stage->getStages($rally_id);
	}
	
	private function initStages($rally_id, $wrcInterface){
		//est-ce que l'on a fais le setup?
		$setup = ($this->Stage->countStages($rally_id) > 0) ? true : false;
		
		if (!$setup){
			//le setup n'a pas été fait, on le fais maintenant
			//création des spéciales dans la bdd
			$stages = $wrcInterface->getStages();
				
			foreach ($stages as $index=>$stage){
				switch ($stage['status']){
					case 'COMPLETED':
						$status = RALLy_STATUS_COMPLETED;
						break;
					case 'CANCELLED':
						$status = RALLy_STATUS_CANCELLED;
						break;
					default:
						$status = RALLy_STATUS_UPCOMING;
						break;
				}
		
				$this->Stage->createStage($stage['name'], $stage['distance'], $index+1, $status, $rally_id);
			}
		}
		else{
			//le setup a été fait, faut il mettre à jour la liste des spéciales?
			//@TODO : décider s'il faut ou non faire la mise à jour
			$needsUpdate = false;
				
			if ($needsUpdate){
				//@TODO : faire la mise à jour
			}
		}
	}
}
?>