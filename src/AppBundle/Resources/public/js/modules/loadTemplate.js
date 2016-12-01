var app = app || {};

app.Template = (function($, root){

	function Template(path, callback){
		this.path = path;
		this.callback = callback;
		this.loadTemplate.apply(this, arguments);
	}
	Template.prototype = {
		loadTemplate: loadTemplate
	}

	function loadTemplate(){
		var self = this, source, template;

		return $.ajax({
			url: this.path,
			cache: true
		})
		.done(function(source){
			source = source;
			template = Handlebars.compile(source);
			self.callback(source, template);
		});
	}

	return Template;

})(jQuery, window);