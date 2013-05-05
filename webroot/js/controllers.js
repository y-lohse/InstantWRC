InstantWRC.controller('RankingController', function(){
});

InstantWRC.controller('RallyController', function($scope, $http, Rally){
	$scope.showStage = false;
	$scope.firstStage = '';
	$scope.Rally = Rally;
	
	$scope.fetchData = function(){
		Rally.refreshRally().then(angular.bind(this, function(){
			$scope.firstStage = Rally.times[0].last_stage;
			for (var i = 1, l = Rally.times.length; i < l; i++){
				if (!Rally.times[i].retired && Rally.times[i].last_stage != $scope.firstStage){
					$scope.showStage = true;
					break;
				}
			}
		}));
	};
	
	$scope.fetchData();
});

InstantWRC.controller('StagesController', function($scope, $http, Rally){
	$scope.Rally = Rally;
	
	$scope.fetchData = function(){
		Rally.refreshStages();
	};
	
	$scope.fetchData();
});

InstantWRC.controller('StageController', function($scope, $http, $routeParams, Stage){
	Stage.id = $routeParams.stageId;
	Stage.getStageName(function(stageName){
		$scope.stagename = stageName;
	});
	
	$scope.fetchData = function(){
		Stage.getTimes(function(times){
			$scope.times = times;
		});
	};
	
	$scope.fetchData();
});