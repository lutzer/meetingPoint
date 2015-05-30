define([], function(){
	var Constants = {

			/*
			 *  server settings 
			 */
			"web_service_url": "api/",
			
			"upload_directory": "/Shared/docs/",
				
			categories : {
				people : {
					color: 'green',
					name: 'THE PEOPLE',
				},
				location : {
					color: 'blue',
					name: 'THE SPACE',
				},
				event : {
					color: 'pink',
					name: 'THE MEETING POINT',
				},
			}
			
	};
	return Constants;
});