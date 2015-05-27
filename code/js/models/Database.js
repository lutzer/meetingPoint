define([
        "models/SubmissionCollection"
], function (SubmissionCollection) {
	
	var instance = null;
	 
    function Database(){
        if(instance !== null){
            throw new Error("Cannot instantiate more than one Singleton, use Database.getInstance()");
        } 
        
        this.initialize();
    };
    
    Database.prototype = {
        initialize: function(){
            
        	this.submissions = new SubmissionCollection();
        	this.sync();
        	
        },
        
        sync: function(options) {
        	//fetch data
        	this.submissions.fetch(options);
        }
    };
    
    return {
    	getInstance : function() {
	        if(instance === null){
	            instance = new Database();
	        }
	    	return instance;
    	}
    };
});