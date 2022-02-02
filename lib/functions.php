<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "functions_config.php";

$_config = $mysqli->query("SELECT * FROM config LIMIT 1");
$config = $_config->fetch_assoc();

// Funções - functions2.php deve ser incluso em arquivos que não possuem a necessidade de uma SESSION.
$fc2_included = true;
include "functions2.php";