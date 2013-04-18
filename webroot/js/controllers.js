function RankingCtrl($scope, $routeParams) {
}

function RallyCtrl($scope, $http, $routeParams){
	$http.get('/rally.json').success(function(data){
		$scope.stages = data;
	});
}

function StageCtrl($scope, $routeParams) {
}

function ForecastCtrl($scope, $routeParams) {
}