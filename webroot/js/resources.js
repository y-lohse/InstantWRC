angular.module('InstantWrcBackend', ['ngResource']).
factory('RallyBackend', function($resource){
	return $resource(
		'/rally/:rallyId.json',
		{},
		{'stages': {method: 'GET', url: '/rally/stages/:rallyId.json'}}
	);
}).
factory('StageBackend', function($resource){
	return $resource(
		'/stage/:stageId.json'
	);
});