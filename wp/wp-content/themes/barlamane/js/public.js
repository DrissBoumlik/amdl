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
}( jQuery ));

jQuery(document).ready(function($){
	var args = {
		speed         : 300,
		direction     : "ltr",
		feed          : '#ticker-feed',
		feedContainer : '#news-ticker .ticker-container'
	};
	$('#news-ticker').css("display", "block");
	$('#news-ticker').hybridTicker();
	var nav_toggle_bars = $('#main-nav-toggle .fa-bars');
	var nav_toggle_times = $('#main-nav-toggle .fa-times');

	$('.format-16-9').height($('.format-16-9').width() * 0.5625);
	$('.youtube-video').height($('.youtube-video').width() * 0.5625);

    $('#habillage').click(function(){
		window.open('https://www.youtube.com/watch?v=mSqAwgqgr-E&feature=youtu.be', '_blank');
    });

	$(document).ready( function() {
		var args = {
			previousArrow : ".arrow-right",
			nextArrow : ".arrow-left",
			speed : 10,
			slideDuration : 8000
		};
		jQuery(".hybrid-slider").Hybrid(args);
		$('.slider-container').show();
		$('.format-16-9').height($('.format-16-9').width() * 0.5625);
		$('.youtube-video').height($('.youtube-video').width() * 0.5625);
	});

	$(window).resize(function() {
		$('.format-16-9').height($('.format-16-9').width() * 0.5625);
		$('.youtube-video').height($('.youtube-video').width() * 0.5625);
	});

	$('#main-nav').on('click','#main-nav-toggle', function() {
		var ul=$('#main-nav ul');
		if(ul.hasClass('show-ul')){
			ul.removeClass('show-ul');
			nav_toggle_times.hide();
			nav_toggle_bars.show();
		}
		else{
			ul.addClass('show-ul');
			nav_toggle_bars.hide();
			nav_toggle_times.show();
		}
	});

	/* Buzzeff */
	window._ttf = window._ttf || [];
	_ttf.push({
		   pid          : 50489
		   ,lang        : "ar"
		   ,slot        : '.post-content .content > p'
		   ,format      : "inread"
		   ,components  : { skip: {delay : 31}}
		   ,css         : "margin: 0px 0px 20px;"
	});
	 
	(function (d) {
			var js, s = d.getElementsByTagName('script')[0];
			js = d.createElement('script');
			js.async = true;
			js.src = '//cdn.teads.tv/media/format.js';
			s.parentNode.insertBefore(js, s);
	})(window.document);
})