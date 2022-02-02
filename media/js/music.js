/*! Rádio TheHits - Todos os direitos reservados - by @_theFX */

music = {
	current_duration: 0,
	repeating: false,
	start: function() {
		for (index = 1; index < 101; ++index) {
			$("#bars").append('<div id="msc-bar-'+index+'" class="bar"></div>');
		}

		$("#bars .bar").each(function() {
			h = rand(15, 121);
			m = (121 - h) / 2

			$(this).height(h).css('margin-top', m+'px');
		});

		videoid = music_link.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/);
		video_id = videoid[1];

		var params = { allowScriptAccess: "always" };
		var atts = { id: "ph-yt-player" };

		swfobject.embedSWF("http://www.youtube.com/v/"+video_id+"?enablejsapi=1&playerapiid=ytplayer&version=3", "data-ph-player", "425", "356", "8", null, null, params, atts);

		if(parent.location.hash == '#play') {
			$("#ph-music .control").removeAttr('onclick');
			setTimeout('music.play(0)', 3000);
		}
	},
	play: function(first) {
		ytplayer.playVideo();

		$("#ph-music .control").html('<i class="icon-pause"></i>').attr('onclick', 'music.pause();');

		if(first == 0) {
			$.ajax({
				url: '/lib/ph_music_listen.php?id='+music_id,
				type: 'get',
				success: function() {
					listened = $("#ph-music .listened").html();
					new_listened = parseInt(listened) + 1;

					$("#ph-music .listened").html(new_listened);
				}
			});

			music.timing();
		}
	},
	pause: function() {
		ytplayer.pauseVideo();
		$("#ph-music .control").html('<i class="icon-play"></i>').attr('onclick', 'music.play(1);')
	},
	repeat: function() {
		if(music.repeating == false) {
			music.repeating = true;
			$("#ph-music .repeat").addClass('active');
		} else {
			music.repeating = false;
			$("#ph-music .repeat").removeClass('active');
		}
	},
	like: function(id) {
		$.ajax({
			url: '/lib/ph_like.php?type=like&id='+id,
			type: 'get',
			success: function (data) {
				$("#ph-music .like").addClass('active').attr("onclick", "music.dislike("+id+")");

				liked = $("#ph-music .liked").html();
				new_liked = parseInt(liked) + 1;

				$("#ph-music .liked").html(new_liked);
			}
		});
	},
	dislike: function(id) {
		$.ajax({
			url: '/lib/ph_like.php?type=dislike&id='+id,
			type: 'get',
			success: function (data) {
				$("#ph-music .like").removeClass('active').attr("onclick", "music.like("+id+")");

				liked = $("#ph-music .liked").html();
				new_liked = parseInt(liked) - 1;

				$("#ph-music .liked").html(new_liked);
			}
		});
	},
	timing: function() {
		if(music.current_duration == 0 && ytplayer) {
			music.current_duration = ytplayer.getDuration();
		}

		current_time = ytplayer.getCurrentTime();
		time = current_time * 100 / music.current_duration;
		time = parseInt(time);

		$("#ph-music .bar").each(function() {
			a = $(this).attr('id');
			b = a.split('-');
			id = b[2];

			((id <= time)) ? $(this).addClass('active') : $(this).removeClass('active');			
		});

		setTimeout('music.timing()', 1000);
	},
	change: function(value) {
		new_time = (music.current_duration * value) / 100;
		ytplayer.seekTo(new_time, true);
	},
	state: function(newState) {
		if(newState == 0) {
			$("#ph-music .bar").removeClass('active');

			if(music.repeating == true) {
				ytplayer.playVideo();
			} else {
				ytplayer.stopVideo();
				$("#ph-music .control").html('<i class="icon-play"></i>').attr('onclick', 'music.play(1);')		
			}
		}

		if(newState == 1) {
			$(".loader-corner").removeClass('show');
		}

		if(newState == 3) {
			$(".loader-corner").addClass('show');
		}
	}
}

function onYouTubePlayerReady(playerId) {
	ytplayer = document.getElementById("ph-yt-player");
	ytplayer.addEventListener("onStateChange", "music.state");

	music.timing();
}

function rand(min, max) {
	var argc = arguments.length;
	if (argc === 0) {
		min = 0;
		max = 2147483647;
	} else if (argc === 1) {
		throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');
	}

	return Math.floor(Math.random() * (max - min + 1)) + min;
}

$(document).ready(function() {
	music.start();
	music.bars();
})