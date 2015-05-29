define([
        'jquery',
        'marionette',
        'vent',
    	'models/Database',
    	'views/MainView',
    	'views/ProjectionView',
    	'views/SubmissionListView',
    	'views/QuestionListView',
    	'views/QuestionView',
        'views/dialogs/ModalDialogView'
], function($, Marionette, Vent, Database, MainView, ProjectionView, SubmissionListView, QuestionListView, QuestionView, ModalDialogView){
	
	var Controller = Marionette.Controller.extend({
		
		initialize: function(app) {
			this.app = app;
			
			app.addRegions({
				contentRegion: "#content",
				modalRegion: "#modal-container"
			});
			
			//register events
			Vent.on('dialog:open', this.openDialog, this);
			Vent.on('dialog:close', this.closeDialog, this);
		},
		
			
		/* ROUTES */
		
		projection: function() {
			this.app.contentRegion.show(new ProjectionView());
		},
		
		submissions: function(id) {
			this.app.contentRegion.show(new SubmissionListView());
		},
		
		question: function(id) {
			this.app.contentRegion.show(new QuestionView({id: id}));
		},
		
		questions: function(category) {
			this.app.contentRegion.show(new QuestionListView({category : category}));
		},
	
		defaultRoute: function() {
			this.app.contentRegion.show(new MainView());
		},
		
		/* DIALOGS */
		
		openDialog: function(options) {
			this.app.modalRegion.show(new ModalDialogView(options));
		},
		
		closeDialog: function() {
			if (this.app.modalRegion.hasView())
				this.app.modalRegion.reset();
		}
		
	});
	
	return Controller;
});