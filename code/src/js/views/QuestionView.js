define([
	'jquery',
	'underscore',
	'backbone',
	'marionette',
	'vent',
	'models/QuestionModel',
	'models/SubmissionModel',
	'text!templates/questionTemplate.html',
], function($, _, Backbone, Marionette, Vent, QuestionModel, SubmissionModel, template){
	
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
			
			//upload file if file is selected
			if (this.fileSelected) {
				model.save(values, { 
					iframe: true,
					files: this.$('#fileChooser'),
					data: values,
					success: function(model,response) {
						if (response.error !== undefined)
							onError(response.error.message);
						else
							onSuccess();
					},
					error: function(model,response) {
						onError(response.responseText);
					}
				});
			} else {
				model.save(values, {
					success: function(model,response) {
						onSuccess();
					},
					error: function(model,response) {
						onError(response.responseText);
					}
				});
			}
			
			//open upload dialog
			Vent.trigger('dialog:open', {
				title: "Uploading Submission", 
				text: "Depending on the file size, this may take a while.", 
				type: 'progress',
				callback: function() {
					window.location.href = "#upload";
				}
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
					type: 'message'
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