define([
    'jquery',
	'underscore',
	'views/dialogs/BaseDialogView',
	'text!templates/dialogs/dialogMessageTemplate.html',
	'text!templates/dialogs/dialogProgressTemplate.html'
], function($, _, BaseDialogView, messageTemplate, progressTemplate){
	
	var ModalDialogView = BaseDialogView.extend({
		
		serializeData: function(){
		    return {
				title : this.options.title,
				text : this.options.text
		    };
		},
		
		getTemplate: function(){
			if (this.options.type == 'message')
				return _.template(messageTemplate);
			else if (this.options.type == 'progress')
				return _.template(progressTemplate);
	    },
		
		done: function(msg) {
			this.$('#done').html(msg);
			this.setProgress(100);
		},
		
		setProgress: function(val) {
			if (!this.$('#progressBar > div').hasClass("determinate")) {
				this.$('#progressBar > div').removeClass("indeterminate");
				this.$('#progressBar > div').addClass("determinate");
			}
			this.$('#progressBar > div').width(val+"%");
		}
		
	});
	return ModalDialogView;
	
});