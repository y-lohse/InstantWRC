angular.module('Models', ['InstantWrcBackend', 'DataBinder']).
factory('Rally', function(RallyBackend, $q, ModelAPI){
	
	var RallyModel = ModelAPI.create(['id', 'name', 'lastStageName', 'times', 'stages']);
	
    var rally = RallyModel.new();
    
    rally.watch('id', function(){
        alert('changed');
    });
	
	rally.refreshRally = function(){
        var deferred = $q.defer();
        
        RallyBackend.get({rallyId: this.id}, angular.bind(this, function(data){
            this.times = data.times;
            this.lastStageName = data.stagename;
            
            deferred.resolve();
        }));
        
        return deferred.promise;
    };
    /*
    rally.refreshStages = function(){
        var deferred = $q.defer();
        
        RallyBackend.stages({rallyId: this.id}, angular.bind(this, function(data){
            this.stages = data.stages;
            
            deferred.resolve();
        }));
        
        return deferred.promise;
    };*/
    
	return rally;
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