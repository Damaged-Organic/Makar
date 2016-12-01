var app = app || {};

app.HiddenPanel = (function($, root){

	function HiddenPanel(){
		this.el = $("#content");
		this.initialize.apply(this, arguments);
	}
	HiddenPanel.prototype = {
		initialize: initialize,
		_events: _events,
		handleButton: handleButton,
		handleClose: handleClose,
		activatePanel: activatePanel
	}

	function initialize(){
		this._events();
	}
	function _events(){
		this.el.on("click", ".button", $.proxy(this.handleButton, this));
		this.el.on("click", ".close-hidden", $.proxy(this.handleClose, this));
	}
	function handleButton(e){
		e.preventDefault();

		var button = $(e.target).closest(".button"),
			type = button.data("type"),
			panel = null;

		if(!type) return;
		panel = button.closest(".hidden-holder").find("." + type);
		this.activatePanel(panel);
	}
	function handleClose(e){
		e.preventDefault();

		var panel = $(e.target).closest(".hidden-info");
		panel.removeClass("active").find(".info").perfectScrollbar("destroy");
	}
	function activatePanel(panel){
		panel.addClass("active").siblings(".hidden-info").removeClass("active");
		panel.find(".info").perfectScrollbar();
	}

	return HiddenPanel;

})(jQuery, window);