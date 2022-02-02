/*! Rádio TheHits - Todos os direitos reservados - by @_theFX */

page = {
	start: function() {
		pag_id = $("#pag-number").val();

		if(pag_id == 5) {
			$.ajax({
				url: '/lib/ph_autocomplete.php',
				type: 'GET',
				dataType: 'JSON'
			}).done(function(data) {
				list_artists = data.artists;
				list_albums = data.albums;

				$('.autocomplete-artist').autocomplete({ lookup: list_artists });
				$('.autocomplete-album').autocomplete({ lookup: list_albums });
			});
		}

	}
}

function music_name() {
	singer = $("#music-singer").val();
	name = $("#music-name").val();

	if(singer != '' && name != '') {
		$(".loader-corner").addClass('show');

		$("#music-lyrics").attr({
			'disabled': true,
			'placeholder': 'Estamos tentando obter a letra da música...'
		});

		$.getJSON(
			"http://api.vagalume.com.br/search.php" + "?art=" + singer + "&mus=" + name,
			function (data) {
				$(".loader-corner").removeClass('show');

				if(data.type == 'song_notfound' || data.type == 'notfound') {
					$("#music-lyrics").attr({
						'disabled': false,
						'placeholder': 'Não conseguimos obter a letra da música automaticamente. Você terá que digitá-la aqui.'
					});
				} else {
					$("#music-lyrics").val(data.mus[0].text).attr('disabled', false);
				}
			}
		);
	}
}

$("#music-name").change(function() {
	setTimeout("music_name();", 500);
}); 

$(document).ready(function() {
	page.start();
})