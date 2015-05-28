define([
        'underscore',
        'backbone',
        'models/QuestionModel',
        'values/Constants'
], function(_, Backbone, QuestionModel, Constants){
	
	SubmissionCollection = Backbone.Collection.extend({
		
		model: QuestionModel,

		url : Constants['web_service_url']+"?questions"
	
	});
	
	return SubmissionCollection;
});