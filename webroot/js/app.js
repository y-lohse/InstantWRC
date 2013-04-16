angular.module('instantwrc', []).
config(['$routeProvider', function($routeProvider) {
	$routeProvider.
	when('/phones', {
		templateUrl: '/index/phonelist', 
		controller: PhoneListCtrl
	}).
	when('/phones/:phoneId', {
		templateUrl: '/index/details', 
		controller: PhoneDetailCtrl
	}).
	otherwise({redirectTo: '/phones'});
}]);