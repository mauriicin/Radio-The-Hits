<? $id = anti_injecao($_GET['id']);

$sql = $mysqli->query("SELECT * FROM ph_musicas WHERE id='$id' AND status='aprovada' LIMIT 1");
$sql2 = $sql->fetch_assoc();

(($sql->num_rows == 0)) ? erro404() : '';

$artista = getArtista($sql2['id_artista'], $mysqli);
$pag_info['title'] = 'Rádio TheHits - ' . clear($sql2['nome']) . ' por ' . $artista['nome'];
$code_script = 'music_id='.$sql2['id'].';music_link = "'.$sql2['audio'].'";'; ?>

<div class="main-content">
	<div class="title-section">
		<h1 class="txt-truncate">Música: <b><?=clear($sql2['nome']);?></b></h1>
		<div id="separator"></div>
	</div>
</div>

<div class="side-content">
	<div id="social-network">
		<a href="/playhits/colaborar"><button class="btn-two button">Seja um colaborador</button></a>
		<? if($artista['twitter'] != '') { ?><a href="<?=$artista['twitter'];?>" target="_blank"><div class="box twitter"><i class="icon-twitter"></i></div></a><? } ?>
		<? if($artista['facebook'] != '') { ?><a href="<?=$artista['facebook'];?>" target="_blank"><div class="box facebook"><i class="icon-facebook"></i></div></a><? } ?>
	</div>
</div>

<br>

<div id="ph-music">
	<div id="img" style="background-image:url(<?=clear_img($artista['imagem']);?>);">
		<div id="caption"><center>
			<div class="singer txt-truncate" style="word-wrap: break-word;"><?=clear($artista['nome']);?></div><br>
		</center></div>
	</div>

	<? $sql3 = $mysqli->query("SELECT id FROM ph_musicas_likes WHERE id_musica='$id'");
	$sql4 = $mysqli->query("SELECT id FROM ph_musicas_listen WHERE id_musica='$id'"); ?>
	<div id="infos">
		<div id="informations">
			<div class="f-left">
				<div class="title"><?=clear($sql2['nome']);?></div>
				<div class="info"><i class="icon-heart"></i> <span class="liked"><?=$sql3->num_rows;?></span> gostaram <i class="icon-headphones"></i> <span class="listened"><?=$sql4->num_rows;?></span> escutaram</div>
			</div>

			<div id="controls">
				<div class="control pointer" onclick="music.play(0);"><i class="icon-play"></i></div>
				<div class="repeat pointer tip" title="Repetir música" onclick="music.repeat();"><i class="icon-loop"></i></div>

				<? $sql5 = $mysqli->query("SELECT id FROM ph_musicas_likes WHERE id_musica='$id' AND ip='$ip'");?>
				<?=(($sql5->num_rows == 0)) ? '<div class="like pointer tip" title="Gostei" onclick="music.like('.$id.');"><i class="icon-heart"></i></div>' : '<div class="like active pointer tip" title="Gostei" onclick="music.dislike('.$id.');"><i class="icon-heart"></i></div>';?>
			</div>

			<br>
		</div>

		<div id="bars"></div>
	</div>
</div>

<div class="main-content">
	<div class="title-section margin">
		<h1>Letra <b>da música</b></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content lyrics color-light">
		<?=(($sql2['letra'] != '')) ? nl2br(clear($sql2['letra'])) : aviso_yellow("Não temos a letra dessa música! :(");?>
	</div>
</div>

<div class="side-content">
	<div class="title-section margin">
		<h1>Vídeo</h1>
		<div id="separator"></div>
	</div>

	<div class="box-content">
		<? parse_str(parse_url($sql2['video'], PHP_URL_QUERY), $yt); ?>
		<iframe width="310" height="174" src="//www.youtube.com/embed/<?=$yt['v'];?>?rel=0" frameborder="0" allowfullscreen></iframe>
	</div>

	<div class="title-section margin">
		<h1>Publicidade</h1>
		<div id="separator"></div>
	</div>

	<div id="publicity"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 310POR250 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-5432839607510840"
     data-ad-slot="9169983417"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>

	<?=$network_side;?>
</div>

<br>