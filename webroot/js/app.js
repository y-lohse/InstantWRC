App = Ember.Application.create();

App.Router.map(function() {
	this.route('rankings');
	this.route('rally');
	this.route('stage');
});
