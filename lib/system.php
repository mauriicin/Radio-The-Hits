<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include 'config.php';
session_start();
date_default_timezone_set("Brazil/East");

// Verificações

// Portal PlayHits: playlists
$sql = $mysqli->query("SELECT * FROM ph_playlists");
while($sql2 = $sql->fetch_assoc()) {
	// Gostaram
	$musicas = explode('|', $sql2['musicas']);
	$rows = 0;

	foreach($musicas as $atual) {
		$sql3 = $mysqli->query("SELECT id FROM ph_musicas_likes WHERE id_musica='$atual'");
		$rows = $rows + $sql3->num_rows;
	}

	// Escutaram
	$sql5 = $mysqli->query("SELECT id FROM ph_playlists_listen WHERE id_playlist='".$sql2['id']."'");
	$escutaram = $sql5->num_rows;

	$sql4 = $mysqli->query("UPDATE ph_playlists SET gostaram='$rows', escutaram='$escutaram' WHERE id='".$sql2['id']."' LIMIT 1");
}

// Rádio: top 10
$sql6 = $mysqli->query("SELECT * FROM radio_top");
while($sql7 = $sql6->fetch_assoc()) {
	$sql8 = $mysqli->query("SELECT id FROM radio_top_votos WHERE id_top='".$sql7['id']."' AND tipo='pos'");
	$sql9 = $mysqli->query("SELECT id FROM radio_top_votos WHERE id_top='".$sql7['id']."' AND tipo='neg'");

	$pos = $sql8->num_rows;
	$neg = $sql9->num_rows;

	$prop = $pos - $neg;

	if($prop < 0) {
		$prop = 0;
	} else {
		if($prop == 0) { $prop = -1; }
	}

	$sql10 = $mysqli->query("UPDATE radio_top SET votos_pos='$pos', votos_neg='$neg', votos_prop='$prop' WHERE id='".$sql7['id']."' LIMIT 1");
}

include "radio_top_result.php";

// Top + pedidos
$sql11 = $mysqli->query("SELECT * FROM ph_artistas");
while($sql12 = $sql11->fetch_assoc()) {
	$sql13 = $mysqli->query("SELECT id FROM radio_pedidos WHERE cantor='".$sql12['nome']."'");
	$top_pedidos = $sql13->num_rows;

	$sql14 = $mysqli->query("UPDATE ph_artistas SET top_pedidos='$top_pedidos' WHERE id='".$sql12['id']."'");
}

$sql15 = $mysqli->query("SELECT * FROM ph_musicas");
while($sql16 = $sql15->fetch_assoc()) {
	$sql17 = $mysqli->query("SELECT id FROM radio_pedidos WHERE musica='".$sql16['nome']."'");
	$top_pedidos = $sql17->num_rows;

	$sql18 = $mysqli->query("UPDATE ph_musicas SET top_pedidos='$top_pedidos' WHERE id='".$sql16['id']."'");
}