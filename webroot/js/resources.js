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

angular.module('InstantWrcSSE', []).
provider('IWRCEventSource', function(){
	this.source = new EventSource('/update/events');
	this.events = [];
	
	this.subscribe = function(event, callback){
		alert('subscribing '+event);
	}
	
	this.$get = function(){
		var self = this;
		
		return {
			subscribe: function(event, callback){
				self.subscribe(event, callback);
			}
		}
	}
});
/*
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
	}, false);*/