var app = app || {};

app.tabs = (function($, root){

	var tabs = {
		el: $(".tabs"),
		initialize: initialize
	}

	function initialize(){
		this.el.each(function(){
			new Tab($(this));
		});
	}


	function Tab(tab){
		this.tab = tab;
		this.initialize.apply(this, arguments);
	}
	Tab.prototype = {
		labels: [],
		contents: [],
		initialize: function(){
			this._events();

			this.labels = this.tab.find(".tab-label");
			this.contents = this.tab.find(".tab-content");

			this.switchTab(0);
		},
		_events: function(){
			this.tab.on("click", ".tab-label", $.proxy(this.handleTab, this));
		},
		handleTab: function(e){
			var label = $(e.target).closest(".tab-label"),
				current = label.index();

			this.switchTab(current);
		},
		switchTab: function(current){
			this.labels.removeClass("active").eq(current).addClass("active");
			this.contents.removeClass("active").eq(current).addClass("active");
		}
	}

	return tabs;

})(jQuery, window);