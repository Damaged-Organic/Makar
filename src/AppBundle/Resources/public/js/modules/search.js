var app = app || {};

app.search = (function($, root){

	var search = {
		searchForm: $("#searchForm"),
		searchResult: $("#results"),
		loader: $("#loading"),
		template: null,
		initialize: initialize,
		_events: _events,
		handleSubmit: handleSubmit,
		validateForm: validateForm,
		_request: _request,
		getTemplate: getTemplate
	}

	function initialize(){
		this._events();
		this.getTemplate();
		this.validateForm();
	}
	function _events(){
		this.searchForm.on("submit", $.proxy(this.handleSubmit, this));
	}
	function handleSubmit(e){
		e.preventDefault();

		if(!this.searchForm.valid()) return;

		var path = this.searchForm.attr("action"),
			data = this.searchForm.serializeArray();
		
		this.loader.addClass("active");
		this.searchResult.html("");
		this._request(path, data);
	}
	function validateForm(){
		this.searchForm.validate();
	}
	function _request(path, data){
		var self = this, html = "";

		$.ajax({
			url: path,
			type: "POST",
			data: data
		})
		.done(function(response){
			response = JSON.parse(response);
			html = self.template(response);

			self.searchResult.html(html);
		})
		.fail(function(error){
			error.responseText = JSON.parse(error.responseText);

			self.searchResult.html("<p class='no-data'>"+ error.responseText.message +"</p>");
		})
		.always(function(){
			self.loader.removeClass("active");
			self.searchForm[0].reset();
		});
	}
	function getTemplate(){
		var self = this;

		$.ajax({
			url: "bundles/app/js/templates/searchTemplate.html",
			cache: true
		})
		.done(function(response){
			self.template = Handlebars.compile(response);
		})		
	}

	var months = [
		"января",
		"февраля",
		"марта",
		"апреля",
		"мая",
		"июня",
		"июля",
		"августа",
		"сентября",
		"октября",
		"ноября",
		"декабря"
	];

	Handlebars.registerHelper("dateFormat", function(date){
		var parsed = Date.parse(date),
			date = new Date(parsed);

		return date.getDate() + " " + months[date.getMonth()] + " " + date.getFullYear();
	});

	return search;

})(jQuery, window);