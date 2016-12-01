var app = app || {};

app.biography = (function($, root){

	var biography = {
		el: $(".animate"),
		hiddenPanel: {},
		initialize: initialize,
		_events: _events,
		handleScroll: handleScroll,
		toggleAnimation: toggleAnimation
	}

	function initialize(){
		this._events();
		this.hiddenPanel = new app.HiddenPanel();
	}
	function _events(){
		$(root).on("scroll", $.proxy(this.handleScroll, this));
	}
	function handleScroll(e){
		var yPos = $(root).scrollTop() + root.innerHeight;

		this.toggleAnimation(yPos);
	}
	function toggleAnimation(yPos){
		var offsetY;

		this.el.each(function(index, el){
			offsetY = $(this).offset().top + $(this).data("shift");

			yPos >= offsetY ? $(this).addClass("visible") : $(this).removeClass("visible");
		});
	}

	return biography;

})(jQuery, window);