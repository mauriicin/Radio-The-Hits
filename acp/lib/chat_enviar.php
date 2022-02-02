<? 
include "config.php";
include "functions.php";

$id = anti_injecao($_GET['id']);

$sql = mysql_query("SELECT * FROM acp_avisos WHERE id='$id' LIMIT 1");
$sql2 = mysql_fetch_assoc($sql);

$leram = explode('|', $sql2['lido']);

if(!in_array($dados['id'], $leram)) {
	$lido = $sql2['lido'] . $dados['id'] . '|';
	$sql = mysql_query("UPDATE acp_avisos SET lido='$lido' WHERE id='$id' LIMIT 1");
}
