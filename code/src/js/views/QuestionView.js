define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'values/Constants',
	'models/QuestionModel',
	'models/SubmissionModel',
	'text!templates/questionTemplate.html',
], function($, _, Backbone, Marionette, Vent, Constants, QuestionModel, SubmissionModel, template){
	
	var QuestionView = Marionette.ItemView.extend({
		
		initialize: function(options) {
			
			this.model = new QuestionModel({id : options.id});
			this.model.fetch();
			
			this.fileSelected = false;
			
		},
		
		className: 'page',
		
		modelEvents: {
			'sync' : 'render'
		},
		
		events: {
		    'click #submitButton' : 'onSubmit',
		    'change #fileChooser' : 'onFileChoosen'
		},
		
		template : _.template(template),
		
		templateHelpers: function() {
			return {
				color : this.getColor()
			}
		},
		
		getColor: function() {
			if (this.model.get('category'))
				return Constants.categories[this.model.get('category')].color
			else
				return ''	
		},
		
		onSubmit: function(event) {
			
			event.preventDefault();
			
			var values = {
					title: this.model.get('title'),
					category: this.model.get('category'),
					text_question: this.model.get('text_question'),
					image_question: this.model.get('image_question')
			};
			
			//set result text
			if (this.model.get('text_question')) {
				values.text_result = this.$('#textInput').val();
			}

			var model = new SubmissionModel(values);
			
			var options = {
				success: function(model,response) {
					if (response.error !== undefined)
						onError(response.error.message);
					else
						onSuccess();
				},
				error: function(model,response) {
					console.log(response);
					onError(response.responseJSON.error.message);
				}
			}
			//upload file if file is selected
			if (this.fileSelected) {
				options.iframe = true;
				options.files = this.$('#fileChooser');
				options.data = values;
			}
			
			// send data
			model.save(values, options);
			
			//open upload dialog
			Vent.trigger('dialog:open', {
				title: "Sending Data", 
				text: "Depending on the submission size, this may take a few seconds...", 
				type: 'progress'
			});
			
			function onError(message) {
				Vent.trigger('dialog:open', {
					title: "Error uploading", 
					text: message, 
					type: 'message'
				});
			}
			
			function onSuccess() {
				Vent.trigger('dialog:open', {
					title: "Data submitted", 
					text: "Thank you! Your Post got submitted.", 
					type: 'message',
					callback: function() {
						window.location.href = "#";
					}
				});
				//Vent.trigger('dialog:close');
			}
		},
		
		onFileChoosen: function(event) {
			filename = event.target.value.split('/').pop()
			filename = filename.split('\\').pop();
			this.$('#filepath').html(filename);
			this.fileSelected = true;
		}
	});
	
	return QuestionView;
	
});