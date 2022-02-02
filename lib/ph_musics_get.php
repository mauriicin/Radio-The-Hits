<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";

$artista = clear_mysql($_POST['artista']);

$sql = $mysqli->query("SELECT id FROM ph_artistas WHERE nome='$artista' LIMIT 1");
$sql2 = $sql->fetch_assoc();

$id_artista = $sql2['id'];

$retorno = array();

$sql5 = $mysqli->query("SELECT * FROM ph_musicas WHERE status='aprovada' AND id_artista='$id_artista'");
while($sql6 = $sql5->fetch_assoc()) {
	$retorno['musics'][] = clear($sql6['nome']);
}

echo json_encode($retorno);
