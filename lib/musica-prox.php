<?php 

/**
 * R谩dio TheHits - Todos os direitos reservados.
 * 脡 proibido a c贸pia de qualquer c贸digo presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";

$_config = $mysqli->query("SELECT * FROM config LIMIT 1");
$config = $_config->fetch_assoc();

$host = $config['radio_ip'];
$port = $config['radio_porta'];

$url = file_get_contents('http://'. $host .':'.$port.'/nextsong');

echo $url;