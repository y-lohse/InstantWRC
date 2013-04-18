function RankingCtrl($scope, $routeParams) {
}

function RallyCtrl($scope, $http, $routeParams){
	$http.get('/rally.json').success(function(data){
		$scope.stages = data;
	});
	
	$scope.addStage = function(){
		$scope.stages.push({'name':'new', 'distance':'50km'});
	}
}

function StageCtrl($scope, $routeParams) {
}

function ForecastCtrl($scope, $routeParams) {
}