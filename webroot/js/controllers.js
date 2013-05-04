InstantWRC.controller('RankingController', function(){
});

InstantWRC.controller('RallyController', function($scope, $http, Rally){
	$scope.showStage = false;
	$scope.firstStage = '';
	
	$scope.fetchData = function(){
		Rally.getTimes(function(times){
			$scope.times = times;
			
			$scope.firstStage = $scope.times[0].last_stage;
			for (var i = 1, l = $scope.times.length; i < l; i++){
				if (!$scope.times[i].retired && $scope.times[i].last_stage != $scope.firstStage){
					$scope.showStage = true;
					break;
				}
			}
			
			if ($scope.showStage){
				Rally.getStageName(function(stageName){
					$scope.stagename = stageName;
				});
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