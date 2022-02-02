<?php
	flush();

	include('vendor/class/config.php');

	include('vendor/class/status.php');

	$Config = new Config;
	$Config->read('vendor/config/config.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Player Rádio TheHitsFM</title>
	<script src="vendor/js/jquery.js"></script>
	<script src="vendor/js/jwplayer.js"></script>
	<script>
		$(function(){
			jwplayer('audio').setup({
				plugins: {
					'audiolivestream-1': {
						format: 'Tocando: %track',
						buffer: 'Carregando: %perc%',
						backgroundCss: 'gradient',
						trackCss: 'color: #fff; font-size: 11px;'
					}
				},
				controlbar: 'none',
				width: 400,
				height: 35,
				modes: [
				{
					type: 'flash',
					src: 'vendor/aac/player.swf'
				}
				],
				file: 'http://<?php echo $Config->get('streaming/url'); ?>/',
				streamer: 'rtmp://rtmp3.pophostingbrasil.com/25920',
				volume: 70,
				autoplay: true,
				autostart: true
			});
		});
	</script>
	<style>body {font-family: Arial; color: #fff;}</style>
</head>
<body>
	<div id="audio"></div>
</body>
</html>