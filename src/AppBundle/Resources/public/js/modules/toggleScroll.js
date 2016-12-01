var app = app || {};

app.ToggleScroll = (function($, root){

	function ToggleScroll(){
		this.initialize.apply(this, arguments);
	}
	ToggleScroll.prototype = {
		isScroll: true,
		initialize: initialize,
		_events: _events,
		handleScroll: handleScroll
	}
	
	function initialize(){
		this._events();
	}
	function _events(){
		$(window).on("mousewheel DOMMouseScroll", $.proxy(this.handleScroll, this));
	}
	function handleScroll(e){
		if(!this.isScroll) e.preventDefault();
	}

	return ToggleScroll;

})(jQuery, window);