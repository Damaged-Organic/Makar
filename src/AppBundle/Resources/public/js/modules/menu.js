var app = app || {};

app.menu = (function(){

	return {
		el: $("#page"),
		menuButton: $("#toggle-menu"),
		toggleScroll: new app.ToggleScroll,
		initialize: function(){
			this._events();
		},
		_events: function(){
			this.menuButton.on("click", $.proxy(this.handleToggle, this));
		},
		handleToggle: function(e){
			e.preventDefault();

			this.el.toggleClass("menu-open");
			this.el.hasClass("menu-open") ? this.toggleScroll.isScroll = false : this.toggleScroll.isScroll = true;
		}
	}

})();