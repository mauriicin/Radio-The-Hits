<div class="main-content">
	<div class="title-section">
		<h1 class="txt-truncate">Top <b>10</b></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content rtop-load"><center>Carregando [...]</center></div>
</div>

<div class="side-content">
	<div class="title-section">
		<h1 class="txt-truncate">Músicas <b>+nomeadas</b></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content">
		<? $sql9 = $mysqli->query("SELECT * FROM ph_musicas ORDER BY top_nomeada DESC LIMIT 5");
		while($sql10 = $sql9->fetch_assoc()) {
			$artista = getArtista($sql10['id_artista'], $mysqli);
			$album = getAlbum($sql10['id_album'], $mysqli);
			?>
		<div class="box-top-result">
			<div id="img" style="background-image:url(<?=clear_img($album['imagem']);?>);"></div>
			<div id="infos">
				<a href="/playhits/musicas/<?=$sql10['id'];?>/<?=trataurl($sql10['nome']);?>"><span class="music"><?=clear($sql10['nome']);?></span></a><br>
				<a href="/playhits/artistas/<?=$artista['id'];?>/<?=trataurl($artista['nome']);?>"><span class="singer"><?=clear($artista['nome']);?></span></a>
			</div>
		</div>
		<? } ?>
	</div>

	<div class="title-section margin">
		<h1 class="txt-truncate">Artistas <b>+nomeados</b></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content">
		<? $sql9 = $mysqli->query("SELECT * FROM ph_artistas ORDER BY top_nomeada DESC LIMIT 5");
		while($sql10 = $sql9->fetch_assoc()) { ?>
		<div class="box-top-result">
			<div id="img" style="background-image:url(<?=clear_img($sql10['imagem']);?>);"></div>
			<div id="infos">
				<a href="/playhits/artistas/<?=$sql10['id'];?>/<?=trataurl($sql10['nome']);?>"><span class="music"><?=clear($sql10['nome']);?></span></a><br>
			</div>
		</div>
		<? } ?>
	</div>

	<div class="title-section margin">
		<h1 class="txt-truncate">Último <b>resultado</b></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content top-result">
		<? $sql = $mysqli->query("SELECT * FROM radio_top_result LIMIT 1");
		$sql2 = $sql->fetch_assoc();

		$sql7 = $mysqli->query("SELECT * FROM radio_prog WHERE id='".$sql2['id_programacao']."' LIMIT 1");
		$sql8 = $sql7->fetch_assoc(); ?>
		Essas são as 10 músicas mais votadas pelos ouvintes na semana encerrada em <b><?=date('d/m/Y', $sql2['data_termino']);?></b>.<br><br>
		Elas serão tocadas durante a nossa programação às <b><?=date('H:i', $sql8['horario_inicio']);?></b> do dia <b><?=date('d/m', $sql8['horario_inicio']);?></b>.
		<? $musicas = explode('|', $sql2['id_musicas']);
		foreach ($musicas as $atual) {
			$sql3 = $mysqli->query("SELECT * FROM ph_musicas WHERE id='$atual' LIMIT 1");
			$sql4 = $sql3->fetch_assoc();
			$artista = getArtista($sql4['id_artista'], $mysqli);
			$album = getAlbum($sql4['id_album'], $mysqli);

			$sql5 = $mysqli->query("SELECT * FROM radio_prog WHERE id='".$sql4['id_programacao']."' LIMIT 1");
			$sql6 = $sql5->fetch_assoc();

			if($sql3->num_rows > 0) { ?>
			<div class="box-top-result">
				<div id="img" style="background-image:url(<?=clear_img($album['imagem']);?>);"></div>
				<div id="infos">
					<a href="/playhits/musicas/<?=$sql4['id'];?>/<?=trataurl($sql4['nome']);?>"><span class="music"><?=clear($sql4['nome']);?></span></a><br>
					<a href="/playhits/artistas/<?=$artista['id'];?>/<?=trataurl($artista['nome']);?>"><span class="singer"><?=clear($artista['nome']);?></span></a>
				</div>
			</div>
		<? } } ?>
	</div>
</div>

	<br>