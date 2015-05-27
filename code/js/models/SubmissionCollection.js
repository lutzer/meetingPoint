define([
        'underscore',
        'backbone',
        'models/SubmissionModel',
        'values/Constants'
], function(_, Backbone, SubmissionModel, Constants){
	
	SubmissionCollection = Backbone.Collection.extend({
		
		model: SubmissionModel,

		url : Constants['web_service_url']+"?submissions"
	
	});
	
	return SubmissionCollection;
});