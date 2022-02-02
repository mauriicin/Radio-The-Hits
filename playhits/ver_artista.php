<? $id = anti_injecao($_GET['id']);

$sql = $mysqli->query("SELECT * FROM ph_artistas WHERE id='$id' LIMIT 1");
$sql2 = $sql->fetch_assoc();

(($sql->num_rows == 0)) ? erro404() : '';

$pag_info['title'] = 'Rádio TheHits - ' . $sql2['nome']; ?>
<div class="main-content">
	<div class="title-section">
		<h1 class="txt-truncate">Músicas de <b><?=$sql2['nome'];?></b></h1>
		<div id="separator"></div>
	</div>

	<? $sql3 = $mysqli->query("SELECT * FROM ph_musicas WHERE id_artista='$id' AND status='aprovada' ORDER BY nome ASC");
	while($sql4 = $sql3->fetch_assoc()) {
		$album = getAlbum($sql4['id_album'], $mysqli);
		$letra = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $sql4['letra']);
		$lyrics = explode("\n", $letra);
		$lyrics = array_filter($lyrics);

		$lyric = $lyrics[rand(0, count($lyrics) - 1)]; ?>
	<div class="box-result">
		<div id="img" style="background-image:url(<?=$album['imagem'];?>);"></div>
		<div id="infos">
			<div class="f-left">
				<div class="title txt-truncate"><?=clear($sql4['nome']);?></div>
				<div class="desc txt-truncate"><?=clear($sql2['nome']);?></div>
				<div class="lyrics txt-truncate">"<?=clear($lyric);?>..."</div>
			</div>

			<a href="/playhits/musicas/<?=$sql4['id'];?>/<?=trataurl($sql4['nome']);?>#play"><button class="btn-two"><i class="icon-play"></i> Ouvir</button></a>
		</div>
	</div>
	<? } if($sql3->num_rows == 0) {
		echo aviso_blue("Não encontramos nenhuma música desse artista! :(");
	} ?>

	<? if($sql2['facebook'] != '' || $sql2['twitter'] != '') { ?>
	<div id="social-network">
		<? if($sql2['facebook'] != '') { ?><a href="<?=$sql2['facebook'];?>" target="_blank"><div class="box facebook"><i class="icon-facebook"></i> <span>Ver facebook</span></div></a><? } ?>
		<? if($sql2['twitter'] != '') { ?><a href="<?=$sql2['twitter'];?>" target="_blank"><div class="box twitter"><i class="icon-twitter"></i> <span>Ver twitter</span></div></a><? } ?>
		<br>
	</div>
	<? } ?>
</div>

<div class="side-content">
	<div class="title-section">
		<h1 class="txt-truncate">Álbuns</h1>
		<div id="separator"></div>
	</div>

	<? $sql5 = $mysqli->query("SELECT * FROM ph_albuns WHERE id_artista='".$sql2['id']."'");
	while($sql6 = $sql5->fetch_assoc()) { ?>
	<div class="box-music album">
		<div id="img" style="background-image:url(<?=clear_img($sql6['imagem']);?>);"></div>
		<div id="infos">
			<div class="music txt-truncate"><?=clear($sql6['nome']);?></div>
		</div>
	</div>
	<? } ?>

	<?=$network_side;?>
</div>

<br>