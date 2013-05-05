<?php
class UpdateController extends AppController {
	public $uses = array('Rally', 'Stage', 'Driver', 'Overall', 'StageTime');
	
	public function events(){
		$this->autoRender = false;
		header("Content-Type: text/event-stream; charset=utf-8");
		header('Cache-Control: no-cache');
		
		while (true){
			echo 'data: text';
			echo "\n\n";
			ob_flush();
			flush();
			sleep(2);
		}
	}
	
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
		
		//@TODO : récupérer lesspéciales par ordre de passage
		$stages = $this->Stage->findAllByFkRallyId($rally_id);
		foreach ($stages as $count=>$stage){
			if ($stage['Stage']['stage_status'] == RALLy_STATUS_UPCOMING){
				//cette spéciale n'a pas commencé, donc les suivantes non plus, donc on arrete la
				break;
			}
			else if ($stage['Stage']['stage_status'] == RALLy_STATUS_CANCELLED){
				//spéciale annulée, on passe à la suivante sans s'occuper de celle la
				continue;
			}
			else if ($stage['Stage']['stage_status'] == RALLy_STATUS_COMPLETED){
				if ($this->Driver->countStageTimes($stage['Stage']['stage_id']) === 0){
					//spéciale terminée, mais les résultats n'ont pas encore été chargés
					$this->update($rally_id, $stage['Stage']['stage_id'], $stage['Stage']['stage_order'], $wrcInterface);
				}
				else if ($count > 0){
					//la spéciale est terminé,e on a déja des temps
					//c'est le moment de détecter das abandons
					
					//on recupere la derniere spéciale a s'etre terminée
					$index = $count-1;
					$prev_stage_id = NULL;
					do {
						$prev_stage = $stages[$index];
						if ($prev_stage['Stage']['stage_status'] == RALLy_STATUS_COMPLETED){
							$prev_stage_id = $prev_stage['Stage']['stage_id'];
							break;
						}
					}
					while (--$index >= 0);
					
					if ($prev_stage_id != NULL){//sinon c'est qu'il n'y a pas eu de spéciale avant
						$retirements = $this->Driver->computeRetirements($stage['Stage']['stage_id'], $prev_stage_id);
						$this->Overall->retire($rally_id, $retirements);
					}
				}
			}
			else if ($stage['Stage']['stage_status'] == RALLy_STATUS_RUNNING){
				//spéciale en cours
				//on décide s'ilfaut lancer une maj globale ou pas
				$now = new DateTime();
				$updated = new DateTime($stage['Stage']['stage_updated']);
				$updateDiff = $updated->diff($now);
				
				if ($updateDiff->h >= 0 && $updateDiff->i >= STAGE_UPDATE_DELAY){
					$this->update($rally_id, $stage['Stage']['stage_id'], $stage['Stage']['stage_order'], $wrcInterface);
				}
			}
		}
		
		exit();
	}
	
	private function initStages($rally_id, $wrcInterface){
		//est-ce que l'on a fais le setup?
		$setup = ($this->Stage->countStages($rally_id) > 0) ? true : false;
		
		if (!$setup){
			//le setup n'a pas été fait, on le fais maintenant
			//création des spéciales dans la bdd
			$timezone = $this->Rally->getTimezone($rally_id);
			$stages = $wrcInterface->getStages($timezone);
			
			foreach ($stages as $index=>$stage){
				$this->Stage->createStage($stage['name'], $stage['distance'], $index+1, $stage['scheduled'], $stage['status'], $rally_id);
			}
		}
		else{
			$stages = $this->Stage->findAllByFkRallyId($rally_id);
			
			//le setup a été fait, faut il mettre à jour la liste des spéciales?
			$needsUpdate = false;
			$now = new DateTime();
			
			foreach ($stages as $stage){
				if ($stage['Stage']['stage_status'] == RALLy_STATUS_UPCOMING){
					$schedule = new DateTime($stage['Stage']['stage_scheduled']);
					$diff = $schedule->diff($now);
					
					if ($diff->invert === 0){
						//la spéciale est théoriquement commencée,
						//mais en BDD elle est toujours annoncé comme à venir
						$updated = new DateTime($stage['Stage']['stage_updated']);
						$updateDiff = $updated->diff($now);
						
						if ($updateDiff->i >= STAGELIST_UPDATE_DELAY){
							//ca fais plus de STAGELIST_UPDATE_DELAY minutes que l'on a pas
							//maj la liste des spéciales, on le fais maintenant
							$needsUpdate = true;
							break;//et comme on les met toutes à jourpas besoin d'aller plus loin.
						}
					}	
				}	
			}
				
			if ($needsUpdate){
				//mise à jour des spéciales
				$timezone = $this->Rally->getTimezone($rally_id);
				$liveStages = $wrcInterface->getStages($timezone);
				
				foreach ($liveStages as $index=>$stage){
					//normalement l'odre dans $liveSTages et $stages est identique, mais au cas ou...
					if ($stage['name'] != $stages[$index]['Stage']['stage_name']){
						//@TODO : faire quelque chose, c'estinquietant.
					}
					else{
						//on nefais la MAJ que si le statu a changé,
						//mais peut etre qu'on pourrait le faire systématiquement, au cas ou
						//autre chose change
						if ($stage['status'] != $stages[$index]['Stage']['stage_status']){
							$this->Stage->updateStatus($stages[$index]['Stage']['stage_id'], $stage['status']);
						}
					}
				}
			}
		}
	}
	
	private function update($rally_id, $stage_id, $stage_num, $wrcInterface){
		$times = $wrcInterface->getStage($stage_num);
		
		$this->updateOverall($rally_id, $times['overall']);
		$hasChanged = $this->updateStage($times['stage'], $stage_id);
		
		if ($hasChanged){
			$this->Stage->updateUpdate($stage_id);
		}
	}
	
	private function updateOverall($rally_id, $times){
		foreach ($times as $time){
			//verifie si le piltoe exite déja dans la bdd
			$exists = $this->Driver->findByDriverName($time['driver']);
			if (count($exists) === 0){
				//il faut créer le pilote
				$driver = $this->Driver->registerDriver($time['driver']);
				$driver_id = $driver['Driver']['driver_id'];
			}
			else {
				$driver_id = $exists['Driver']['driver_id'];
			}
			
			//verifie si lepilote est enregistré comme participant au rallye
			$overall = $this->Overall->findByFkDriverId($driver_id);
			if (count($overall) === 0){
				//crée l'overall
				$this->Overall->registerTime($driver_id, $rally_id, $time['time']);
			}
			else if ($overall['Overall']['overall_time'] != $time['time']){
				//maj de l'overall
				$this->Overall->updateOverall($driver_id, $rally_id, $time['time']);
			}
		}
	}
	
	private function updateStage($times, $stage_id){
		$hasChanged = false;
		
		foreach ($times as $time){
			$driver = $this->Driver->findByDriverName($time['driver']);
			$driver_id = $driver['Driver']['driver_id'];
			
			//verifie si on a déja enregistré le chrono de ce pilote/spéciale
			$exists = $this->StageTime->isRegistered($driver_id, $stage_id);
			if ($exists == 0){
				//pas enregistré pour cette course, on le crée
				$this->StageTime->registerTime($driver_id, $stage_id, $time['time']);
				$hasChanged = true;
			}
		}
		
		return $hasChanged;
	}
}
?>