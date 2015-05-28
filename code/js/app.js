define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'Controller'
], function($, _, Backbone, Marionette, Controller) {
	
	var App = new Backbone.Marionette.Application();

	var initialize = function(){
		
		App.addInitializer(function(options){
			  Backbone.history.start();
			  
			  // support cross origin sharing
			  $.support.cors=true;
			  
		});
		
		App.Router = new Marionette.AppRouter({
			controller: new Controller(App),
			appRoutes: {
				/*'projection': 'projection',
				'blog': 'blog',*/
				'question/:id' : 'question',
				'questions/:category' : 'questions',
				'*actions': 'defaultRoute'
			}
		});
		
		App.start();
		
	};

	return {
		initialize: initialize,
	};
	
});