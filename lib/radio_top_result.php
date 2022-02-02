<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
((!$fc2_included)) ? include "functions2.php" : '';

$sql = $mysqli->query("SELECT data_termino FROM radio_top LIMIT 1");
$sql2 = $sql->fetch_assoc();

$identificador = md5(date('d/m/y', $sql2['data_termino']));

$sql3 = $mysqli->query("SELECT * FROM radio_top_result WHERE identificador='$identificador'");

if($sql2['data_termino'] <= time() && $sql3->num_rows == 0) {
	$musicas = '';

	// while para cada música ganhadora (só 10 músicas ganham)
	$sql4 = $mysqli->query("SELECT * FROM radio_top ORDER BY votos_prop DESC LIMIT 10");
	while($sql5 = $sql4->fetch_assoc()) {
		$musicas .= $sql5['id'] . '|';
		((!isset($id_programacao))) ? $id_programacao = $sql5['id_programacao'] : '';

		$sql7 = $mysqli->query("SELECT top_nomeada, id_artista FROM ph_musicas WHERE id='".$sql5['id']."'");
		$sql8 = $sql7->fetch_assoc();

		$sql9 = $mysqli->query("SELECT top_nomeada FROM ph_artistas WHERE id='".$sql8['id_artista']."'");
		$sql10 = $sql9->fetch_assoc();

		$top_musica = $sql8['top_nomeada'] + 1;
		$top_artista = $sql10['top_nomeada'] + 1;

		$sql11 = $mysqli->query("UPDATE ph_musicas SET top_nomeada='$top_musica' WHERE id='".$sql5['id']."' LIMIT 1");
		$sql12 = $mysqli->query("UPDATE ph_artistas SET top_nomeada='$top_musica' WHERE id='".$sql8['id_artista']."' LIMIT 1");
	}

	$data_termino = $sql2['data_termino'];
	$sql6 = $mysqli->query("UPDATE radio_top_result SET id_musicas='$musicas', id_programacao='$id_programacao', identificador='$identificador', data_termino='$data_termino', ip='$ip', data='$timestamp'");
}

if(isset($_GET['get'])) {
	$sql = $mysqli->query("SELECT * FROM radio_top_result LIMIT 1");
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
		<? } 
	}
} ?>