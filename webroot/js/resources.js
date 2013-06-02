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
	this.events = {};
	
	this.subscribe = function(event, callback){
		if (angular.isDefined(this.events[event])){
			console.log('event decalred');
		}
		else this.addEventListener(event, callback);
	};
	
	this.addEventListener = function(event, callback){
		this.source.addEventListener(event, angular.bind(this, this.dispatcher));
		this.events[event] = [callback];
	}
	
	this.dispatcher = function(e){
		var eventName = e.type;
		var data = angular.fromJson(e.data);
		
		if (angular.isDefined(this.events[eventName])){
			for (var i = 0, l = this.events[eventName].length; i < l; i++){
				this.events[eventName][i](data);
			}
		}
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

angular.module('LocalStorage', [])
.factory('LocalStorageService', function(){
    var ls = {
        getItem: function(key){
            return window.localStorage.getItem(key);
        },
        setItem: function(key, value){
            return window.localStorage.setItem(key, value);
        }
    };
    
    return ls;
});
