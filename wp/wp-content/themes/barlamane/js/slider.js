;(function(factory){ 
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if (typeof exports !== 'undefined') {
		module.exports = factory(require('jquery'));
	} else {
		factory(jQuery);
	}
})(

function($){

	var slider = $('.hybrid-slider'),
		totalSlides = slider.data( 'totalslides' ),
		posts = slider.find('.posts'),
		currSlide = 1;

	var Hybrid = function(element, settings) {
		var instanceUid = 0;
		this.defaults = {
			slideDuration: '3000',
			speed: 500,
			previousArrow: '.arrow-right',
			nextArrow: '.arrow-left'
		};

		this.settings = $.extend({},this,this.defaults,settings);
		this.initials = {
			currSlide : currSlide,
			$currSlide: null,
			totalSlides : false,
			csstransitions: false
		};



		$.extend(this,this.initials);
		this.$el = $(element);
		this.paused = false;
		this.changeSlide = $.proxy(this.changeSlide,this);
		this.pauseSlide = $.proxy(this.pauseSlide,this);
		this.autoAnimation = $.proxy(this.autoAnimation,this);
		this.instanceUid = instanceUid++;
		this.init();
		$(window).resize(function() {
			animeReady();
			var width = slider.parent().width();
			var transitionWidth = width * ( currSlide - 1 );
			posts.css('transform', 'translate3d( ' + transitionWidth + 'px, 0px, 0px)');
		});

		$(window).load(function(){
			//slider.hide().delay( 2000 ).show();
			slider.removeClass('hide');
			posts.find( '.post' ).addClass('transition');
		});
	};



	Hybrid.prototype.init = function() {		
		this.csstransitionsTest();
		this.build();
		this.events();
		this.activate();
		this.initTimer();
		animeReady();
	};

	function animeReady() {
		var width = slider.parent().parent().width();
		var height = width * 0.5625;
		slider.width( width );
		slider.height( height );
		posts = slider.children( '.posts' );
		posts.width( totalSlides * width );
		posts.find( '.post' ).width( width );
		posts.css('transition', '0.500s');

		/*
		for (var i = 0; i < totalSlides; i++) { 
			posts.children( '#slider-post-' + ( i + 1 ) ).css('left', width * i );
		}
		*/
	}

	Hybrid.prototype.csstransitionsTest = function(){
		var elem = document.createElement('modernizr');
		//A list of properties to test for
		var props = ["transition","WebkitTransition","MozTransition","OTransition","msTransition"];
		//Iterate through our new element's Style property to see if these properties exist
		for ( var i in props ) {
			var prop = props[i];
			var result = elem.style[prop] !== undefined ? prop : false;
			if (result){
				this.csstransitions = result;
				break;
			}
		}
	};

	Hybrid.prototype.build = function(){
		var $slidemenu = $(".slidemenu-container").append('<ul class="slidemenu" >').find('.slidemenu');
		//for(var i = 0; i < totalSlides; i++) $slidemenu.append('<li data-index='+i+'>'+(i+1));
		for(var i = 0; i < totalSlides; i++) $slidemenu.append('<li data-index=' + ( i + 1 ) +'>' + ( i + 1 ) +'</li>');
	};

	/**
	 * Activates the first slide
	 * Activates the first indicator
	 * @params void
	 * @returns void
	 *
	 */ 

	Hybrid.prototype.activate = function(){
		// First slider
		//this.$currSlide = this.$el.find('.slide').eq(this.getCookie()).addClass('active');
		this.$currSlide = this.$el.find('.slide').eq(0).addClass('active');
		$(".slidemenu-container").find('.slidemenu li').eq(0).addClass('active');
	};

	/**
	 * Associate event handlers to events
	 * For arrow events, we send the placement of the next slide to the handler
	 * @params void
	 * @returns void
	 *
	 */

	Hybrid.prototype.events = function(){
		this.$el.find('.arrow-left').on( "click", {direction:'right'}, this.changeSlide);
		this.$el.find('.arrow-right').on( "click", {direction:'left'}, this.changeSlide);
		$(".slidemenu-container").find('.slidemenu li').on('click', this.changeSlide);
		this.$el.find('.pause').on('click','.pause',this.pauseSlide);
	};
		
	/**
	 * TIMER Functions
	 */

	Hybrid.prototype.clearTimer = function(){
		if (this.timer) clearInterval(this.timer);
	};

	Hybrid.prototype.initTimer = function(){
		this.timer = setInterval(this.autoAnimation, this.settings.slideDuration);
	};

	Hybrid.prototype.startTimer = function(){
		this.initTimer();
		this.throttle = false;
	};

	Hybrid.prototype.changeSlide = function(e){
		//Ensure that animations are triggered one at a time
		if (this.throttle)
			return;
		this.throttle = true;

		//Stop the timer as the animation is getting carried out
		this.clearTimer();

		// Returns the animation direction (left or right)
		var direction = this._direction(e);
		// Selects the next slide
		var animate = this._next(e,direction);
		if ( !animate ) return;
		//Active the next slide to scroll into view
		var $nextSlide = this.$el.find('.slide').eq(currSlide-1).addClass('active');
		this._cssAnimation($nextSlide,direction);
		this.editCookie(currSlide);

	};

	Hybrid.prototype.autoAnimation = function(){
		if(!this.paused){
			this.changeSlide();
		}
	};

	/**
	 *	Pause timer function
	 */
	Hybrid.prototype.pauseSlide = function(){
		if(!this.paused){
			this.$el.find('.pause .fa-pause').hide();
			this.$el.find('.pause .fa-play').show();
			this.paused=true;
		}
		else{
			this.$el.find('.pause .fa-pause').show();
			this.$el.find('.pause .fa-play').hide();
			this.paused=false;
		}
	};

	/**
	 * Returns the animation direction, right or left
	 * @params	object	event
	 * @returns strong	animation direction
	 *
	 */

	Hybrid.prototype._direction = function(e){
		var direction;
		// Default to forward movement
		if (typeof e !== 'undefined'){
			direction = (typeof e.data === 'undefined' ? 'right' : e.data.direction);
		} else {
			direction = 'right';
		}
		return direction;
	};

	/**
	 * Updates our plugin with the next slide number
	 * @params	object	event
	 * @params	string	animation direction
	 * @returns boolean continue to animate?
	 *
	 */

	Hybrid.prototype._next = function(e,direction){
		// If the event was triggered by a slide indicator, we store the data-index value of that indicator
		var index = (typeof e !== 'undefined' ? $(e.currentTarget).data('index') : undefined);
		//Logic for determining the next slide
		switch(true){
			//If the event was triggered by an indicator, we set the next slide based on index
			case( typeof index !== 'undefined'):
				if (currSlide === index){
					this.startTimer();
					return false;
				} 
				currSlide = index;
			break;
			case(direction === 'right' && currSlide < totalSlides):

				currSlide++;

			break;

			case(direction === 'right'):

				currSlide = 1;

			break;
			case(direction === 'left' && currSlide === 1):
				currSlide = totalSlides ;
			break;
			case(direction === 'left'):
				currSlide--;
			break;
		}
		return true;
	};

	/**
	 * CSS Animation
	 */

	Hybrid.prototype._cssAnimation = function($nextSlide,direction){
		//Init CSS transitions
		setTimeout(function(){
			this._updateMenu();
		}.bind(this),100);
		var width = this.$el.parent().width();
		var transitionWidth = width * ( currSlide - 1 );
		posts.css('transform', 'translate3d( ' + transitionWidth + 'px, 0px, 0px)');

		//CSS Animation Callback
		//After the animation has played out, remove CSS transitions
		//Remove unnecessary classes
		//Start timer
		setTimeout(function(){
			this.$el.removeClass('transition');
			//this.removeCSSDuration();
			this.$currSlide.removeClass('active shift-left shift-right');
			this.$currSlide = $nextSlide.removeClass(direction);
			this.startTimer();
		}.bind(this),100 + this.settings.speed);

	};

	/**
	 * JS Animation
	 */

	Hybrid.prototype._jsAnimation = function($nextSlide,direction){
		//Cache this reference for use inside animate functions
		var _ = this;
		// See CSS for explanation of .js-reset-left
		if(direction === 'right') { 
			_.$currSlide.addClass('js-reset-left');
		}
		var animation = {};
		animation[direction] = '0%';
		var animationPrev = {};
		animationPrev[direction] = '100%';


		//Animation: Current slide
		this.$currSlide.animate(animationPrev,this.settings.speed);

		//Animation: Next slide
		$nextSlide.animate(animation,this.settings.speed,'swing',function(){
			//Get rid of any JS animation residue
			_.$currSlide.removeClass('active js-reset-left').attr('style','');
			//Cache the next slide after classes and inline styles have been removed
			_.$currSlide = $nextSlide.removeClass(direction).attr('style','');
			_._updateMenu();
			_.startTimer();
		});
	};



	/**
	 * Add the CSSTransition duration to the DOM Object's Style property
	 * We trigger this function just before we want the slides to animate
	 * @params void
	 * @returns void
	 *
	 */

	Hybrid.prototype.addCSSDuration = function(){
		var _ = this;
		this.$el.find('.slide').each(function(){
			this.style[_.csstransitions+'Duration'] = _.settings.speed+'ms';
		});
	}

	/*
	 * Remove the CSSTransition duration from the DOM Object's style property
	 * We trigger this function just after the slides have animated
	 * @params void
	 * @returns void
	 *
	 */

	Hybrid.prototype.removeCSSDuration = function(){
		var _ = this;
		this.$el.find('.slide').each(function(){
			this.style[_.csstransitions+'Duration'] = '';
		});
	};


	/**
	 * Update Menu Item
	 */
	Hybrid.prototype._updateMenu = function(){
		$(".slidemenu-container").find('.slidemenu li').removeClass('active').eq(currSlide - 1).addClass('active');
	};



	/**
	 * Cookies
	 */

	Hybrid.prototype.getCookie = function() {
		var name = "slide_number=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) === ' ') c = c.substring(1);
			if (c.indexOf(name) === 0) return c.substring(name.length,c.length);
		}
		return "";
	};	

	Hybrid.prototype.editCookie = function(number){
		document.cookie = "slide_number="+number+";";
	};

	/**
	 * Initialize the plugin once for each DOM object passed to jQuery
	 * @params	object	options object
	 * @returns void
	 *
	 */

	$.fn.Hybrid = function(options){
		return this.each(function(index,el){
			el.Hybrid = new Hybrid(el,options);
		});
	};
});