(function(factory){ 
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if (typeof exports !== 'undefined') {
		module.exports = factory(require('jquery'));
	} else {
		factory(jQuery);
	}
})(
	function($){
		var Hybrid = (function(element, settings){
			var instanceUid = 0;
			function _Hybrid(element, settings){
				this.defaults = {
					slideDuration: '3000',
					speed: 500,
					previousArrow: '.arrow-right',
					nextArrow: '.arrow-left'
				};
				this.settings = $.extend({},this,this.defaults,settings);
	
				// This object holds values that will change as the plugin operates
				this.initials = {
					currSlide : this.getCookie(),
					$currSlide: null,
					totalSlides : false,
					csstransitions: false
				};
				$.extend(this,this.initials);
				this.$el = $(element);
				this.paused=false;
				this.changeSlide = $.proxy(this.changeSlide,this);
				this.pauseSlide = $.proxy(this.pauseSlide,this);
				this.autoAnimation = $.proxy(this.autoAnimation,this);
				this.init();
				this.instanceUid = instanceUid++;
			}
			return _Hybrid;
	})();

	Hybrid.prototype.init = function(){
		this.csstransitionsTest();
		this.build();
		this.events();
		this.activate();
		this.initTimer();
	};

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
		var $slidemenu = this.$el.append('<ul class="slidemenu" >').find('.slidemenu');
		this.totalSlides = this.$el.find('.slide').length;
		for(var i = 0; i < this.totalSlides; i++) $slidemenu.append('<li data-index='+i+'>'+(i+1));
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
		this.$currSlide = this.$el.find('.slide').eq(this.getCookie()).addClass('active');
		this.$el.find('.slidemenu li').eq(this.getCookie()).addClass('active');
	};
	
	/**
	 * Associate event handlers to events
	 * For arrow events, we send the placement of the next slide to the handler
	 * @params void
	 * @returns void
	 *
	 */
	Hybrid.prototype.events = function(){
		$('body')
			.on('click',this.settings.previousArrow,{direction:'right'},this.changeSlide)
			.on('click',this.settings.nextArrow,{direction:'left'},this.changeSlide)
			.on('click','.slidemenu li',this.changeSlide)
			.on('click','.controllers .pause',this.pauseSlide);
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
	
	/**
	 * MAIN LOGIC HANDLER
	 * Triggers a set of subfunctions to carry out the animation
	 * @params	object	event
	 * @returns void
	 *
	 */
	Hybrid.prototype.changeSlide = function(e){
		//Ensure that animations are triggered one at a time
		if (this.throttle) return;
		this.throttle = true;
		//Stop the timer as the animation is getting carried out
		this.clearTimer();
		// Returns the animation direction (left or right)
		var direction = this._direction(e);
		// Selects the next slide
		var animate = this._next(e,direction);
		if (!animate) return;
		//Active the next slide to scroll into view
		var $nextSlide = this.$el.find('.slide').eq(this.currSlide).addClass(direction + ' active');
		if (!this.csstransitions){
			this._jsAnimation($nextSlide,direction);
		} else {
			this._cssAnimation($nextSlide,direction);
		}
		
		this.editCookie(this.currSlide);
	};
	Hybrid.prototype.autoAnimation = function(e){
		if(!this.paused){
			this.changeSlide();
		}
	};
	
	/**
	 *	Pause timer function
	 */
	Hybrid.prototype.pauseSlide = function(e){
		if(!this.paused){
			this.$el.find('.controllers .pause .fa-pause').hide();
			this.$el.find('.controllers .pause .fa-play').show();
			this.paused=true;
		}
		else{
			this.$el.find('.controllers .pause .fa-pause').show();
			this.$el.find('.controllers .pause .fa-play').hide();
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
				if (this.currSlide == index){
					this.startTimer();
					return false;
				} 
				this.currSlide = index;
			break;
			case(direction == 'right' && this.currSlide < (this.totalSlides - 1)):
				this.currSlide++;
			break;
			case(direction == 'right'):
				this.currSlide = 0;
			break;
			case(direction == 'left' && this.currSlide === 0):
				this.currSlide = (this.totalSlides - 1);
			break;
			case(direction == 'left'):
				this.currSlide--;
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
			this.$el.addClass('transition');
			//this.addCSSDuration();
			this.$currSlide.addClass('shift-'+direction);
		}.bind(this),100);

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
		if(direction == 'right') _.$currSlide.addClass('js-reset-left');
		
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
	}

	/**
	 * Update Menu Item
	 */
	Hybrid.prototype._updateMenu = function(){
		this.$el.find('.slidemenu li').removeClass('active').eq(this.currSlide).addClass('active');
	};

	/**
	 * Cookies
	 */
	Hybrid.prototype.getCookie = function() {
		var name = "slide_number=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		}
		return "";
	}
	Hybrid.prototype.editCookie = function(number){
		document.cookie = "slide_number="+number+";";
	}

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

// Ticker
(function( $ ){
	$.fn.hybridTicker = function( settings )
	{
		//Our Pluging Settings
		var tSets = $.extend(
			{
				speed         : 300,
				direction     : "rtl",
				feed          : '#ticker-feed',
				feedContainer : '#news-ticker .ticker-container',
				feedName      : '#news-ticker .ticker-name'
			}, settings);

		return this.each(function()
		{
			var feedcontainer=$(tSets.feedContainer),
				feed=$(tSets.feed),
				feedWith=feed.width(),
				feedPosition=feedcontainer.width()+10,
				feedName=$(tSets.feedName);
			$(tSets.feed).show().css("margin-right", feedcontainer.width() + "px");
			feedName.show();
			function tickIt(){
				if(feedPosition > - feedWith-10){
					feedPosition--;
				}
				else{
					feedPosition=feedcontainer.width()+10;
				}
				feed.css("margin-right", feedPosition + "px");
				setTimeout(tickIt,15);
			}
			tickIt();
		});
		
	};

	var args = {
		previousArrow : '.arrow-left', //A jQuery reference to the right arrow
		nextArrow : '.arrow-right', //A jQuery reference to the left arrow
		speed : 10, //The speed of the animation (milliseconds)
		slideDuration : 8000 //The amount of time between animations (milliseconds)
	};
	$('.hybrid-slider').Hybrid(args);
}( jQuery ));

$('body').click(function(e){
    if (e.target === this) {
        window.location = "http://minyadina.ma/"
    }
});