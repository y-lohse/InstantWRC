angular.module('DataBinder', [])
.factory('Model', function($rootScope){
    //represent one instance of a given model
    var ModelInstance = {
        _scope: null,
        _anyChange: [],
        _listeners: {},
        _customProps: [],
        //dispatcher function for property change
        _propertyChange:function(property, newValue, oldValue){
            if (newValue === oldValue) return;//not a real change
            
            //call all watchers
            for (var i = 0, l = this._anyChange.length; i < l; i++){
                this._anyChange[i](property, newValue, oldValue);
            }
            
            //call specific watchers
            for (var i = 0, l = this._listeners[property].length; i < l; i++){
                this._listeners[property][i](newValue, oldValue);
            }
        },
        //returns a plain object with only the user defined properties and values
        getValues: function(){
            var values = {};
            for (var i = 0, l = this._customProps.length; i < l; i++){
                values[this._customProps[i]] = this[this._customProps[i]];
            }
            
            return values;
        },
        //overwrites the objects current values
        setValues: function(values){
            for (var prop in values){
                if (this._customProps.indexOf(prop) && this.hasOwnProperty(prop))
                    this[prop] = values[prop];
            }
        },
        //get notified for any change
        watchAny: function(callback){
            this._anyChange.push(callback);
        },
        //@TODO : unwatch any
        //get notified when a property changes
        watch: function(property, callback){
            if (this.hasOwnProperty(property))
                this._listeners[property].push(callback);
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
            
            //create new instance
            var instance = Object.create(ModelInstance, this.properties);
            instance._scope = $rootScope.$new();
            
            //allow property watching
            instance._scope.instance = instance;//this, somehow, works.
            
            //assign default values
            for (var prop in defaultValues){
                if (instance.hasOwnProperty(prop)) instance[prop] = defaultValues[prop];
            }
            
            //add watchers
            for (var prop in this.properties){
                instance._listeners[prop] = [];
                instance._customProps.push(prop);
                instance._scope.$watch('instance.'+prop, angular.bind(instance, instance._propertyChange, prop));
            }
            
            this.collection.push(instance);
            return instance;
        },
    };
    
    return Model;
});