var app = app || {};

app.Lift = (function($, root){

	function Lift(ajaxUrl, templateUrl){
		this.el = $(".lift-up-container");
		this.ajaxUrl = ajaxUrl;
		this.templateUrl = templateUrl;
		this.initialize.apply(this, arguments);
	}
	Lift.prototype = {
		loader: $("#loader-holder"),
		items: [],
		itemsCount: 0,
		lastY: 0,
		template: null,
		isLoading: false,
		isLast: false,
		initialize: initialize,
		_events: _events,
		setTemplate: setTemplate,
		setItems: setItems,
		getItemsCount: getItemsCount,
		setLastY: setLastY,
		handleScroll: handleScroll,
		liftUp: liftUp
	}

	function initialize(){
		this._events();
		new app.Template(this.templateUrl, $.proxy(this.setTemplate, this));

		this.setItems();
		this.getItemsCount();
		this.setLastY();
	}
	function _events(){
		$(root).on("scroll", $.proxy(this.handleScroll, this));
	}
	function setTemplate(source, template){
		this.template = template;
	}
	function setItems(){
		this.items = this.el.find(".lift-up-item");
	}
	function getItemsCount(){
		this.itemsCount = this.items.length;
	}
	function setLastY(){
		var item = this.items.last();
		this.lastY = item.offset().top + item.outerHeight();
	}
	function handleScroll(e){
		var y = $(root).scrollTop() + root.innerHeight;

		if(y > this.lastY && !this.isLoading && !this.isLast) this.liftUp();
	}
	function liftUp(){
		var self = this,
			html = "";

		self.isLoading = true;
		self.loader.addClass("active");

		$.ajax({
			url: self.ajaxUrl,
			type: "POST",
			data: {quantity: self.itemsCount}
		})
		.done(function(response){
			response = JSON.parse(response);
			html = self.template(response);

			self.isLast = response.isLast;

			self.el.append(html);
		})
		.always(function(){
			self.isLoading = false;
			self.loader.removeClass("active");

			self.setItems();
			self.getItemsCount();
			self.setLastY();
		});
	}

	return Lift;

})(jQuery, window);
