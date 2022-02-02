<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";

$nome = clear_mysql($_POST['nome']);
$cantor = clear_mysql($_POST['artista']);
$musica = clear_mysql($_POST['musica']);
$prosseguir = true;

$sql = $mysqli->query("SELECT * FROM radio_pedidos WHERE ip='$ip' ORDER BY id DESC LIMIT 1");
$sql2 = $sql->fetch_assoc();

if(empty($nome) || empty($cantor) || empty($musica)) {
	$retorno .= aviso_red("Preencha todos os campos.");
	$prosseguir = false;
}

if($sql2['data'] > time() - 60) {
	$retorno .= aviso_red("Aguarde 1 minuto para enviar outro pedido.");
	$prosseguir = false;
}

if($prosseguir) {
	$sql3 = $mysqli->query("INSERT INTO radio_pedidos (nome, cantor, musica, ip, data) VALUES ('$nome', '$cantor', '$musica', '$ip', '$timestamp')");
	$retorno = 'success';
}

echo $retorno;