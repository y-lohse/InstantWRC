InstantWRC.controller('RankingController', function(){
});

InstantWRC.controller('RallyController', function($scope, $http){
	$http.get('/rally/'+$scope.rally_id+'.json').success(function(data){
		$scope.times = data.times;
	});
});

InstantWRC.controller('StagesController', function($scope, $http){
	$http.get('/rally/stages/'+$scope.rally_id+'.json').success(function(data){
		$scope.stages = data.stages;
		
		for (var i = 0; i < $scope.stages.length; i++){
			var cssClass;
			
			switch (parseInt($scope.stages[i].status)){
				case 2:
					cssClass = 'stage_finished';
					break;
				case 1:
					cssClass = 'stage_running';
					break;
				case 0:
				default:
					cssClass = 'stage_later';
					break;
			}
			console.log(cssClass);
			$scope.stages[i].cssClass = cssClass;
		}
	});
});

InstantWRC.controller('StageController', function($scope, $http, $routeParams){
	$http.get('/stage/'+$routeParams.stageId+'.json').success(function(data){
		$scope.times = data.times;
	});
});