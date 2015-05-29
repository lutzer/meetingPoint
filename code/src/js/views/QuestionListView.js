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
			
			// set headline
			if (options.category == "people") {
				this.headline = "THE PEOPLE";
				this.color = "green"
			} else if (options.category == "location") {
				this.headline = "THE SPACE";
				this.color = "blue";
			} else if (options.category == "event") {
				this.headline = "THE MEETING POINT";
				this.color = "pink"
			}
			
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
				headline : this.headline,
				color : this.color
			}
		}
	});
	
	return QuestionListView;
	
});