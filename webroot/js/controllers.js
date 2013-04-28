InstantWRC.controller('RankingController', function(){
});

InstantWRC.controller('RallyController', function($scope, $http){
	$http.get('/rally/'+$scope.rally_id+'.json').success(function(data){
		$scope.times = data.times;
	});
});

InstantWRC.controller('StagesController', function($scope, $http){
	$http.get('/rally/1.json').success(function(data){
		$scope.stages = data.stages;
	});
});

InstantWRC.controller('StageController', function($scope, $http, $routeParams){
	$http.get('/stage/'+$routeParams.stageId+'.json').success(function(data){
		$scope.times = data.times;
	});
});