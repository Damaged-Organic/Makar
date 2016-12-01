var app = app || {};

app.affiche = (function(){

	var affiche = {
		initialize: initialize
	}

	function initialize(){
		new app.Lift("/getEventsItems", "bundles/app/js/templates/afficheTemplate.html");
	}

	return affiche;

})(jQuery, window);