angular.module('Models', ['InstantWrcBackend', 'InstantWrcSSE']).
factory('Rally', function(RallyBackend, IWRCEventSource, $q){
	var Rally = {
		id: undefined,
		name: undefined,
		lastStageName: undefined,
		times: undefined,
		stages: undefined,
		refreshRally: function(){
			var deferred = $q.defer();
			
			RallyBackend.get({rallyId: this.id}, angular.bind(this, function(data){
				this.times = data.times;
				this.lastStageName = data.stagename;
				
				deferred.resolve();
			}));
			
			return deferred.promise;
		},
		refreshStages: function(){
			var deferred = $q.defer();
			
			RallyBackend.stages({rallyId: this.id}, angular.bind(this, function(data){
				this.stages = data.stages;
				
				deferred.resolve();
			}));
			
			return deferred.promise;
		},
	};
	
	IWRCEventSource.subscribe('OverallUpdate', function(){
		console.log('notified');
	});
	
	return Rally;
}).
factory('Stage', function(StageBackend, $q){
	return {
		id: undefined,
		name: undefined,
		times: undefined,
		refreshData: function(){
			var deferred = $q.defer();
			
			StageBackend.get({stageId: this.id}, angular.bind(this, function(data){
				this.times = data.times;
				this.name = data.stagename;
				
				deferred.resolve();
			}));
			
			return deferred.promise;
		},
	};
});