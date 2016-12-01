;(function(root){

	Handlebars.registerHelper("grouped_each", function(every, items, options){
		var out = "", outItems = [], key = 0;

		if(items && items.length > 0){
			for(key in items){
				if(key > 0 && key % every === 0){
					out += options.fn(outItems);
					outItems = [];
				}
				outItems.push(items[key]);
			}
			out += options.fn(outItems);
		}
		return out;
	});

	var months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];

	Handlebars.registerHelper("formatDate", function(date, options){
		var parsed = Date.parse(date),
			date = new Date(parsed);

		return date.getDate() + " " + months[date.getMonth()] + " " + date.getFullYear();
	});
	Handlebars.registerHelper("fomatHtmlDate", function(date, options){
		var parsed = Date.parse(date),
			date = new Date(parsed);

		return "<span class='day'>"+ date.getDate() +"</span>\
				<span class='year'>"+ months[date.getMonth()] +"</span>\
				<span class='month'>"+ date.getFullYear() +"</span>";
	});

	Handlebars.registerHelper("truncate", function(size, item, options){
		return item.substr(0, size);
	});

})(window);