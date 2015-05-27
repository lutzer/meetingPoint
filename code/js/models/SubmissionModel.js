define([
        'underscore',
        'backbone',
        'values/Constants'
], function(_, Backbone, Constants){

	var SubmissionModel = Backbone.Model.extend({

		urlRoot : Constants['web_service_url']+"?submissions",
		
		defaults: {
			title: '',
			text: '',
			image: false,
			category_id: null,
			created_at: 0
		}
	});

	// Return the model for the module
	return SubmissionModel;

});