angular.module('RallyService', ['ngResource']).
factory('Rally', function($resource){
	return $resource(
		'/rally/:rallyId.json'
	);
});