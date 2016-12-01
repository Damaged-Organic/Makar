var app = app || {};

app.formAnimation = (function($, root){

	var formAnimation = {
		el: $(".input-area"),
		initialize: initialize,
		_events: _events,
		handleField: handleField,
		handleFieldClose: handleFieldClose
	}

	function initialize(){
		this._events();
	}
	function _events(){
		this.el.on("click", $.proxy(this.handleField, this));
		$(root).on("click", $.proxy(this.handleFieldClose, this))
	}
	function handleField(e){
		e.preventDefault();
		e.stopPropagation();

		var target = $(e.target).closest(".input-area");

		target.addClass("active").siblings(".input-area").removeClass("active");
		target.find(".field").focus();
	}
	function handleFieldClose(e){
		e.stopPropagation();
		
		if($(e.target).closest("#envelopeForm").length) return;
		this.el.removeClass("active");
	}

	return formAnimation;

})(jQuery, window);