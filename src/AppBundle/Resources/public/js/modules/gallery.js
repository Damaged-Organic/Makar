var app = app || {};

app.gallery = (function($, root){

	var keyCodes = [1, 37, 39], gallery;

	gallery = {
		cell: $(".cell"),
		galleryHolder: $("#gallery-holder"),
		picturePlace: $("#picturePlace"),
		pictureInfo: $("#pictureInfo"),
		pictureCount: 0,
		current: 0,
		picture: null,
		popUp: null,
		initialize: initialize,
		_events: _events,
		handleClick: handleClick,
		handleArrow: handleArrow,
		checkRange: checkRange,
		loadPicture: loadPicture,
		updatePicture: updatePicture,
		updateCounter: updateCounter,
		checkKeyCodes: checkKeyCodes
	}

	function initialize(){
		this.pictureCount = this.cell.length;
		this.popUp = new app.PopUp("#gallery-holder");
		this._events();
	}
	function _events(){
		this.cell.on("click", $.proxy(this.handleClick, this));
		this.galleryHolder.on("click", ".arrow", $.proxy(this.handleArrow, this));
		$(root).on("keyup", $.proxy(this.handleArrow, this));
	}
	function handleClick(e){
		e.preventDefault();
		
		var cell = $(e.target).closest(".cell");
		this.current = cell.index();
		this.loadPicture(cell.data("picture"), cell.data("title"));
		this.updateCounter(this.current + 1, cell.data("title"));
	}
	function handleArrow(e){
		e.preventDefault();

		var arrow = $(e.target),
			keyCode = e.which,
			hasMatch = this.checkKeyCodes(keyCode),
			cell;

		if(!hasMatch) return;

		if(arrow.hasClass("left") || e.which == 37){
			this.current--;
		} else if(arrow.hasClass("right") || e.which == 39){
			this.current++;
		}
		this.checkRange();

		cell = this.cell.eq(this.current);

		this.loadPicture(cell.data("picture"), cell.data("title"));
		this.updateCounter(this.current + 1,  cell.data("title"));
	}
	function checkRange(){
		if(this.current >= this.pictureCount){
			this.current = 0;
		} else if(this.current < 0){
			 this.current = this.pictureCount - 1;
		}
	}
	function loadPicture(source, alt){
		var picture = new Image(),
			self = this;

		picture.onload = function(){
			self.updatePicture(this);
			self.popUp.open();
		}
		picture.src = source;
		picture.alt = alt;
	}
	function updatePicture(picture){
		this.picturePlace.html(picture);
	}
	function updateCounter(current, title){
		this.pictureInfo.html("\
			<span>"+ title +"</span>\
			<span>"+ current + " / " + this.pictureCount +"</span>\
		");
	}
	function checkKeyCodes(keyCode){
		var match = false, i;

		for(i = keyCodes.length; i--;){
			if(keyCode === keyCodes[i]) match = true;
		}
		return match;	
	}

	return gallery;

})(jQuery, window);