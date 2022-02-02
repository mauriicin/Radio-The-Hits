<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";
include "system.php";

$i = 0;
$sql3 = $mysqli->query("SELECT * FROM radio_top ORDER BY votos_prop DESC");
while($sql4 = $sql3->fetch_assoc()) {
	$i++;
	$sql5 = $mysqli->query("SELECT * FROM ph_musicas WHERE id='".$sql4['id_musica']."'");
	$sql6 = $sql5->fetch_assoc();
	$artista = getArtista($sql6['id_artista'], $mysqli);
	$album = getAlbum($sql6['id_album'], $mysqli);

	$pos = $sql4['votos_pos'];
	$neg = $sql4['votos_neg'];

	$total = $pos + $neg;

	$p_pos = 100 * $pos / $total;
	$p_neg = 100 * $neg / $total;

	if($total == 0) { $p_pos = $p_neg = 0; }

	$sql7 = $mysqli->query("SELECT id FROM radio_top_votos WHERE id_top='".$sql4['id']."' AND ip='$ip'");
	if($sql7->num_rows > 0) { $vote_disabled = true; } else { $vote_disabled = false; }
	?> 
	<div id="top-<?=$sql4['id'];?>" class="box-top<?=(($i == 1)) ? ' first' : '';?>">
		<div id="number"><?=$i;?></div>

		<div id="infos">
			<div class="music txt-truncate"><?=clear($sql6['nome']);?></div>
			<div class="singer txt-truncate"><?=clear($artista['nome']);?></div>
			<div class="album txt-truncate"><?=clear($album['nome']);?></div>
		</div>

		<div id="img" style="background-image:url(<?=clear_img($album['imagem']);?>);"></div>

		<div id="votes">
			<div class="f-left">
				<div class="bar-votes positive"><div id="bar" style="height:<?=$p_pos;?>%;"></div></div>
				<div class="btn-votes positive<?=(($vote_disabled)) ? ' disabled' : '';?>"<?=((!$vote_disabled)) ? ' onclick="rTop.vote('.$sql4['id'].', 1);"' : '';?>><i class="icon-thumbs-up"></i></div>
			</div>

			<div class="f-right">
				<div class="btn-votes negative<?=(($vote_disabled)) ? ' disabled' : '';?>"<?=((!$vote_disabled)) ? ' onclick="rTop.vote('.$sql4['id'].', 2);"' : '';?>><i class="icon-thumbs-down"></i></div>
				<div class="bar-votes negative"><div id="bar" style="height:<?=$p_neg;?>%;"></div></div>
			</div>

			<br>
		</div>

		<br>
	</div>
	<? if($i == 10) { echo '<hr class="one">'; }
} ?>