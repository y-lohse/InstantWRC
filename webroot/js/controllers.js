InstantWRC.controller('RankingController', function(){
});

InstantWRC.controller('RallyController', function($scope, $http){
	$http.get('/rally/1.json').success(function(data){
		$scope.stages = data.stages;
		$scope.times = data.times;
	});
});

InstantWRC.controller('StageController', function(){
});

InstantWRC.controller('ForecastController', function(){
});