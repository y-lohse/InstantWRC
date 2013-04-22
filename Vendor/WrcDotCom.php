<?php

App::import('Vendor', 'URLFetcher');

class WrcDotCom{
	
	private $baseUrl;
	const STAGE_SEGMENT = '/stage-times/?category=wrc&stageno=';
	const STAGE_LIST_SEGENT = '/itinerary/';
	
	public function __construct($baseUrl){
		$this->baseUrl = $baseUrl;
	}
	
	public function getStages(){
		/*$url = $this->baseUrl.$this::STAGE_LIST_SEGENT;
		$page = URLFetcher::getFile($url);
		
		//on isole la partie contenant les spéciales
		$start = strpos($page, '<table class="results">');
		$end = strpos($page, '</table>', $start);
		
		$stageTable = substr($page, $start, strlen($page)-$end);*/
		$stageTable = '<table class="results"><tr><th class="c0">Stage</th><th class="c1">Name</th><th class="c2">Distance (km)</th><th class="c3">First Car</th><th class="cz">&nbsp;</th></tr><tr class="leg"><td colspan="5">Day 1 - 16 Jan 13</td></tr><tr><td class="c0">SS1</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=1">LE MOULINON - ANTRAIGUES 1</a></td><td class="c2">37.10</td><td class="c3">09:03</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS2</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=2">BURZET - ST MARTIAL 1</a></td><td class="c2">30.60</td><td class="c3">10:21</td><td class="cz">COMPLETED</td></tr><tr><td class="c0">SS3</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=3">LE MOULINON - ANTRAIGUES 2</a></td><td class="c2">37.10</td><td class="c3">14:21</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS4</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=4">BURZET - ST MARTIAL 2</a></td><td class="c2">30.60</td><td class="c3">15:39</td><td class="cz">COMPLETED</td></tr><tr class="leg"><td colspan="5">Day 2 - 17 Jan 13</td></tr><tr><td class="c0">SS5</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=5">LABATIE D\'ANDAURE - LALOUVESC</a></td><td class="c2">19.08</td><td class="c3">09:33</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS6</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=6">ST BONNET - ST BONNET</a></td><td class="c2">25.45</td><td class="c3">10:14</td><td class="cz">COMPLETED</td></tr><tr><td class="c0">SS7</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=7">LAMASTRE - GILHOC - ALBOUSSIER</a></td><td class="c2">21.72</td><td class="c3">11:37</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS8</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=8">LABATIE D\'ANDAURE - LALOUVESC</a></td><td class="c2">19.08</td><td class="c3">14:50</td><td class="cz">COMPLETED</td></tr><tr><td class="c0">SS9</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=9">ST BONNET - ST BONNET</a></td><td class="c2">25.45</td><td class="c3">15:31</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS10</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=10">LAMASTRE - GILHOC - ALBOUSSIER</a></td><td class="c2">21.72</td><td class="c3">16:54</td><td class="cz">COMPLETED</td></tr><tr class="leg"><td colspan="5">Day 3 - 18 Jan 13</td></tr><tr><td class="c0">SS11</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=11">ST JEAN EN ROYANS - LA CIME DU</a></td><td class="c2">33.19</td><td class="c3">09:08</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS12</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=12">ST NAZAIRE LE DESERT - LA MOTT</a></td><td class="c2">22.11</td><td class="c3">13:31</td><td class="cz">COMPLETED</td></tr><tr><td class="c0">SS13</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=13">SISTERON - THOARD</a></td><td class="c2">36.70</td><td class="c3">15:29</td><td class="cz">COMPLETED</td></tr><tr class="leg"><td colspan="5">Day 4 - 19 Jan 13</td></tr><tr><td class="c0">SS14</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=14">MOULINET - LA BOLLENE VESUBIE</a></td><td class="c2">23.54</td><td class="c3">15:11</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS15</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=15">LANTOSQUE - LUCERAM 1</a></td><td class="c2">18.95</td><td class="c3">15:54</td><td class="cz">COMPLETED</td></tr><tr><td class="c0">SS16</td><td class="c1"><a href="results/2013/rallye-monte-carlo/stage-times/?stageno=16">MOULINET - LA BOLLENE VESUBIE</a></td><td class="c2">23.54</td><td class="c3">17:37</td><td class="cz">COMPLETED</td></tr><tr class="odd"><td class="c0">SS17</td><td class="c1">MOULINET - LA BOLLENE VESUBIE</td><td class="c2">23.54</td><td class="c3">21:23</td><td class="cz">CANCELLED</td></tr><tr><td class="c0">SS18</td><td class="c1">LANTOSQUE - LUCERAM 2</td><td class="c2">18.95</td><td class="c3">22:06</td><td class="cz">CANCELLED</td></tr></table></div>
</div>';
		debug($stageTable);
	}
	
	//récupere et analyse une page de stage
	public function getStage($num){
		
	}
	
}