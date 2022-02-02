<? $busca = $_POST['search'];
if($busca != '') {
	$buscaa = clear_mysql($busca);
	$sql = $mysqli->query("SELECT * FROM ph_artistas WHERE nome LIKE '%".$buscaa."%'");
	$sql2 = $mysqli->query("SELECT * FROM ph_musicas WHERE nome LIKE '%".$buscaa."%'  AND status='aprovada'");
	$pag_info['title'] = 'Rádio TheHits - Pesquisando por ' . $busca; ?>

	<div class="main-content">
		<div class="title-section">
			<h1 class="txt-truncate">Artistas - <b><?=clear($busca);?></b></h1>
			<div id="separator"></div>
		</div>

		<? while($sql3 = $sql->fetch_assoc()) { ?>
		<div class="box-result">
			<div id="img" style="background-image:url(<?=clear_img($sql3['imagem']);?>);"></div>
			<div id="infos">
				<div class="f-left">
					<div class="title txt-truncate"><?=clear($sql3['nome']);?></div>
					<div class="desc txt-truncate"><?=clear($sql3['ult_album']);?></div>
				</div>

				<a href="/playhits/artistas/<?=$sql3['id'];?>/<?=trataurl($sql3['nome']);?>"><button class="btn-two">Ver músicas</button></a>
			</div>
		</div>
		<? } if($sql->num_rows == 0) {
			echo aviso_blue("Não encontramos nenhum artista que combine com o que você procurou! :(");
		} ?>

		<div class="title-section margin">
			<h1 class="txt-truncate">Músicas - <b><?=clear($busca);?></b></h1>
			<div id="separator"></div>
		</div>

		<? while($sql4 = $sql2->fetch_assoc()) {
			$sql5 = $mysqli->query("SELECT id FROM ph_musicas_search WHERE id_musica='".$sql4['id']."' AND ip='$ip'");

			if($sql5->num_rows == 0) {
				$id_musica = $sql4['id'];
				$sql6 = $mysqli->query("INSERT INTO ph_musicas_search (id_musica, ip, data) VALUES ('$id_musica', '$ip', '$timestamp')");
			}

			$artista = getArtista($sql4['id_artista'], $mysqli);
			$album = getAlbum($sql4['id_album'], $mysqli);

			$letra = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $sql4['letra']);
			$lyrics = explode("\n", $letra);
			$lyrics = array_filter($lyrics);

			$lyric = $lyrics[rand(0, count($lyrics) - 1)]; ?>
		<div class="box-result">
			<div id="img" style="background-image:url(<?=clear_img($album['imagem']);?>);"></div>
			<div id="infos">
				<div class="f-left">
					<div class="title txt-truncate"><?=clear($sql4['nome']);?></div>
					<div class="desc txt-truncate"><?=clear($artista['nome']);?></div>
					<div class="lyrics txt-truncate">"<?=$lyric;?>..."</div>
				</div>

				<a href="/playhits/musicas/<?=$sql4['id'];?>/<?=trataurl($sql4['nome']);?>#play"><button class="btn-two"><i class="icon-play"></i> Ouvir</button></a>
			</div>
		</div>
		<? } if($sql2->num_rows == 0) {
			echo aviso_blue("Não encontramos nenhuma música que combine com o que você procurou! :(<br>Que tal ajudar a gente e cadastrar essa música? Seja um colaborador!");
			echo '<center><a href="/playhits/colaborar"><button class="btn-two">Seja um colaborador</button></a></center>';
		} ?>
	</div>

	<div class="side-content">
		<div class="title-section">
			<h1>as <b>6+ procuradas do site</b></h1>
			<div id="separator"></div>
		</div>

		<? $procuradas = array();
		$music_info = array();
		$sql7 = $mysqli->query("SELECT * FROM ph_musicas WHERE status='aprovada'");
		while($sql8 = $sql7->fetch_assoc()) {
			$artista = getArtista($sql8['id_artista'], $mysqli);
			$album = getAlbum($sql8['id_album'], $mysqli);

			$sql9 = $mysqli->query("SELECT * FROM ph_musicas_search WHERE id_musica='".$sql8['id']."'");

			$sql10 = $mysqli->query("SELECT id FROM ph_musicas_likes WHERE id_musica='".$sql8['id']."'");
			$sql11 = $mysqli->query("SELECT id FROM ph_musicas_listen WHERE id_musica='".$sql8['id']."'");

			$procuradas[$sql8['id']] = $sql9->num_rows;

			$music_info[$sql8['id']] = array(
				'nome' => clear($sql8['nome']),
				'artista' => clear($artista['nome']),
				'imagem' => clear_img($album['imagem']),
				'likes' => $sql10->num_rows,
				'listen' => $sql11->num_rows,
				'search' => $sql9->num_rows
			);
		} 

		arsort($procuradas);

		$i = 0;
		foreach ($procuradas as $chave => $valor) {
			$infos = $music_info[$chave]; ?>
			<a href="/playhits/musicas/<?=$chave;?>/<?=trataurl($infos['nome']);?>"><div class="box-music">
				<div id="img" style="background-image:url(<?=$infos['imagem'];?>);"></div>
				<div id="infos">
					<div class="music txt-truncate"><?=$infos['nome'];?></div>
					<div class="singer txt-truncate"><?=$infos['artista'];?></div>
					<div class="info"><i class="icon-heart"></i> <?=$infos['likes'];?> <i class="icon-headphones"></i> <?=$infos['listen'];?></div>
				</div>
			</div></a>
		<? if (++$i == 6) break; } ?>

		<?=$network_side;?>
	</div>

	<br>

<? } else {
	echo aviso_red("Pesquise por um termo.");
	$pag_info['title'] = 'Rádio TheHits - Pesquisar';
} ?>