angular.module('DataBinder', [])
.factory('Model', function($rootScope){
    var Model = {
        scope: null,
        collection: [],
        properties: {},
        new: function(defaultValues){
            defaultValues = defaultValues || {};
            
            var instance = Object.create(this.__proto__, this.properties);
            instance.scope = $rootScope.$new();
            
            instance.scope.instance = instance;
            
            for (var prop in defaultValues){
                if (instance.hasOwnProperty(prop)) instance[prop] = defaultValues[prop];
            }
            
            for (var prop in this.properties){
                var ref = prop;
                instance.scope.$watch('instance.'+prop, angular.bind(this, this.propertyChange, prop));
            }
            
            this.collection.push(instance);
            return instance;
        },
        propertyChange:function(property, newValue, oldValue){
            if (newValue === oldValue) return;//changed due to init
            console.log(property+' changed from '+oldValue+' to '+newValue);
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