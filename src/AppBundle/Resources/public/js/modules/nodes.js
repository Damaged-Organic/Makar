var app = app || {};

app.nodes = (function($, root){

	root.requestAnimationFrame = root.requestAnimationFrame || 
									root.webkitRequestAnimtionFrame ||
									root.mozRequestAnimationFrame ||
									root.msRequestAnimationFrame ||
									root.oRequestAnimationFrame ||
									function(callback){
										root.setTimeout(callback, 1000 / 60);
									};

	root.cancelAnimationFrame = root.cancelAnimationFrame || 
									root.webkitCancelAnimationFrame ||
									root.mozCancelAnimationFrame ||
									root.msCancelAnimationFrame ||
									root.oCancelAnimationFrame;


	var Nodes = {
		el: $("#particles-holder"),
		_width: 0,
		_height: 0,
		_offset: {},
		//node options
		density: 6,
		sensivity: 3,
		radius: 1.5,
		points: [],
		//data vars
		photo: null,
		photoData: null,
		animation: null,
		mouse: {
			x: -10000,
			y: -10000,
			ox: -10000,
			oy: -10000,
			isOut: true
		},
		initialize: function(){
			this._bindEvents();

			this.canvas = document.getElementById("particles");
			this.context = this.canvas.getContext("2d");
			this.context.globalCompositeOperation = "lighter";

			this._width = this.el.outerWidth();
			this._height = this.el.outerHeight();
			this._offset = this.el.offset();

			this.canvas.width = this._width;
			this.canvas.height = this._height;
			
			this._loadData("bundles/app/images/sign-white.png");
		},
		_bindEvents: function(){
			this.el.on("mouseover", $.proxy(this.handleOver, this))
			this.el.on("mousemove", $.proxy(this.handleMouse, this));
			this.el.on("mouseout", $.proxy(this.handleOut, this));
			$(window).on("resize", $.proxy(this.handleResize, this));
		},
		_loadData: function(source){
			var photo = new Image();

			photo.onload = $.proxy(function(){
				this.photo = photo;
				this.drawPhoto(photo);
			}, this);
			photo.src = source;
		},
		drawPhoto: function(){
			var tmp_cnvs = document.createElement("canvas"),
				tmp_cntx = tmp_cnvs.getContext("2d");

			tmp_cnvs.width = this._width;
			tmp_cnvs.height = this._height;

			tmp_cntx.drawImage(this.photo, (this._width - this.photo.width) / 2, (this._height - this.photo.height) / 2);
			this.photoData = tmp_cntx.getImageData(0, 0, this._width, this._height);

			this.preparePoints();
			this.draw();
		},
		preparePoints: function(){
			var colors = this.photoData.data,
				pixel = null,
				color, i, j;

			this.points = [];

			for(i = 0; i < this._height; i += this.density){
				for(j= 0; j < this._width; j += this.density){

					pixel = (j + i * this.photoData.width) * 4;

					if(colors[pixel] >= 255 && colors[pixel + 1] >= 255 && colors[pixel + 2] >= 255 && colors[pixel + 3] >= 0){
						color = "rgba("+ colors[pixel] +", "+ colors[pixel + 1] +", "+ colors[pixel + 2] +", 1)";
						this.points.push({x: j, y: i, ox: j, oy: i, color: color, marked: false});
					} 
				}
			}
		},
		updatePoints: function(){
			var i, point, angle, distance, dx = 0, dy = 0;

			for(i = 0; i < this.points.length; i++){
				point = this.points[i];

				dx = this.mouse.x - point.x;
				dy = this.mouse.y - point.y;

				angle = Math.atan2(point.y - this.mouse.y, point.x - this.mouse.x);
				distance = this.sensivity * 100 / Math.sqrt(dx * dx + dy * dy);

				if(distance >= 4.5){
					this.context.lineWidth = 0.05;
					this.context.strokeStyle = "rgba(255, 255, 255, "+ 1 / distance +")";

					this.context.beginPath();
					this.context.moveTo(this.mouse.x, this.mouse.y);
					this.context.lineTo(point.x, point.y);
					this.context.closePath();

					this.context.stroke();
					point.marked = true;
				} else{
					point.marked = false;
				}

				point.x += Math.cos(angle) * distance + (point.ox - point.x) * 0.05;
				point.y += Math.sin(angle) * distance + (point.oy - point.y) * 0.05;
			}
		},
		backOriginPoints: function(){
			if(this.mouse.x <= this.mouse.ox || this.mouse.y <= this.mouse.oy) return;
			this.mouse.x -= 10;
			this.mouse.y -= 10;
		},
		drawPoints: function(){
			var i, point;

			for(i = 0; i < this.points.length; i++){
				point = this.points[i];

				this.context.fillStyle = point.color;

				this.context.beginPath();
				this.context.arc(point.x, point.y, point.marked ? this.radius + .5 : this.radius, 0, Math.PI * 2, true);				
				this.context.closePath();
				this.context.fill();
			}
		},
		draw: function(context){
			this.animation = requestAnimationFrame($.proxy(this.draw, this));
			this.context.clearRect(0, 0, this._width, this._height);

			if(this.mouse.isOut) this.backOriginPoints()
			this.updatePoints();
			this.drawPoints();
		},
		handleOver: function(e){
			this.mouse.isOut = false;
		},
		handleMouse: function(e){
			this.mouse = {x: e.pageX - this._offset.left, y: e.pageY - this._offset.top};
		},
		handleOut: function(e){
			this.mouse.isOut = true;
		},
		handleResize: function(e){
			cancelAnimationFrame(this.animation);

			this._width = this.el.outerWidth();
			this._height = this.el.outerHeight();
			this._offset = this.el.offset();

			this.canvas.width = this._width;
			this.canvas.height = this._height;

			this.drawPhoto();
		}
	}
	return Nodes;

})(jQuery, window);