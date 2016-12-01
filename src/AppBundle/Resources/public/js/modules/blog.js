var app = app || {};

app.blog = (function(){

	var blog = {
		initialize: initialize
	}

	function initialize(){
		new app.Lift("/getBlogArticles", "bundles/app/js/templates/blogTemplate.html");
	}

	return blog;

})(jQuery, window);