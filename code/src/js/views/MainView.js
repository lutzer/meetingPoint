define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'text!templates/mainTemplate.html',
], function($, _, Backbone, Marionette, Vent, template){
	
	var MainView = Marionette.ItemView.extend({
		
		initialize: function(options) {
			
		},
		
		className: 'page',
		
		events : {

		},
		
		template : _.template(template),
		
		
	});
	
	return MainView;
	
});