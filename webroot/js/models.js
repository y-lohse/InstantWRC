angular.module('Models', ['InstantWrcBackend']).
factory('Rally', function(RallyBackend, $q){
	return {
		id: undefined,
		name: undefined,
		lastStageName: undefined,
		times: [],
		
		refreshData: function(){
			var deferred = $q.defer();
			
			RallyBackend.get({rallyId: this.id}, function(data){
				this.times = data.times;
				this.lastStageName = data.stagename;
				
				deferred.resolve();
			});
			
			return deferred.promise;
		},
		getTimes: function(success){
			this.refreshData().then(function(){
				success(this.times);
			});
		},
		getStageName: function(success){
			this.refreshData().then(function(){
				success(this.lastStageName);
			});
		}
	};
});