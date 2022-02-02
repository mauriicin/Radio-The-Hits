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

$sql = $mysqli->query("SELECT * FROM ph_musicas_likes WHERE id_musica='$id' AND ip='$ip'");

if($sql->num_rows == 0) {
	$sql2 = $mysqli->query("INSERT INTO ph_musicas_likes (id_musica, ip, data) VALUES ('$id', '$ip','$timestamp')");
} else {
	$sql2 = $mysqli->query("DELETE FROM ph_musicas_likes WHERE id_musica='$id' AND ip='$ip'");
}