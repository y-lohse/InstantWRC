InstantWRC.controller('RankingController', function(){
});

InstantWRC.controller('RallyController', function($scope, $http){
	$http.get('/rally/'+$scope.rally_id+'.json').success(function(data){
		$scope.times = data.times;
		$scope.stagename = data.stagename;

		$scope.showStage = false;
		var firstStage = $scope.times[0].last_stage;
		for (var i = 1, l = $scope.times.length; i < l; i++){
			if ($scope.times[i].last_stage != firstStage){
				$scope.showStage = true;
				break;
			}
		}
	});
});

InstantWRC.controller('StagesController', function($scope, $http){
	$http.get('/rally/stages/'+$scope.rally_id+'.json').success(function(data){
		$scope.stages = data.stages;
	});
});

InstantWRC.controller('StageController', function($scope, $http, $routeParams){
	$http.get('/stage/'+$routeParams.stageId+'.json').success(function(data){
		$scope.times = data.times;
	});
});