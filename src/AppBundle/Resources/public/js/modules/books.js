var app = app || {};

app.books = (function($, root){

	var books = {
		cell: $(".cell"),
		booksHolder: $("#books-holder"),
		container: null,
		popUp: null,
		initialize: initialize,
		_events: _events,
		handleBook: handleBook,
		handleClose: handleClose,
		switchBook: switchBook,
		applyScroll: applyScroll,
		destroyScroll: destroyScroll
	}

	function initialize(){
		this._events();
		this.popUp = new app.PopUp("#books-holder");
	}
	function _events(){
		this.cell.on("click", $.proxy(this.handleBook, this));
		$(root).on("popUpClosed", $.proxy(this.handleClose, this));
	}
	function handleBook(e){
		var cell = $(e.target).closest(".cell"),
			book = this.booksHolder.find(".book-" + cell.data("book-id"));

		this.container = book.find(".content");

		this.switchBook(book);
		this.applyScroll();
		this.popUp.open();
	}
	function handleClose(e){
		this.destroyScroll();
		this.container = null;
	}
	function switchBook(book){
		book.addClass("active").siblings(".book").removeClass("active");
	}
	function applyScroll(){
		if(this.container) this.container.perfectScrollbar();		
	}
	function destroyScroll(){
		if(this.container) this.container.perfectScrollbar("destroy");
	}

	return books;

})(jQuery, window);