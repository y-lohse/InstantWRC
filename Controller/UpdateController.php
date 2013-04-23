<?php
class UpdateController extends AppController {
	public $uses = array('Rally', 'Stage');
	
	//point d'entrée pour les MAJ
	public function index(){
		//on regarde si un rally est en cours
		$running = $this->Rally->getRunningRally(new DateTime());
		if (count($running) === 0) exit();//aucun rally en cours
		
		//on a le rally en cours
		//est-ce que l'on a fais le setup?
		$setup = ($this->Stage->countStages($running['Rally']['id']) > 0) ?true : false; 
		
		App::import('Vendor', 'WrcDotCom');
		$wrcInterface = new WrcDotCom($running['Rally']['url']);
		
		//setup du rally
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
				
				$this->Stage->createStage($stage['name'], $stage['distance'], $index+1, $status, $running['Rally']['id']);
			}
		}
		
		
	}
}
?>