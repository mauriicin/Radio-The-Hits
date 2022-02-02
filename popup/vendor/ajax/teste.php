<?php


$chc = "eitayagu";

$link = mysql_connect("localhost", "playv580_site", 'tU$McV!4WS1z');
mysql_select_db("playv580_db", $link);

$result = mysql_query("SELECT avatar FROM acp_usuarios WHERE nome='$chc' OR nick='$chc' LIMIT 1", $link);
$num_rows = mysql_num_rows($result);

echo "$num_rows Rows\n";

?>