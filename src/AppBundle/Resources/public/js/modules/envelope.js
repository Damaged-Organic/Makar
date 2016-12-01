var app = app || {};

app.envelope = (function($, root){

	var envelope = {
		form: $("#envelopeForm"),
		loader: $("#loading"),
		message: $("#message"),
		initialize: initialize,
		_events: _events,
		handleSubmit: handleSubmit,
		validateForm: validateForm,
		_request: _request,
		getHtml: getHtml,
		handleCloseMessage: handleCloseMessage
	}

	function initialize(){
		this._events();
		this.validateForm();
	}
	function _events(){
		this.form.on("submit", $.proxy(this.handleSubmit, this));
		this.message.on("click", ".closeMessage", $.proxy(this.handleCloseMessage, this))
	}
	function handleSubmit(e){
		e.preventDefault();

		if(!this.form.valid()) return;
		this.loader.addClass("active");
		this._request(this.form.attr("action"), this.form.serializeArray());
	}
	function validateForm(){
		this.form.validate();
	}
	function _request(path, data){
		var self = this, html;

		$.ajax({
			url: path,
			type: "POST",
			data: data
		})
		.done(function(response){
			html = self.getHtml(response.message);
			self.message.html(html);
			self.message.addClass("active");
		})
		.fail(function(error){
			error.responseText = JSON.parse(error.responseText);

			html = self.getHtml(error.responseText.message);
			self.message.html(html);
			self.message.addClass("active");
		})
		.always(function(){
			self.loader.removeClass("active");
			self.form[0].reset();
		});
	}
	function getHtml(data){
		return "\
			<span>"+ data +"</span>\
			<span class='closeMessage fa fa-times'></span>\
		";
	}
	function handleCloseMessage(e){
		this.message.removeClass("active");
	}

	return envelope;

})(jQuery, window);