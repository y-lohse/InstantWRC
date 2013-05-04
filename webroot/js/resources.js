angular.module('WrcService', ['ngResource']).
factory('Rally', function($resource){
	return $resource(
		'/rally/:rallyId.json',
		{segment: ''},
		{stages: {method: 'GET', url: '/rally/stages/:rallyId.json'}}
	);
}).
factory('Stage', function($resource){
	return $resource(
		'/stage/:stageId.json'
	);
});