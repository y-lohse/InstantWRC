angular.module('Models', ['InstantWrcBackend', 'DataBinder']).
factory('Rally', function(RallyBackend, $q, ModelAPI){
	
	var RallyModel = ModelAPI.create({
	    id: {
	       enumerable: true,
	       writable: true,
	    },
		name: {
	       enumerable: true,
	       writable: true,
	    },
		lastStageName: {
	       enumerable: true,
	       writable: true,
	    },
		times: {
	       enumerable: true,
	       writable: true,
	    },
		stages: {
	       enumerable: true,
	       writable: true,
	    },
	});
	
    var Rally = RallyModel.new({id: 5});
	
	Rally.refreshRally = function(){
        var deferred = $q.defer();
        
        RallyBackend.get({rallyId: this.id}, angular.bind(this, function(data){
            //this.times = data.times;
            //this.lastStageName = data.stagename;
            
            deferred.resolve();
        }));
        
        return deferred.promise;
    };
    Rally.refreshStages = function(){
        var deferred = $q.defer();
        
        RallyBackend.stages({rallyId: this.id}, angular.bind(this, function(data){
            //this.stages = data.stages;
            
            deferred.resolve();
        }));
        
        return deferred.promise;
    };
    
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