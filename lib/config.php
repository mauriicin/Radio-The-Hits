<?php

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
	$servidor = 'localhost';
	$usuario = 'root';
	$senha = 'root';

	$banco = 'thehits';
	$dominio = 'http://localhost/thehits/';
} else {
	$servidor = 'localhost';
	$usuario = 'radiothe_the';
	$senha = 'XDIqG]dC;N2I*EsvL?';
	$banco = 'radiothe_hits';
	$dominio = 'http://www.radiothehits.com/';
}

$mysqli = new mysqli($servidor, $usuario, $senha, $banco);
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

$mysqli->query("SET NAMES 'utf8'");

define("MAIN_DIR", $_SERVER['DOCUMENT_ROOT'] . '/');