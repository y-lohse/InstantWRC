var InstantWRC = angular.module('InstantWRC', []);
InstantWRC.config(['$routeProvider', function($routeProvider) {
	$routeProvider.
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
	}).
	when('/forecast', {
		templateUrl: '/index/forecast', 
		controller: 'ForecastController'
	}).
	otherwise({redirectTo: '/rally'});
}]);