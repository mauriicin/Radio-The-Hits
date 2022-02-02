<? if($_POST['form_processa'] == 's') {
	$nome = clear_mysql($_POST['nome']);
	$apelido = clear_mysql($_POST['apelido']);
	$imagem = $_FILES["imagem"];
	$senha = clear_mysql($_POST['senha']);
	$facebook = clear_mysql($_POST['facebook']);
	$instagram  = clear_mysql($_POST['instagram']);
	$twitter = clear_mysql($_POST['twitter']);
	$descricao = clear_mysql($_POST['descricao']);
	$prosseguir = true;

	if(strstr($facebook, "http://") || strstr($facebook, "www.") || strstr($facebook, "facebook.com") || strstr($twitter, "http://") || strstr($twitter, "www.") || strstr($twitter, "twitter.com")) {
		notificar("Não envie links nos campos Facebook ou Twitter. Envie apenas seu nome de usuário.","red");
		$prosseguir = false;
	}

	$tipos = array('jpg', 'jpeg', 'png', 'gif', 'bmp'); //só permite imagens
	if($prosseguir == true && !empty($imagem["name"])) { $upload = uploadFile($imagem, '../media/uploads/', $tipos, $rand); }
	
	if($upload['erro'] == 1) {
		notificar('O arquivo que você está tentando enviar não é de uma imagem válida. (Arquivos permitidos: .jpg, .jpeg, .png, .gif e .bmp)', 'red');
		$prosseguir = false;
	}
	
	if($upload['erro'] == 2) {
		notificar('Ocorreu um erro inesperado ao tentar enviar sua imagem. Contate a administração.', 'red');
		$prosseguir = false;
	}

	$sql3 = mysql_query("SELECT * FROM acp_usuarios WHERE nick='".$_SESSION['login']."' LIMIT 1");
	$ex = mysql_fetch_array($sql3);

	$caminho_img = $upload['caminho'];
	if(empty($imagem["name"])) { $caminho_img = $ex['imagem']; }

	if($prosseguir == true && $senha != '') {
		$senha_md5 = md5($senha);
		mysql_query("UPDATE acp_usuarios SET senha='$senha_md5' WHERE nick='".$_SESSION['login']."' LIMIT 1");
		logger("O usuário alterou sua senha.", "acao");

		$form_return .= aviso_green("Senha atualizada!");
	}

	if($prosseguir == true) {
		if($facebook != '') { $facebook = 'http://www.facebook.com/' . $facebook; } else {$facebook='';}
		if($instagram != '') { $instagram = 'http://www.instagram.com/' . $instagram; } else {$instagram='';}
		if($twitter != '') { $twitter = 'http://www.twitter.com/' . $twitter; } else {$twitter='';}
		mysql_query("UPDATE acp_usuarios SET nome='$nome', apelido='$apelido', avatar='$caminho_img', facebook='$facebook', instagram='$instagram', twitter='$twitter', descricao='$descricao' WHERE nick='".$_SESSION['login']."' LIMIT 1") or die(mysql_error());
		logger("O usuário atualizou seus dados.", "acao");

		notificar("Informações atualizadas!","blue");
	}	
}

$sql3 = mysql_query("SELECT * FROM acp_usuarios WHERE nick='".$_SESSION['login']."' LIMIT 1");
$ex = mysql_fetch_array($sql3);

$a = explode('|', $ex['cargos_e']);
$cargos_e = '';
$i = 0;
foreach($a as $atual) {
	$i++;

	if($a[$i] == '') {
		$cargos_e .= $atual . '.';
	} else {
		$cargos_e .= $atual . ', ';
	}
}

$cargos_e = str_replace('.', '', $cargos_e);
?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title">Minha conta</h3></div>
	<div class="panel-body">
		<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
			<?=$form_return;?>

			<div class="form-group">
				<label class="col-lg-2 control-label">Nome</label>
				<div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=$ex['nome'];?>"></div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Apelido</label>
				<div class="col-lg-10"><input type="text" name="apelido" class="form-control input-sm" value="<?=$ex['apelido'];?>"></div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Avatar</label>
				<div class="col-lg-10">
					<img src="<?=$ex['avatar'];?>"><br>
					<input type="file" name="imagem" class="form-control input-sm">
					<small>Envie caso queira mudar o atual.</small>
				</div><br>
			</div>


			<div class="form-group">
				<label class="col-lg-2 control-label">Nova senha</label>
				<div class="col-lg-10"><input type="password" name="senha" class="form-control input-sm" placeholder="Digite apenas se quiser trocar a atual"></div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Facebook</label>
				<div class="col-lg-5">
					<input type="text" name="facebook" class="form-control input-sm" placeholder="Digite apenas o seu usuário (ex: FNXHenry)" value="<?=(($ex['facebook']!=''))?substr($ex['facebook'], 24):'';?>">
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Instagram</label>
				<div class="col-lg-5">
					<input type="text" name="instagram" class="form-control input-sm" placeholder="Digite apenas o seu usuário (ex: FNXHenry)" value="<?=(($ex['instagram']!=''))?substr($ex['instagram'], 25):'';?>">
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Twitter</label>
				<div class="col-lg-5">
					<input type="text" name="twitter" class="form-control input-sm" placeholder="Digite apenas o seu usuário (ex: @FNXHenry)" value="<?=(($ex['twitter']!=''))?substr($ex['twitter'], 23):'';?>">
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Descrição (página da equipe)</label>
				<div class="col-lg-5">
					<textarea name="descricao" class="form-control input-sm"><?=$ex['descricao'];?></textarea>
				</div><br>
			</div>

			<div class="well">
				Você possui <b><?=$ex['advert'];?></b> advertências.<br>
				Último login ao painel de controle: <b><?=date('d/m/y H:i:s', $ex['acesso_data']);?></b>.<br><br>
				Você está na página da equipe nos seguintes cargos: <b><?=$cargos_e;?></b>
			</div>

			<div class="form-group form-submit">
				<label class="col-lg-2 control-label"></label>

				<input type="hidden" name="form_processa" value="s" />
				<div class="col-lg-10"><button type="submit" class="btn btn-success">Enviar</button></div>
			</div>
		</form>
	</div>
</div>