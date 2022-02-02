<?php session_start();
include "lib/config.php";
include "lib/functions.php";

if(isset($_SESSION['login'])) { header("Location: admin.php"); }

if($_POST['form_submit'] == 'form_submit') {
	$nick = clear($_POST['nick']);
	$password = clear($_POST['password']);
	$password_md5 = md5($password);
	$prosseguir = true;

	if($nick == '') {
		$form_return .= aviso_red("Qual é o usuário?");
		$prosseguir = false;
	}

	if($password == '') {
		$form_return .= aviso_red("Qual é a senha?");
		$prosseguir = false;
	}

	$sql = mysql_query("SELECT * FROM acp_usuarios WHERE nick='$nick' AND senha='$password_md5'");
	$sql2 = mysql_fetch_array($sql);

	if(mysql_num_rows($sql) == 0) {
		$form_return .= aviso_red("Nick ou senha incorretos.");
		$prosseguir = false;
	}

	if($prosseguir == true) {
		$_SESSION['acp_id'] = $sql2['id'];
		$_SESSION['login'] = $sql2['nick'];
		
		logger('O usuário entrou no painel de controle.', 'acesso');
		mysql_query("UPDATE acp_usuarios SET acesso_data='$timestamp', acesso_ip='$ip' WHERE id='".$sql2['id']."' LIMIT 1");
		header("Location: admin.php");

		$form_return .= aviso_blue("Aguarde...");
	}
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="language" content="pt-br">

	<meta name="robots" content="noindex, nofollow">
	<meta name="url" content="http://www.radiothehits.com">

	<title>Rádio TheHits - Painel de gerenciamento</title>
	
	<link rel="icon" href="/media/images/favicon.png">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Viga|Signika:400,300,600">

	<link rel="stylesheet" href="/media/css/acp_general.css">
	<link rel="stylesheet" href="/media/css/acp_style.css" class="cssfx">
</head>

<body class="login">
	<div class="page"><center>
		<div class="logo"></div>

		<div class="box-login">
			<span class="text">Admin</span>

			<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post">
				<?=$form_return;?>

				<div class="form-group">
					<input type="text" class="input input-lg form-control m-btm" name="nick" placeholder="Usuário" autofocus value="<?=$_POST['usuario'];?>">
				</div>

				<div class="form-group">
					<input type="password" class="input input-lg form-control m-btm" name="password" placeholder="Senha">
				</div>

				<input type="hidden" name="form_submit" value="form_submit">
				<button type="submit" class="btn btn-primary btn-block btn-lg">Entrar</button>
			</form>
		</div>

		<div class="copyright"><small>by</small> <a href="#" target="_blank">Arthur</a> <small>and</small> <a href="http://www.twitter.com/@FNXHenry" target="_blank">Henrique</a></div>
	</center></div>

	<script src="/media/js/jquery.js"></script>
	<script src="/media/js/acp_general.js"></script>
	<script src="/media/js/acp_panel.js"></script>
</body>
</html>