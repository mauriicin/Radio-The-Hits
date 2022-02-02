<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

session_start();
session_write_close();

include "config.php";
include "functions2.php";

/**
 * Sistema de alerta
 */
$alert_time = time() - 300;
$sql7 = $mysqli->query("SELECT * FROM alertas WHERE data > '$alert_time' ORDER BY id DESC LIMIT 1"); // 5 min = 300 seg
$sql8 = $sql7->fetch_assoc();

$sql9 = $mysqli->query("SELECT * FROM alertas_lidos WHERE id_alerta='".$sql8['id']."' AND token='".$_SESSION['token']."'");
$sql10 = $sql9->fetch_assoc();

if($sql9->num_rows == 0 && $sql7->num_rows != 0) {
	$alerta = true;
	$alerta_r = $sql8['conteudo'] . '<br><br>Por <b>'.$sql8['autor'].'</b> em <b>'.date('d/m/Y H:i', $sql8['data']);
	$id_alerta = $sql8['id'];

	$token = $_SESSION['token'];
	$sql = $mysqli->query("INSERT INTO alertas_lidos (id_alerta, token) VALUES ('$id_alerta', '$token')");
} 

if($alerta == true) {
	echo $alerta_r;
}
