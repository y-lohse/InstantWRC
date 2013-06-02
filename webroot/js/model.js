angular.module('DataBinder', [])
.factory('Model', function($rootScope){
    var Model = {
        scope: null,
        collection: [],
        listeners: {},
        properties: {},
        //create a new instance of this model
        new: function(defaultValues){
            defaultValues = defaultValues || {};
            
            //@TODO : ne pasexposer le proto
            var instance = Object.create(this.__proto__, this.properties);
            instance.scope = $rootScope.$new();
            
            instance.scope.instance = instance;
            
            for (var prop in defaultValues){
                if (instance.hasOwnProperty(prop)) instance[prop] = defaultValues[prop];
            }
            
            for (var prop in this.properties){
                instance.listeners[prop] = [];
                instance.scope.$watch('instance.'+prop, angular.bind(this, this.propertyChange, prop));
            }
            
            this.collection.push(instance);
            return instance;
        },
        //dispatcher function for property change
        propertyChange:function(property, newValue, oldValue){
            if (newValue === oldValue) return;//changed due to init
            
            for (var i = 0, l = this.listeners[property].length; i < l; i++){
                this.listeners[property][i](newValue, oldValue);
            }
        },
        //get notified when a property changes
        watch: function(property, callback){
            if (this.hasOwnProperty(property))
                this.listeners[property].push(callback);
        }
        //@TODO : unwatch
    };
    
    return Model;
})
.factory('ModelAPI', function(Model){
    var ModelAPI = {
        //create a new model object
        create: function(properties){
            var model = Object.create(Model);
            
            for (var i = 0, l = properties.length; i < l; i++){
                model.properties[properties[i]] = {
                   enumerable: true,
                   writable: true,
                };
            }
            
            return model;
        }
    };
    
    return ModelAPI;
});