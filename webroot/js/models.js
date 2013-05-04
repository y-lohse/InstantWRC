angular.module('Models', ['InstantWrcBackend']).
factory('Rally', function(RallyBackend, $q){
	return {
		id: undefined,
		name: undefined,
		lastStageName: undefined,
		times: [],
		refreshData: function(){
			var deferred = $q.defer();
			
			RallyBackend.get({rallyId: this.id}, angular.bind(this, function(data){
				this.times = data.times;
				this.lastStageName = data.stagename;
				
				deferred.resolve();
			}));
			
			return deferred.promise;
		},
		getTimes: function(success){
			if (this.times.length === 0){
				this.refreshData().then(angular.bind(this, function(){
					success(this.times);
				}));
			}
			else{
				success(this.times);
			}
		},
		getStageName: function(success){
			this.refreshData().then(function(){
				success(this.lastStageName);
			});
		}
	};
});