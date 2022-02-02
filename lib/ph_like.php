<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";

$id = anti_injecao($_GET['id']);
$type = anti_injecao($_GET['type']);

$sql = $mysqli->query("SELECT * FROM ph_musicas_likes WHERE id_musica='$id' AND ip='$ip'");

if($sql->num_rows == 0 && $type == 'like') {
	$sql2 = $mysqli->query("INSERT INTO ph_musicas_likes (id_musica, ip, data) VALUES ('$id', '$ip', '$timestamp')");
}

if($type == 'dislike') {
	$sql2 = $mysqli->query("DELETE FROM ph_musicas_likes WHERE id_musica='$id' AND ip='$ip'");
}