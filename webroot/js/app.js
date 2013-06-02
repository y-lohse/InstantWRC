<<<<<<< HEAD
var InstantWRC = angular.module('InstantWRC', ['directives']);
InstantWRC.run(function($http, $location, $rootScope){
=======
var InstantWRC = angular.module('InstantWRC', ['directives', 'Models']);
InstantWRC.run(function($http, $location, $rootScope, Rally){
	var requiredPath = $location.path();
	
>>>>>>> origin/master
	$http.get('/rally/running.json').success(function(data){
		if (data.id){
			Rally.id = data.id;
			Rally.name = $rootScope.rally_name = data.name;
			
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