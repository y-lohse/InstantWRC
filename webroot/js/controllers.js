InstantWRC.controller('RankingController', function(){
});
counter = 0;
InstantWRC.controller('RallyController', function($scope, $http, Rally){
	$scope.showStage = false;
	$scope.firstStage = '';
	
	$scope.fetchData = function(){
		counter++;
		Rally.get({rallyId: $scope.rally_id}, function(data){
			$scope.times = data.times.slice(0, counter);
			$scope.stagename = data.stagename;
			
			//plusieurs spéciales concurentes?
			$scope.firstStage = $scope.times[0].last_stage;
			for (var i = 1, l = $scope.times.length; i < l; i++){
				if (!$scope.times[i].retired && $scope.times[i].last_stage != $scope.firstStage){
					$scope.showStage = true;
					break;
				}
			}
		});
	};
	
	$scope.fetchData();
});

InstantWRC.controller('StagesController', function($scope, $http, Rally){
	$scope.fetchData = function(){
		Rally.stages({rallyId: $scope.rally_id}, function(data){
			$scope.stages = data.stages;
		});
	};
	
	$scope.fetchData();
});

InstantWRC.controller('StageController', function($scope, $http, $routeParams, Stage){
	$scope.fetchData = function(){
		Stage.get({stageId: $routeParams.stageId}, function(data){
			$scope.times = data.times;
			$scope.stagename = data.stagename;
		});
	};
	
	$scope.fetchData();
});