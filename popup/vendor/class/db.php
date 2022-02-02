<?php
include('config.php');
$Config = new Config;
$Config->read('../config/config.php' );

// Conecta ao banco dados
mysql_connect($Config->get('database/host'), $Config->get('database/user'), $Config->get('database/pass'));
mysql_select_db($Config->get('database/db'));