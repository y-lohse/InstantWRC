angular.module('DataBinder', [])
.factory('Model', function($rootScope){
    var Model = {
        scope: null,
        collection: [],
        properties: {},
        new: function(properties){
            properties = properties || {};
            
            var instance = Object.create(this.__proto__, this.properties);
            /*instance.scope = $rootScope.$new();
            
            this.collection.push(instance);*/
            return instance;
        }
    };
    
    return Model;
})
.factory('ModelAPI', function(Model){
    var ModelAPI = {
        create: function(properties){
            var model = Object.create(Model);
            
            for (var prop in properties){
                model.properties[prop] = properties[prop];
            }
            
            return model;
        }
    };
    
    return ModelAPI;
});