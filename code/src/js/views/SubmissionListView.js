define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'models/Database',
	'text!templates/submissionListTemplate.html',
], function($, _, Backbone, Marionette, Vent, Database, template){
	
	var SubmissionListView = Marionette.ItemView.extend({
		
		initialize: function(options) {
			
			this.collection = Database.getInstance().submissions;
			
		},
		
		className: 'page',
		
		collectionEvents : {
			'sync' : 'render'
		},
		
		events : {

		},
		
		template : _.template(template)
	});
	
	return SubmissionListView;
	
});