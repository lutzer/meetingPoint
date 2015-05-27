define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'text!templates/template.html',
], function($, _, Backbone, Marionette, Vent, template){
	
	var View = Marionette.ItemView.extend({
		
		initialize: function(options) {
			
		},
		
		events : {

		},
		
		template : _.template(template)
	});
	
	return View;
	
});