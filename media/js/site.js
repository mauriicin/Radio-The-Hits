/*! Rádio TheHits - Todos os direitos reservados - by @_theFX */

/* 
radio = {
	locutor: null,
	programa: null,
	tempo: null,
	avatar: null,
	info: function(first) {
		if(first == true || site.active == true) {
			if(first != null) {
				$(".r-broadcaster, .r-program").html('...');
				$(".r-time").attr('title', '...');
			}

			$.ajax({
				url: '/lib/radio_info.php',
				type: 'get',
				dataType: 'json',
				success: function (data) {
					$(".r-broadcaster").html(data.locutor);
					$(".r-program").html(data.programa);
					$(".r-time").attr('title', data.tempo);
					$(".r-img").css('background-image', 'url('+data.avatar+')');

					radio.locutor = data.locutor;
					radio.programa = data.programa;
					radio.tempo = data.tempo;
					radio.avatar = data.avatar;
					radio.autodj = data.autodj;

					((data.liked == 'yes')) ? $(".r-liked").addClass('active').attr('onclick', 'radio.heart()') : $(".r-liked").removeClass('active').attr('onclick', 'radio.heart()');
				}
			});
		}
	},
	heart: function() {
		heart = $("#player .btn.heart");
		
		if(heart.hasClass('active')) {
			type = 'dislike';
			heart.removeClass('active');
		} else {
			type = 'like';
			heart.addClass('active');
		}
		$.ajax({
			url: '/lib/radio_like.php?type='+type,
			type: 'get'
		});
	},
} */

radio = {
	locutor: null,
	programa: null,
	tempo: null,
	avatar: null,
	loaded: false,
	info: function(first) {
		if(first == true || site.active == true) {
			if(first != null) {
				$(".r-broadcaster, .r-program").html('...');
				$(".r-time").attr('title', '...');
			}

			$.ajax({
				url: '/lib/radio_info.php',
				type: 'get',
				dataType: 'json',
				success: function (data) {
					$(".r-broadcaster").html(data.locutor);
					$(".r-program").html(data.programa);

					radio.locutor = data.locutor;
					radio.programa = data.programa;
					radio.avatar = data.avatar;
					radio.autodj = data.autodj;
				}
			});
		}
	},
	heart: function() {
		heart = $(".r-liked");
		
		if(heart.hasClass('active')) {
			type = 'dislike';
			heart.removeClass('active');
		} else {
			type = 'like';
			heart.addClass('active');
		}
		/*
		$.ajax({
			url: '/lib/radio_like.php?type='+type,
			type: 'get'
		});*/
	},
	pedidos: function() {
		peds  = '<form action="javascript:radio.pedidosS();" method="post" class="form-pedidos">';
		peds += '<div class="form-pedidos-stats"></div>';

		peds += '<div class="form-input-2"><input type="text" id="r-ped-name" placeholder="Seu nome"></div>';
		peds += '<div class="form-input-2"><input type="text" id="r-ped-singer" placeholder="Nome do artista" class="autocomplete-artist"></div>';
		peds += '<div class="form-input-2"><input type="text" id="r-ped-music" placeholder="Nome da música" class="autocomplete-music" onfocus="radio.pedidosM();"></div>';

		peds += '<div class="form-input-2"><button type="submit">Enviar</button><br></div>';
		peds += '</form>';

		ctn.alerta("Fazer pedido", peds);

		$('.autocomplete-artist').autocomplete({ lookup: r_list_artists });
	},
	pedidosS: function() {
		nome = $("#r-ped-name").val();
		artista = $("#r-ped-singer").val();
		musica = $("#r-ped-music").val();

		if(artista == '' || musica == '') {
			$(".form-pedidos").effect('shake');
		} else {
			$(".form-pedidos").animate({'opacity': 0.5}, 'fast');
			$(".loader-corner").addClass('show');

			$.ajax({
				url: '/lib/radio_pedidos.php',
				type: 'POST',
				data: {'nome': nome, 'artista': artista, 'musica': musica},
			}).done(function(data) {
				$(".form-pedidos").animate({'opacity': 1}, 'fast');
				$(".loader-corner").removeClass('show');

				if(data == 'success') {
					$(".form-pedidos").html("Enviado com sucesso! Seu pedido tocará na nossa rádio em breve.");
				} else {
					$(".form-pedidos-stats").html(data);
				}
			});
			
		}
	},
	pedidosM: function() {
		artista = $("#r-ped-singer").val();

		$.ajax({
			url: '/lib/ph_musics_get.php',
			type: 'POST',
			dataType: 'JSON',
			data: {'artista': artista}
		}).done(function(data) {
			$('.autocomplete-music').autocomplete({ lookup: data.musics });
		});
	}
}

ctn = {
	slide: function(id) {
		$.get("/lib/slide_click.php?id="+id);
	},
	alerta: function(titulo, conteudo) {
		$.fancybox('<div id="fancy-alerta"><div class="titulo">'+titulo+' <span class="f-right" onclick="jQuery.fancybox.close();"><i class="icon-cancel"></i></span></div><div class="content">'+conteudo+'</div></div>');
	}
}

site = {
	active: true,
	reload: function() {
		$('.tip').tipsy({
			gravity: $.fn.tipsy.autoNS,
			fade: true,
			html: true
		});

		$('.tip-2').tipsy({
			gravity: $.fn.tipsy.autoNS,
			trigger: "focus",
			fade: true,
			html: true
		});

		$(".txt-truncate").dotdotdot({
			wrap		: 'letter',
		});
	},
	start: function() {
		$('.tip').tipsy({
			gravity: $.fn.tipsy.autoNS,
			fade: true,
			html: true
		});

		$('.tip-2').tipsy({
			gravity: $.fn.tipsy.autoNS,
			trigger: "focus",
			fade: true,
			html: true
		});

		$('#slider').nivoSlider({
			pauseTime: 4000,
			directionNav: false,
			controlNav: false,
			controlNavThumbs: false,
			randomStart: true
		});

		$(".txt-truncate").dotdotdot({
			wrap		: 'letter',
		});
	},
	updateInterval: 0,
	update: function() {
		if(site.active) {
			$.ajax({
				url: '/lib/update.php',
				type: 'GET'
			}).done(function(data) {
				if(data != '') {
					ctn.alerta("Alerta", data);
				}
			});
		}

		clearTimeout(site.updateInterval);
		site.updateInterval = setTimeout(function() {site.update();}, 30000);
	}
}

$(document).ready(function() {
	site.start();
	site.update();
	radio.info();
})

$(window).load(function() {
	$("nav.menu .sub-menu").each(function() {
		a = $(this).attr('id');
		b = a.split('-');

		id  = b[1];

		link = $('nav.menu a[id="link-'+id+'"]');

		off = link.offset();
		off_left = off.left;
		
		$(this).css('left', off_left);
	});
})

$(window).focus(function() {
	site.active = true;

	clearTimeout(site.updateInterval);
	site.update();
});

$(window).blur(function() { site.active = false; });

var ctrlDown = false;
var ctrlKey = 17, f5Key = 116, rKey = 82;

$(document).keydown(function( e ) {
	if( e.keyCode == f5Key )
	{
		parent.location.reload();
		e.preventDefault( );
	}

	if( e.keyCode == ctrlKey )
		ctrlDown = true;
	if( ctrlDown && ( e.keyCode == rKey ) )
	{
		parent.location.reload();
		e.preventDefault( );
	}

}).keyup(function(e) {
	if (e.keyCode == ctrlKey)
		ctrlDown = false;
});

menu_opened = 0;

$("nav.menu a").click(function(event) {
	id = $(this).attr('id');

	if(typeof id !== typeof undefined && id !== false) {
		event.preventDefault();

		a = id.split('-');
		sub  = a[1];

		sub_menu = $("nav.menu #sub-"+sub);

		if(menu_opened == sub) {
			sub_menu.fadeOut();
			menu_opened = 0;
		} else {
			if(menu_opened == 0) {
				sub_menu.fadeIn();
			} else {
				$("nav.menu .sub-menu[id!='sub-"+sub+"']").fadeOut(function() {
					sub_menu.fadeIn();
				});
			}

			menu_opened = sub;
		}
	}
});

$(".form-send").submit(function(event) {
	form_empty = false;

	if($(this).hasClass('form-full')) {
		$(this).find('input').each(function(index, el) {
			if($(this).val() == '') {
				form_empty = true;
			}
		});
	}

	if(form_empty) {
		$(this).effect('shake');
		event.preventDefault();
	} else {
		submit = $(this).find('[type="submit"]');
		submit.attr('disabled', true);

		$(".loader-corner").addClass('show');
	}
});
