<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";

$last = anti_injecao($_GET['last']);

$sql = $mysqli->query("SELECT * FROM ph_playlists WHERE id < $last ORDER BY id DESC LIMIT 20");
while($sql2 = $sql->fetch_assoc()) { ?>
<div id="playlist-<?=$sql2['id'];?>" class="box">
	<div class="title pointer" onclick="playhits.playlist.play(<?=$sql2['id'];?>);"><div class="txt-truncate"><?=(($sql2['equipe'] == 's')) ? '<i class="icon-ok-circled"></i> ' : '';?><?=clear($sql2['nome']);?> &bull; Ouvir</div> <i class="icon-right-open"></i><br></div>
	<div class="info"><i class="icon-heart"></i> <?=$sql2['gostaram'];?> gostaram <i class="icon-headphones"></i> <?=$sql2['escutaram'];?> escutaram</div>
</div>
<? } $sql3 = $mysqli->query("SELECT * FROM ph_playlists WHERE id < $last");
if($sql3->num_rows > 20) {
	echo '<div class="more"><br><center><button class="btn-one" onclick="playhits.playlist.more();">Ver mais</button></center></div>';
} ?>