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

$fp2 = fsockopen($host, $port, $errno, $errstr);
if(!$fp2)
{
	$success2 = 2;
}
if($success2 != 2)
{
	fputs($fp2,"GET /7.html HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
	while(!feof($fp2))
	{
		$pg2 .= fgets($fp2, 1000);
	}
	fclose($fp2);
	$pag = ereg_replace(".*<body>", "", $pg2);
	$pag = ereg_replace("</body>.*", ",", $pag); 
	$numbers = explode(",",$pag);
	// Música
	$currentlisteners = $numbers[0];
	$musica = $numbers[6];
}

echo $musica;