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

$sql = $mysqli->query("SELECT * FROM ph_playlists WHERE id='$id' LIMIT 1");
$sql2 = $sql->fetch_assoc();

$sql10 = $mysqli->query("SELECT * FROM ph_playlists_listen WHERE id_playlist='$id' AND ip='$ip'");

if($sql10->num_rows == 0) {
	$sql11 = $mysqli->query("INSERT INTO ph_playlists_listen (id_playlist, ip, data) VALUES ('$id', '$ip', '$timestamp')");
}

$retorno['nome_playlist'] = $sql2['nome'];

$musicas = explode('|', $sql2['musicas']);

foreach($musicas as $atual) {
	$sql3 = $mysqli->query("SELECT * FROM ph_musicas WHERE id='$atual' AND status='aprovada' LIMIT 1");
	$sql4 = $sql3->fetch_assoc();

	$sql5 = $mysqli->query("SELECT nome FROM ph_artistas WHERE id='".$sql4['id_artista']."' LIMIT 1");
	$sql6 = $sql5->fetch_assoc();

	$sql7 = $mysqli->query("SELECT imagem FROM ph_albuns WHERE id='".$sql4['id_album']."' LIMIT 1");
	$sql8 = $sql7->fetch_assoc();

	$sql9 = $mysqli->query("SELECT * FROM ph_musicas_likes WHERE id_musica='$atual' AND ip='$ip'");

	(($sql9->num_rows == 0)) ? $liked = 'no' : $liked = 'yes';
    
    //                           (id música,   nome música,   nome url,               álbum img,                   nome artista , youtube link,   gostou)
	$retorno['musicas'][] = array($sql4['id'], $sql4['nome'], trataurl($sql4['nome']), clear_img($sql8['imagem']), $sql6['nome'], $sql4['audio'], $liked);
}

echo json_encode($retorno);