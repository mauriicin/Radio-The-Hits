<? if($_SERVER['SERVER_NAME'] == 'thehits.localhost') {
	@mysql_connect("localhost", "root", false);
	@mysql_select_db("thehits");
	@mysql_query("SET NAMES utf8");
} else {
	$mysql_host = "localhost";
	$mysql_user = "radiothe_the";
	$mysql_password = 'XDIqG]dC;N2I*EsvL?';
	$mysql_database = "radiothe_hits";

	@mysql_connect($mysql_host,$mysql_user,$mysql_password) or die(mysql_error());
	@mysql_select_db($mysql_database);
	@mysql_query("SET NAMES utf8");
} ?>