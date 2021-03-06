var baseAjax = 'vendor/ajax/';
var thehits = {
	radio: function(type){
		$('.' + type).text('...');
		$.get(baseAjax + 'status.json?type=' + type, function(r){
			switch(type){
				case 'locutor':
					$('.locutor').text(r);
				break;

				case 'programa':
					$('.programa').text(r);
				break;
			}
		});
	}
}

$(document).ready(function() {
	thehits.radio('locutor');
	thehits.radio('programa');

	$('ul.control-volume li').slider({
		orientation: "vertical",
		range: "min",
		min: 0,
		max: 100,
		value: 100,
		slide: function(event, ui){
			if( ui.value == 0 ){
				$('.icon.setting').removeClass('stop').addClass('play');
			} else {
				$('.icon.setting').removeClass('play').addClass('stop');
			}
			window.top.player.jwplayer().setVolume(ui.value);
		}
	});

	$('.icon.setting').click(function(){
		if( $(this).hasClass('play') ) {
			$(this).addClass('stop');
			$(this).removeClass('play');
			window.top.player.jwplayer().setVolume(100);
		} else if( $(this).hasClass('stop') ){
			$(this).removeClass('stop');
			$(this).addClass('play');
			window.top.player.jwplayer().setVolume(0);
		}
	});

	$('a[href*=#]').click(function(e) {
		e.preventDefault();
	});

	$('[data-mt]').each(function(){
		$(this).css('margin-top', $(this).attr('data-mt') + 'px');
	});

	$('[data-href]').each(function(){
		$(this).wrap('<a href="' + $(this).attr('data-href') + '" target="_blank"></a>');
	});

	$('.icon.volume').click(function() {
		var elem = $(this).children('ul.control-volume');
		if( elem.hasClass('o') ) {
			elem.removeClass('o');
			elem.slideUp(150);
		} else {
			elem.addClass('o');
			elem.slideDown(150);
		}
	});

	$('ul.control-volume').click(function(e) {
		e.stopPropagation();
	});

	$('.locutor, .programa').click(function(e) {
		thehits.radio( $(this).attr('class') );
		e.preventDefault();
	});

	$('.btn[data-color]').each(function(){
		$(this).css('background-color', $(this).attr('data-color'));
	});
});