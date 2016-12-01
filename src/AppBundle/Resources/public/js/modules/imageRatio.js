var app = app || {};

app.ImageRatio = (function(){

	function ImageRatio(cells){
		this.el = $(cells);
		this.initialize.apply(this, arguments);
	}
	ImageRatio.prototype = {
		initialize: initialize,
		setRatio: setRatio
	}

	function initialize(){
		this.setRatio();
	}
	function setRatio(){
		var img, ratio;

		this.el.each(function(index, el){
			img = $(this).find("img");
			ratio = img.width() / img.height();

			if(ratio > 1) $(this).addClass("wide");
		});
	}

	return ImageRatio;

})(jQuery, window);