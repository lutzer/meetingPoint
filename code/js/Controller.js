define([
        'jquery',
        'marionette',
        'vent',
    	'models/Database',
        'views/dialogs/ModalDialogView'
], function($, Marionette, Vent, Database, ModalDialogView){
	
	var Controller = Marionette.Controller.extend({
		
		initialize: function(app) {
			this.app = app;
			
			app.addRegions({
				contentRegion: "#content",
			});
			
			//register events
			Vent.on('dialog:open', this.openDialog, this);
			Vent.on('dialog:close', this.closeDialog, this);
		},
		
			
		/* ROUTES */
	
		defaultRoute: function() {
			//this.app.contentRegion.show(new DocumentListView());
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