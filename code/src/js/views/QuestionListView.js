define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'values/Constants',
	'models/Database',
	'models/QuestionCollection',
	'text!templates/questionListTemplate.html',
], function($, _, Backbone, Marionette, Vent, Constants, Database, QuestionCollection, template){
	
	var QuestionListView = Marionette.ItemView.extend({
		
		initialize: function(options) {
			
			this.collection = Database.getInstance().questions;
			
			// set headline and color
			this.headline = Constants.categories[options.category].name;
			this.color = Constants.categories[options.category].color;
			
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