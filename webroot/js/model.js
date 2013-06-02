angular.module('DataBinder', [])
.factory('Model', function($rootScope){
    //represent one instance of a given model
    var ModelInstance = {
        scope: null,
        listeners: {},
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
    
    //creates new models and model instances
    var Model = {
        collection: [],
        properties: {},
        //create a new model type
        create: function(properties){
            var model = Object.create(this);
            
            for (var i = 0, l = properties.length; i < l; i++){
                model.properties[properties[i]] = {
                   enumerable: true,
                   writable: true,
                };
            }
            
            return model;
        },
        //create a new instance of this model type
        new: function(defaultValues){
            defaultValues = defaultValues || {};
            
            var instance = Object.create(ModelInstance, this.properties);
            instance.scope = $rootScope.$new();
            
            instance.scope.instance = instance;
            
            for (var prop in defaultValues){
                if (instance.hasOwnProperty(prop)) instance[prop] = defaultValues[prop];
            }
            
            for (var prop in this.properties){
                instance.listeners[prop] = [];
                instance.scope.$watch('instance.'+prop, angular.bind(instance, instance.propertyChange, prop));
            }
            
            this.collection.push(instance);
            return instance;
        },
    };
    
    return Model;
});