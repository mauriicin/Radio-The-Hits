<? if($permissoes[1] == 'n') {erro404();die(); }

if($_POST['form_processa'] == 's') {
	$ipp = $_POST["ip"];
	$porta = $_POST["porta"];
	$senha = $_POST["senha"];
	$senhakick = $_POST["senha2"];
	$tipo = $_POST["tipo"];
	$alerta = $_POST['alerta'];
	$imagem = $_FILES["imagem"];
	$top = $_POST['top'];
	$prosseguir = true;


	$sql3 = mysql_query("SELECT * FROM config LIMIT 1");
	$ex = mysql_fetch_array($sql3);

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

	$caminho_img = $upload['caminho'];
	if(empty($imagem["name"])) { $caminho_img = $ex['radio_autodj']; }

	if($prosseguir == true) {
		mysql_query("UPDATE config SET radio_autodj='$caminho_img', radio_top='$top', autor='$autor', data='$timestamp', alerta='$alerta', radio_ip='$ipp', radio_porta='$porta', radio_senha='$senha', radio_senhakick='$senhakick', radio_tipo='$tipo' LIMIT 1");
		logger("O usuário atualizou as configurações do site.", "acao");

		notificar("Informações atualizadas!","blue");
	}
	
}

$sql3 = mysql_query("SELECT * FROM config LIMIT 1");
$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">
		<div class="panel-body">
			<div class="well">A última alteração destas configurações foi realizada por <b><?=$ex['autor'];?></b> em <b><?=date('d/m/Y H:i', $ex['data']);?></b></div>
			<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
				<?=$form_return;?>

				<div class="form-group">
					<label class="col-lg-3 control-label">IP da rádio</label>
					<div class="col-lg-9"><input type="text" name="ip" class="form-control input-sm" value="<?=$ex['radio_ip'];?>"></div><br>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Porta da rádio</label>
					<div class="col-lg-9"><input type="text" name="porta" class="form-control input-sm" value="<?=$ex['radio_porta'];?>"></div><br>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Senha da rádio (entrada)</label>
					<div class="col-lg-9"><input type="text" name="senha" class="form-control input-sm" value="<?=$ex['radio_senha'];?>"></div><br>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Senha da rádio (kick)</label>
					<div class="col-lg-9"><input type="text" name="senha2" class="form-control input-sm" value="<?=$ex['radio_senhakick'];?>"></div><br>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Tipo de transmissão</label>
					<div class="col-lg-9"><input type="text" name="tipo" class="form-control input-sm" value="<?=$ex['radio_tipo'];?>"></div><br>
				</div>

				<div class="form-group">
	  			<label class="col-lg-3 control-label">Rádio Top 10</label>
	  			<div class="col-lg-9">
	  				<select name="top" class="form-control">
	  					<option value="s" <? if($ex['radio_top'] == 's') { echo 'selected="selected"'; } ?>>Mostrar</option>
	  					<option value="n" <? if($ex['radio_top'] == 'n') { echo 'selected="selected"'; } ?>>Ocultar</option>
	  				</select>
	  			</div><br>
	  		</div>

				<div class="form-group">
					<label class="col-lg-2 control-label">Imagem do AutoDJ</label>
					<div class="col-lg-10"><input type="file" name="imagem" class="form-control input-sm"><br>
						<small>Envie apenas caso queira mudar a atual.</small><br><br>
						<img src="<?=$ex['radio_autodj'];?>">
					</div><br>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Alerta</label>
					<div class="col-lg-9"><textarea name="alerta" class="ckeditor"><?=$ex['alerta'];?></textarea></div><br>
				</div>

				<div class="form-group form-submit">
					<label class="col-lg-3 control-label"></label>

					<input type="hidden" name="form_processa" value="s" />
					<div class="col-lg-9"><button type="submit" class="btn btn-success">Enviar</button></div>
				</div>
			</form>
		</div>
	</div>
</div>