<section class="content"><div class="align">
	<div class="f-left">
		<div id="news">
			<div class="title-section">
				<h1>Últimas <b>notícias</b></h1>
				<div id="separator"></div>
			</div></a>

			<? require_once "noticias/main.php"; ?>

			<br>
		</div>

		<div class="title-section margin" style="width:670px;">
			<h1>Portal <b>playhits</b></h1>
			<div id="separator"></div>
		</div>
	</div>

	<div class="side-content">
		<? include "playhits/most_played.php"; ?>

		<div id="music-week">
			<div class="title-section">
				<h1>Música <b>da semana</b></h1>
				<div id="separator"></div>
			</div>

			<? $sql5 = $mysqli->query('SELECT * FROM ph_musicas WHERE id="'.$sql2["id_semana"].'" AND status="aprovada" LIMIT 1');
			$sql6 = $sql5->fetch_assoc();

			$album = getAlbum($sql6['id_album'], $mysqli);
			$artista = getArtista($sql6['id_artista'], $mysqli); ?>
			<a href="/playhits/musicas/<?=$sql6['id'];?>/<?=trataurl($sql6['nome']);?>"><div class="box pointer" style="background-image:url(<?=clear_img($artista['imagem']);?>);">
				<div id="caption"><center>
					<div class="singer txt-truncate"><?=clear($artista['nome']);?></div><br>
					<div class="music txt-truncate"><?=clear($sql6['nome']);?></div>
				</center></div>
			</div></a>
		</div>
	</div>

	<br>
</div></section>

<section class="content-2">
	<div id="black-layer"></div>
	<div id="black-layer2"></div>

	<div class="align">
		<div id="playlists">
			<div class="title-section">
				<h1><i class="icon-th-list"></i> Qual playlist você quer ouvir?</h1>
				<div id="separator"></div>
			</div>

			<div class="playlists">
				<? include "playhits/playlists.php";?>
			</div>
		</div>

		<div id="queue">
			<div class="title-section">
				<div class="f-left">
					<h1><i class="icon-headphones"></i> Você está ouvindo <b class="ph-playlist-name">selecione uma playlist</b></h1>
					<div id="separator"></div>
				</div>

				<div class="settings">
					<div class="option shuffle hide" onclick="playhits.queue.shuffle();"><i class="icon-shuffle"></i> Aleatório</div>
					<div class="option stop hide" onclick="playhits.queue.stop();"><i class="icon-stop"></i> Desligar</div>

					<br>
				</div>

				<br>
			</div>

			<div class="queue">
			</div>
		</div>

		<br>
	</div>

	<div id="ph-player"><div class="align pl ph-player">
		<div class="loading">Selecione uma playlist</div>
	</div></div>
</section>

<section class="content-3"><div class="align">
	<div id="artists">
		<div class="title-section">
			<h1>Top <b>artistas mais pedidos</b></h1>
			<div id="separator"></div>
		</div>

		<div class="list">
			<? $i = 0;
			$sql7 = $mysqli->query("SELECT * FROM ph_artistas ORDER BY top_pedidos DESC LIMIT 5");
			while($sql8 = $sql7->fetch_assoc()) {
				$i++; ?>
				<div class="box<?=(($i == 1)) ? ' big' : '';?>">
					<div id="img" style="background-image:url(<?=clear_img($sql8['imagem']);?>);"></div>

					<div id="infos">
						<div class="album txt-truncate"><?=clear($sql8['ult_album']);?></div>
						<a href="/playhits/artistas/<?=$sql8['id'];?>/<?=trataurl($sql8['nome']);?>"><div class="singer txt-truncate"><?=clear($sql8['nome']);?></div></a>
					</div>

					<div id="number"><?=$i;?></div>
				</div>
			<? } ?>
		</div>
	</div>

	<div id="musics">
		<div class="title-section">
			<h1>Top <b>músicas mais pedidas</b></h1>
			<div id="separator"></div>
		</div>

		<div class="list">
			<? $i = 0;
			$sql7 = $mysqli->query("SELECT * FROM ph_musicas ORDER BY top_pedidos DESC LIMIT 5");
			while($sql8 = $sql7->fetch_assoc()) {
				$album = getAlbum($sql8['id_album'], $mysqli);
				$artista = getArtista($sql8['id_artista'], $mysqli);
				$i++; ?>
				<div class="box<?=(($i == 1)) ? ' big' : '';?>">
					<div id="img" style="background-image:url(<?=clear_img($album['imagem']);?>);"></div>

					<div id="infos">
						<div class="album txt-truncate"><?=clear($album['nome']);?></div>
						<a href="/playhits/musicas/<?=$sql8['id'];?>/<?=trataurl($sql8['nome']);?>"><div class="singer txt-truncate"><?=clear($sql8['nome']);?></div></a>
						<div class="number txt-truncate"><?=clear($artista['nome']);?></div>
					</div>

					<div id="number"><?=$i;?></div>
				</div>
			<? } ?>
		</div>
	</div>

	<br>
</div></section>