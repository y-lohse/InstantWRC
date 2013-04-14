InstantWRC = Ember.Application.create();

InstantWRC.Router.map(function() {
	this.route('rankings');
	this.route('rally');
	this.route('stage');
});

InstantWRC.Store = DS.Store.extend({
	revision: 12,
	adapter: DS.RESTAdapter
});

InstantWRC.Rally = DS.Model.extend({
	name: DS.attr('string')
});

InstantWRC.IndexRoute = Ember.Route.extend({
	model: function(){
		return InstantWRC.Rally.find();
	}
});