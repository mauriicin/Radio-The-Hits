<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";

$retorno = array();

$sql = $mysqli->query("SELECT * FROM ph_artistas");
while($sql2 = $sql->fetch_assoc()) {
	$retorno['artists'][] = array('value' => $sql2['nome'], 'data' => $sql2['id']);
}

$sql3 = $mysqli->query("SELECT * FROM ph_albuns");
while($sql4 = $sql3->fetch_assoc()) {
	$retorno['albums'][] = array('value' => $sql4['nome'], 'data' => $sql4['id']);
}

$sql5 = $mysqli->query("SELECT * FROM ph_musicas WHERE status='aprovada'");
while($sql6 = $sql5->fetch_assoc()) {
	$retorno['musics'][] = array('value' => $sql6['nome'], 'data' => $sql6['id']);
}


echo json_encode($retorno);
