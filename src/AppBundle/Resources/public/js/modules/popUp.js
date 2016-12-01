var app = app || {};

app.PopUp = (function($, root){
 
	var keys = [1, 27];

	function PopUp(popUp){
		this.popUp = $(popUp);

		this.initialize.apply(this, arguments);
	}
	PopUp.prototype = {
		toggleScroll: new app.ToggleScroll,
		initialize: initialize,
		_events: _events,
		open: open,
		close: close,
		compareKeys: compareKeys
	}
	function initialize(){
		this._events();
	}
	function _events(){
		this.popUp.on("click", ".close", $.proxy(this.close, this));
		$(root).on("keyup", $.proxy(this.close, this));
	}
	function open(){
		this.toggleScroll.isScroll = false;
		this.popUp.addClass("active");
	}
	function close(e){
		var hasMatch = this.compareKeys(e.which);

		if(!hasMatch) return;
		this.toggleScroll.isScroll = true;
		this.popUp.removeClass("active");

		$(window).trigger("popUpClosed")
	}
	function compareKeys(keyCode){
		var match = false, i;

		for(i = keys.length; i--;){
			if(keyCode === keys[i]) match = true;
		}
		return match;
	}

	return PopUp;

})(jQuery, window);
