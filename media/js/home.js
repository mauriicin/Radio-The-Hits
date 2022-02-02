/*! Rádio TheHits - Todos os direitos reservados - by @_theFX */

home = {
	reload: function() {
		$("#ph-slider").slider({
			range: "min",
			stop: playhits.queue.time_change
		});
	},
	start: function() {
		$('#playlists .playlists, #queue .queue').slimscroll({
			height: 329
		});

		$("#ph-slider").slider({
			range: "min",
			stop: playhits.queue.time_change
		});
	}
}

playhits = {
	playlist: {
		more: function() {
			$(".loader-corner").addClass('show');

			last = $("#playlists .playlists .box:last").attr('id');
			last_info = last.split('-');
			last_id = last_info[1];

			$.ajax({
				url: '/lib/ph_playlists_load.php?last='+last_id,
				type: 'get',
				success: function (data) {
					$("#playlists .playlists .more").remove();
					$("#playlists .playlists").append(data);
					$(".loader-corner").removeClass('show');
				}
			});
		},
		play: function(id) {
			$.ajax({
				url: '/lib/ph_playlist.php?id='+id,
				type: 'get',
				dataType: 'json',
				success: function (data) {
					playhits.queue.stop();

					$(".ph-playlist-name").html(data.nome_playlist);
					$("#playlist-"+id).addClass('active');
					$("#queue .shuffle, #queue .stop").removeClass('hide');

					var index;
					var musicas = data.musicas;

					for (index = 0; index < musicas.length; ++index) {
						playhits.queue.add(musicas[index][0], musicas[index][1], musicas[index][2], musicas[index][3], musicas[index][4], musicas[index][5], musicas[index][6]);

						// nome, imagem, artista, liked, url
						var infos = new Array();
						infos.push(musicas[index][1], musicas[index][3], musicas[index][4], musicas[index][6], musicas[index][2]);

						playhits.queue.musics.push(musicas[index][0]);
						playhits.queue.links.push(musicas[index][5]);
						playhits.queue.infos.push(infos);

						if(index == 0) {
							var f_nome = musicas[index][1];
							var f_imagem = musicas[index][3];
							var f_artista = musicas[index][4];
						}
					}

					playhits.queue.start();
					playhits.queue.stats(f_nome, f_imagem, f_artista);
					site.reload();
				}
			});
}
},
queue: {
	musics: [],
	links: [],
	infos: [],
	playing: false,
	repeating: false,
	current_duration: 0,
	add: function(id, nome, url, imagem, artista, link, liked) {
		add = '<div id="ph-music-'+id+'" class="box">';
		add += '<div id="img" style="background-image:url('+imagem+');"></div>';
		add += '<div id="infos">';
		add += '<div class="music txt-truncate">'+nome+'</div>';
		add += '<div class="singer txt-truncate">'+artista+'</div>';
		add += '</div>';
		add += '<div id="controls">';
		add += '<a href="/playhits/musicas/'+id+'/'+url+'"><div class="lyrics tip" title="Ver letra da música"><i class="icon-pencil"></i></div></a>';

		if(liked == 'yes') {add += '<div class="like active pointer tip" title="Gostei" onclick="playhits.queue.dislike('+id+')"><i class="icon-heart"></i></div>';}
		if(liked == 'no') {add += '<div class="like pointer tip" title="Gostei" onclick="playhits.queue.like('+id+');"><i class="icon-heart"></i></div>';}

		add += '<br>';
		add += '</div>';
		add += '<br>';
		add += '</div>';

		$("#queue .queue").append(add).slimScroll({ scrollTo: 0 });
	},
	like: function(id) {
		$.ajax({
			url: '/lib/ph_like.php?type=like&id='+id,
			type: 'get',
			success: function (data) {
				$("#ph-music-"+id+" .like").addClass('active').attr("onclick", "playhits.queue.dislike("+id+")");
			}
		});
	},
	dislike: function(id) {
		$.ajax({
			url: '/lib/ph_like.php?type=dislike&id='+id,
			type: 'get',
			success: function (data) {
				$("#ph-music-"+id+" .like").removeClass('active').attr("onclick", "playhits.queue.like("+id+")");
			}
		});
	},
	stop: function() {
		$(".loader-corner").removeClass('show');

		$(".data-ph-player").html('<div id="data-ph-player"></div>');
		$(".ph-player").html('<div class="loading">Selecione uma playlist</div>');
		$(".ph-playlist-name").html('selecione uma playlist');

		$("#playlists .box").removeClass('active');
		$("#queue .queue").html('');
		$("#queue .shuffle, #queue .stop").addClass('hide');

		playhits.queue.musics = [];
		playhits.queue.links = [];
		playhits.queue.infos = [];
	},
	start: function() {
		playhits.queue.playing = 0;

		start = 0;
		music_link = playhits.queue.links[start];
		playhits.queue.player(music_link);
	},
	player: function(link) {
		playhits.queue.current_duration = 0;
		
		videoid = link.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
		video_id = videoid[1];

		var params = { allowScriptAccess: "always" };
		var atts = { id: "ph-yt-player" };

		$(".loader-corner").addClass('show');
		swfobject.embedSWF("http://www.youtube.com/v/"+video_id+"?enablejsapi=1&playerapiid=ytplayer&version=3", "data-ph-player", "425", "356", "8", null, null, params, atts);
		
	},
	stats: function(nome, imagem, artista) {
		((playhits.queue.repeating == true)) ? rpt_active = 'active ' : rpt_active = '';

		pl = '<div id="img" style="background-image:url('+imagem+');"></div>';
		pl += '<div id="infos">';
		pl += '<div class="music txt-truncate">'+nome+'</div>';
		pl += '<div class="singer txt-truncate">'+artista+'</div>';
		pl += '</div>';

		pl += '<div id="ph-current-time">--:--</div> <div id="ph-slider"></div> <div id="ph-duration-time">--:--</div>';

		pl += '<div id="controls">';

		pl += '<div class="back" onclick="playhits.queue.back();"><i class="icon-fast-backward"></i></div>';
		pl += '<div class="control" onclick="playhits.queue.pause();"><i class="icon-pause"></i></div>';
		pl += '<div class="foward" onclick="playhits.queue.foward();"><i class="icon-fast-forward"></i></div>';

		pl += '<div class="repeat '+rpt_active+'tip" title="Repetir música" onclick="playhits.queue.repeat();"><i class="icon-loop"></i></div>';

		pl += '</div>';
		pl += '<br>';

		$(".ph-player").html(pl);
		home.reload();
	},
	play: function(start) {
		playhits.queue.pause();

		ytplayer.playVideo();
		$(".ph-player .control").html('<i class="icon-pause"></i>').attr('onclick', 'playhits.queue.pause();')
	},
	pause: function() {
		ytplayer.pauseVideo();
		$(".ph-player .control").html('<i class="icon-play"></i>').attr('onclick', 'playhits.queue.play();')
	},
	state: function(newState) {
			// 0 = terminou
			// 1 = em reprodução
			// 3 = carregando

			if(newState == 0) {
				if(parseInt(playhits.queue.playing) != parseInt(playhits.queue.musics.length) - parseInt(1)) {
					$(".data-ph-player").html('<div id="data-ph-player"></div>');

					((playhits.queue.repeating == true)) ? next = playhits.queue.playing : next = parseInt(playhits.queue.playing) + parseInt(1);

					playhits.queue.playing = next;

					music_link = playhits.queue.links[next];
					playhits.queue.player(music_link);

					nome = playhits.queue.infos[next][0];
					imagem = playhits.queue.infos[next][1];
					artista = playhits.queue.infos[next][2];
					playhits.queue.stats(nome, imagem, artista);
				} else {
					playhits.queue.stop();
				}
				
			}

			if(newState == 1) {
				$(".loader-corner").removeClass('show');
			}

			if(newState == 3) {
				$(".loader-corner").addClass('show');
			}
		},
		timing: function() {
			if(playhits.queue.current_duration == 0 && ytplayer) {
				playhits.queue.current_duration = ytplayer.getDuration();
			}

			if($("#ph-duration-time").html() == '--:--') {
				var minutes = "0" + Math.floor(parseInt(playhits.queue.current_duration) / 60);
				var seconds = "0" + (parseInt(playhits.queue.current_duration) - minutes * 60);
				$("#ph-duration-time").html(minutes.substr(-2)+':'+seconds.substr(-2));
			}

			current_time = ytplayer.getCurrentTime();

			time = current_time * 100 / playhits.queue.current_duration;
			$("#ph-slider").slider("option", "value", time);

			var minutes = "0" + Math.floor(parseInt(current_time) / 60);
			var seconds = "0" + (parseInt(current_time) - minutes * 60);
			$("#ph-current-time").html(minutes.substr(-2)+':'+seconds.substr(-2));
			
			setTimeout("playhits.queue.timing()", 1000);
		},
		time_change: function() {
			value = $("#ph-slider").slider("option", "value");
			
			new_time = (playhits.queue.current_duration * value) / 100;
			ytplayer.seekTo(new_time, true);
		},
		shuffle: function() {
			shuffle(playhits.queue.musics, playhits.queue.links, playhits.queue.infos);

			$("#queue .queue").html('');

			for (index = 0; index < playhits.queue.infos.length; ++index) {
				id = playhits.queue.musics[index];
				link = playhits.queue.links[index];
				infos = playhits.queue.infos[index];

				playhits.queue.add(id, infos[0], infos[4], infos[1], infos[2], link, infos[3]);
			}		
		},
		repeat: function() {
			if(playhits.queue.repeating == false) {
				playhits.queue.repeating = true;
				$(".ph-player .repeat").addClass('active');
			} else {
				playhits.queue.repeating = false;
				$(".ph-player .repeat").removeClass('active');
			}
		},
		back: function() {
			next = playhits.queue.playing - 1;

			// caso seja a primeira ou +
			if(next >= 0) {
				$(".data-ph-player").html('<div id="data-ph-player"></div>');
				playhits.queue.playing = next;

				music_link = playhits.queue.links[next];
				playhits.queue.player(music_link);

				nome = playhits.queue.infos[next][0];
				imagem = playhits.queue.infos[next][1];
				artista = playhits.queue.infos[next][2];
				playhits.queue.stats(nome, imagem, artista);
			}
		},
		foward: function() {
			next = playhits.queue.playing + 1;

			// caso não seja a última
			if(parseInt(playhits.queue.playing) != parseInt(playhits.queue.musics.length) - parseInt(1)) {
				$(".data-ph-player").html('<div id="data-ph-player"></div>');
				playhits.queue.playing = next;

				music_link = playhits.queue.links[next];
				playhits.queue.player(music_link);

				nome = playhits.queue.infos[next][0];
				imagem = playhits.queue.infos[next][1];
				artista = playhits.queue.infos[next][2];
				playhits.queue.stats(nome, imagem, artista);
			}
		},
		listening: function() {
			id = playhits.queue.musics[playhits.queue.playing];

			$.ajax({
				url: '/lib/ph_music_listen.php?id='+id,
				type: 'get'
			});
		}	
	}
}

function onYouTubePlayerReady(playerId) {
	ytplayer = document.getElementById("ph-yt-player");
	ytplayer.addEventListener("onStateChange", "playhits.queue.state");
	ytplayer.playVideo();
	ytplayer.setVolume(100);

	playhits.queue.timing();
	playhits.queue.listening();
}

function shuffle() {
	var length0 = 0,
	length = arguments.length,
	i,
	j,
	rnd,
	tmp;

	for (i = 0; i < length; i += 1) {
		if ({}.toString.call(arguments[i]) !== "[object Array]") {
			throw new TypeError("Argument is not an array.");
		}

		if (i === 0) {
			length0 = arguments[0].length;
		}

		if (length0 !== arguments[i].length) {
			throw new RangeError("Array lengths do not match.");
		}
	}


	for (i = 0; i < length0; i += 1) {
		rnd = Math.floor(Math.random() * i);
		for (j = 0; j < length; j += 1) {
			tmp = arguments[j][i];
			arguments[j][i] = arguments[j][rnd];
			arguments[j][rnd] = tmp;
		}
	}
}

$(document).ready(function() {
	home.start();
})