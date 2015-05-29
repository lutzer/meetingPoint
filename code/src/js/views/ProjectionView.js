define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'text!templates/projectionTemplate.html',
], function($, _, Backbone, Marionette, Vent, template){
	
	var ProjectionView = Marionette.ItemView.extend({
		
		initialize: function(options) {
			
		},
		
		events : {

		},
		
		template : _.template(template)
	});
	
	return ProjectionView;
	
});