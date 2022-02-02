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
$tipo = anti_injecao($_GET['type']);
$prosseguir = true;

(($tipo == 1)) ? $tipo = 'pos' : $tipo = 'neg';

$sql = $mysqli->query("SELECT id FROM radio_top_votos WHERE id_top='$id' AND ip='$ip'");

if($sql->num_rows > 0) {
	$prosseguir = false;
}

if($prosseguir) {
	$sql = $mysqli->query("INSERT INTO radio_top_votos (id_top, tipo, ip, data) VALUES ('$id', '$tipo', '$ip', '$timestamp')");
}

$sql3 = $mysqli->query("SELECT id FROM radio_top_votos WHERE id_top='$id' AND tipo='pos'");
$sql4 = $mysqli->query("SELECT id FROM radio_top_votos WHERE id_top='$id' AND tipo='neg'");

$pos = $sql3->num_rows;
$neg = $sql4->num_rows;

$total = $pos + $neg;

$p_pos = 100 * $pos / $total;
$p_neg = 100 * $neg / $total;

if($total == 0) { $p_pos = $p_neg = 0; }

$retorno['success'] = $prosseguir;
$retorno['p_height'] = $p_pos;
$retorno['n_height'] = $p_neg;

echo json_encode($retorno);