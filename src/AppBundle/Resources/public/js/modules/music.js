var app = app || {};

app.music = (function($, root){

	var music = {
		el: $("#content"),
		popUp: {},
		tabs: {},
		albumContent: null,
		initialize: initialize,
		_events: _events,
		handleAlbum: handleAlbum,
		switchAlbum: switchAlbum,
		openPopUp: openPopUp,
		closePopUp: closePopUp,
		applyScroll: applyScroll,
		destroyScroll: destroyScroll
	}

	function initialize(){
		this._events();

		this.popUp = new app.PopUp(".popUp");
	}
	function _events(){
		this.el.on("click", ".album", $.proxy(this.handleAlbum, this));
		$(root).on("popUpClosed", $.proxy(this.closePopUp, this));
	}
	function handleAlbum(e){
		var album = $(e.target).closest(".album"),
			albumName = "album-" + album.data("album-id"),
			album = this.el.find("." + albumName);

		this.albumContent = album.find(".content");

		this.switchAlbum(album);
		this.applyScroll();
		this.openPopUp();
	}
	function switchAlbum(album){
		album.addClass("active").siblings(".album").removeClass("active");
	}
	function openPopUp(){
		this.popUp.open();
	}
	function closePopUp(){
		this.destroyScroll();
		this.albumContent = null;
	}
	function applyScroll(){
		if(this.albumContent) this.albumContent.perfectScrollbar();	
	}
	function destroyScroll(){
		if(this.albumContent) this.albumContent.perfectScrollbar("destroy");
	}

	return music;

})(jQuery, window);