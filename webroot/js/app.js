var InstantWRC = angular.module('InstantWRC', ['directives']);
InstantWRC.run(function($http, $location, $rootScope){
	var requiredPath = $location.path();
	
	$http.get('/rally/running.json').success(function(data){
		if (data.id){
			$rootScope.rally_id = data.id;
			$rootScope.rally_name = data.name;
			
			if (requiredPath == '/') requiredPath = '/rally';
			$location.path(requiredPath);
		}
	});
	
	$location.path('/ranking');
});
InstantWRC.config(['$routeProvider', function($routeProvider) {
	$routeProvider.
	when('/home', {
		templateUrl: '/index/home', 
		controller: 'HomeController'
	}).
	when('/ranking', {
		templateUrl: '/index/ranking', 
		controller: 'RankingController'
	}).
	when('/rally', {
		templateUrl: '/index/rally', 
		controller: 'RallyController'
	}).
	when('/stages', {
		templateUrl: '/index/stages', 
		controller: 'StagesController'
	}).
	when('/stage/:stageId', {
		templateUrl: '/index/stage', 
		controller: 'StageController'
	});
}]);