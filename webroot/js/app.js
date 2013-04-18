var InstantWRC = angular.module('InstantWRC', []).
config(['$routeProvider', function($routeProvider) {
	$routeProvider.
	when('/ranking', {
		templateUrl: '/index/ranking', 
		controller: RankingCtrl
	}).
	when('/rally', {
		templateUrl: '/index/rally', 
		controller: RallyCtrl
	}).
	when('/stage', {
		templateUrl: '/index/stage', 
		controller: StageCtrl
	}).
	when('/forecast', {
		templateUrl: '/index/forecast', 
		controller: ForecastCtrl
	}).
	otherwise({redirectTo: '/rally'});
}]);