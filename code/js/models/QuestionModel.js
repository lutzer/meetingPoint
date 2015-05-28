define([
        'underscore',
        'backbone',
        'values/Constants'
], function(_, Backbone, Constants){

	var QuestionModel = Backbone.Model.extend({

		urlRoot : Constants['web_service_url']+"?questions",
		
		defaults: {
			title: '',
			category: null,
			text_question: null,
			text_tesult: null,
			image_question: null,
			image_result: null,
		}
	
	});

	// Return the model for the module
	return QuestionModel;

});