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
$sql = $mysqli->query("INSERT INTO ph_musicas_listen (id_musica, ip, data) VALUES ('$id', '$ip', '$timestamp')");