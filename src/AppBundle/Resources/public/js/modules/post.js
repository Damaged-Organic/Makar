var app = app || {};

app.post = (function($, root){

	var post = {
		el: $("#post-holder"),
		headline: null,
		isRolled: false,
		initialize: initialize,
		_events: _events,
		handleScroll: handleScroll,
		handleArrow: handleArrow,
		toggleRoll: toggleRoll
	}

	function initialize(){
		this.headline = this.el.find(".headline-holder");
		this._events();
	}
	function _events(){
		$(root).on("scroll", $.proxy(this.handleScroll, this));
		this.el.on("click", ".arrow", $.proxy(this.handleArrow, this));
	}
	function handleScroll(e){
		var yPos = $(root).scrollTop(),
			percentage = yPos / root.innerHeight * 100,
			delta = 100 - percentage;

		this.toggleRoll(percentage);
	}
	function handleArrow(e){
		this.el.addClass("rolled");
	}
	function toggleRoll(percentage){
		if(this.el.hasClass("rolled") && percentage >= 10) this.isRolled = true;

		if(percentage >= 0 && !this.isRolled) this.el.addClass("rolled");
		if(percentage <= 0 && this.isRolled){
			 this.el.removeClass("rolled");
			 this.isRolled = false;
		}
	}

	return post;

})(jQuery, window);