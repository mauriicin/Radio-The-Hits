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

$sql = $mysqli->query("SELECT id FROM slide_clicks WHERE id='$id' AND ip='$ip'");

if($sql->num_rows == 0) {
	$sql2 = $mysqli->query("INSERT INTO slide_clicks (id_slide, ip, data) VALUES ('$id', '$ip', '$timestamp')");
}