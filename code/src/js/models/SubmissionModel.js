define([
        'underscore',
        'backbone',
        'values/Constants'
], function(_, Backbone, Constants){

	var SubmissionModel = Backbone.Model.extend({

		urlRoot : Constants['web_service_url']+"?submissions",
		
		defaults: {
			title: '',
			text_question : null,
			text_result : null,
			image_question: null,
			image_result: null,
			category: null
		}
	});

	// Return the model for the module
	return SubmissionModel;

});