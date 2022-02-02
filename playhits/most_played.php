<div id="most-played">
	<div class="title-section">
		<h1>as <b>5 +tocadas no Brasil</b></h1>
		<div id="separator"></div>
	</div>

	<? $sql = $mysqli->query("SELECT * FROM musicas_destaque LIMIT 1");
	$sql2 = $sql->fetch_assoc();

	$i = 1;
	while($i <= 5) {
		(($i == 1)) ? $number = 'um' : '';
		(($i == 2)) ? $number = 'dois' : '';
		(($i == 3)) ? $number = 'tres' : '';
		(($i == 4)) ? $number = 'quatro' : '';
		(($i == 5)) ? $number = 'cinco' : '';

		$sql3 = $mysqli->query('SELECT * FROM ph_musicas WHERE id="'.$sql2["id_$number"].'" AND status="aprovada" LIMIT 1');
		$sql4 = $sql3->fetch_assoc();
		$album = getAlbum($sql4['id_album'], $mysqli);
		$artista = getArtista($sql4['id_artista'], $mysqli); ?>
		<a href="/playhits/musicas/<?=$sql4['id'];?>/<?=trataurl($sql4['nome']);?>"><div class="box">
			<div id="img" style="background-image:url(<?=clear_img($album['imagem']);?>);"></div>
			<div id="infos">
				<div class="album txt-truncate"><?=clear($album['nome']);?></div>
				<div class="music txt-truncate"><?=clear($sql4['nome']);?></div>
				<div class="singer txt-truncate"><?=clear($artista['nome']);?></div>
			</div>
		</div></a>
		<? $i++; } ?>			
	</div>