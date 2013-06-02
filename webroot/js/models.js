angular.module('Models', ['InstantWrcBackend', 'DataBinder', 'LocalStorage']).
factory('Rally', function(RallyBackend, $q, Model, LocalStorageService){
	
	var RallyModel = Model.create(['id', 'name', 'lastStageName', 'times', 'stages']);
	
    var rally = RallyModel.new();
    
    //LocalStorageService.clear();
    rally.watch('id', function(){
        //présence dans le local storage?
        var stored = LocalStorageService.getItem('rally_'+rally.id);
        if (stored === null){
            var values = rally.getValues();
            LocalStorageService.setItem('rally_'+rally.id, values);
        }
        else{
            rally.setValues(stored);
        }
        
        rally.watchAny(function(prop, newer, old){
            var values = rally.getValues();
            LocalStorageService.setItem('rally_'+rally.id, values);
        });
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