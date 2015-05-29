define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'models/Database',
	'models/QuestionCollection',
	'text!templates/questionListTemplate.html',
], function($, _, Backbone, Marionette, Vent, Database, QuestionCollection, template){
	
	var QuestionListView = Marionette.ItemView.extend({
		
		initialize: function(options) {
			
			this.collection = Database.getInstance().questions;
			
		},
		
		className: 'page',
		
		collectionEvents : {
			'sync' : 'render'
		},
		
		events : {

		},
		
		template : _.template(template),
		
		templateHelpers: function() {
			return {
				questions : _.map(this.collection.where({category: this.options.category}),function(model) {
					return model.attributes;
				}),
			}
		}
	});
	
	return QuestionListView;
	
});