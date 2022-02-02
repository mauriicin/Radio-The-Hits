/*! Rádio TheHits - Todos os direitos reservados - by @_theFX */

rTop = {
	finished: false,
	interval: 0,
	load: function() {
		if(radio.loaded == null) {
			setTimeout("rTop.load();", 1000);
		} else {
			$(".loader-corner").removeClass('show');

			$.ajax({
				url: '/lib/radio_top.php',
				type: 'GET'
			}).done(function(data) {
				$(".rtop-load").html(data);
				site.reload();
				rTop.start();
			});
		}
	},
	start: function() {
		ts = parseInt($(".top-counter-time").html()) * 1000;

		$('.top-counter-time').countdown({
			timestamp   : ts,
			callback    : function(days, hours, minutes, seconds){
				var message = "";

				message += days + " dia" + ( days==1 ? '':'s' ) + ", ";
				message += hours + " hora" + ( hours==1 ? '':'s' ) + ", ";
				message += minutes + " minuto" + ( minutes==1 ? '':'s' ) + " e ";
				message += seconds + " segundo" + ( seconds==1 ? '':'s' );

				$('.top-counter-time').html(message);

				if(days == 0 && hours == 0 && minutes == 0 && seconds == 0) {
					$('.rtop-load').html('<center>A votação para essa semana já encerrou. Você pode conferir o resultado ao lado.</center>');
					rTop.finished = true;

					$.ajax({
						url: '/lib/radio_top_result.php?get',
						type: 'GET'
					}).done(function(data) {
						$(".top-result").html(data);
					});
					
				}
			}
		});
	},
	vote: function(id, tipo) {
		$.ajax({
			url: '/lib/radio_top_vote.php?id='+id+'&type='+tipo,
			type: 'GET',
			dataType: 'JSON',
		}).done(function(data) {
			if(data.success) {
				clearTimeout(rTop.interval);
				rTop.update();
				/*
				$("#top-"+id).find('.btn-votes').removeAttr('onclick').addClass('disabled');
				$("#top-"+id).find('.bar-votes.positive #bar').height(data.p_height + '%');
				$("#top-"+id).find('.bar-votes.negative #bar').height(data.n_height + '%');
				*/
			}
		});
	},
	update: function() {
		if(!rTop.finished) {
			$("#top-boxes").animate({'opacity': 0.5}, 'fast');

			$.ajax({
				url: '/lib/radio_top_update.php',
				type: 'GET',
			}).done(function(data) {
				$("#top-boxes").html(data);
				rTop.interval = setTimeout(function() {rTop.update();}, 60000);

				$("#top-boxes").animate({'opacity': 1}, 'fast');
				site.reload();
			});
		}
	}
}

$(document).ready(function() {
	$(".loader-corner").addClass('show');
	rTop.load();
})