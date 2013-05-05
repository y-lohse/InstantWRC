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

var source = new EventSource('/update/events');
source.onmessage = function(){
	console.log('msg');
}
source.addEventListener('open', function(e) {
	  // Connection was opened.
	//alert('open');
	}, false);
source.addEventListener('error', function(e) {
	  // Connection was opened.
	console.log('error');
	}, false);