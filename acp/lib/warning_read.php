<? include "config.php";
include "functions.php";

$id = anti_injecao($_GET['id']);

$sql = mysql_query("SELECT * FROM acp_chat WHERE id='$id'");
$sql2 = mysql_fetch_assoc($sql);


