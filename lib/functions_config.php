<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

date_default_timezone_set("Brazil/East");

ini_set("display_errors", false);
ini_set('html_errors', false);

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$_rand = md5(uniqid(time()));
$rand  = substr($_rand, 6, 14);
$rand2 = substr($_rand, 5, 13);

$timestamp = time();