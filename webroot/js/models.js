angular.module('Models', ['InstantWrcBackend']).
factory('Rally', function(RallyBackend, $q){
	return {
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
		getTimes: function(success){
			if (angular.isDefined(this.times)){
				success(this.times);
			}
			else{
				var self = angular.bind(this, arguments.callee);
				this.refreshRally().then(angular.bind(this, function(){
					self(success);
				}));
			}
		},
		getStageName: function(success){
			if (angular.isDefined(this.lastStageName)){
				success(this.lastStageName);
			}
			else {
				var self = angular.bind(this, arguments.callee);
				this.refreshRally().then(angular.bind(this, function(){
					self(success);
				}));
			}
		},
		getStages: function(success){
			if (angular.isDefined(this.stages)){
				success(this.stages);
			}
			else {
				var self = angular.bind(this, arguments.callee);
				this.refreshStages().then(angular.bind(this, function(){
					self(success);
				}));
			}
		}
	};
});