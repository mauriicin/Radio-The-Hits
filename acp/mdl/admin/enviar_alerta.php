<? if($permissoes[3] == 'n') { erro404(); die(); }

if($_POST['form_processa'] == 's') {
	$alerta = $_POST["alerta"];
	$prosseguir = true;

	if($alerta == '') {
		notificar("Você não pode enviar um alerta vazio.","red");
		$prosseguir = false;
	}

	if($prosseguir == true) {
		mysql_query("INSERT INTO alertas (conteudo, autor, data) VALUES ('$alerta', '$autor', '$timestamp')");
		logger("O usuário emitiu um alerta.", "acao");

		notificar("Sucesso!","blue");
	}
} ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">
		<div class="well well-sm">
			Quando você emitir o alerta, ele será exibido no site em até 1 minuto. Após isso, ficará visível para todos que entrarem no site em até 5 minutos.
		</div>
		<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
			<?=$form_return;?>

			<div class="form-group">
				<label class="col-lg-2 control-label">Alerta</label>
				<div class="col-lg-10"><textarea name="alerta" class="ckeditor"><?=$_POST['alerta'];?></textarea></div><br>
			</div>

			<div class="form-group form-submit">
				<label class="col-lg-2 control-label"></label>

				<input type="hidden" name="form_processa" value="s" />
				<div class="col-lg-10"><button type="submit" class="btn btn-success">Enviar</button></div>
			</div>
		</form>
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-heading"><h3 class="panel-title">Últimos 10 alertas enviados</h3></div>
	<div class="panel-body">
		<? $sql = mysql_query("SELECT * FROM alertas ORDER BY id DESC LIMIT 10");
		while($sql2 = mysql_fetch_array($sql)) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">Enviado por <?=$sql2['autor'];?> - <?=date('d/m/y H:i', $sql2['data']);?></div>
			<div class="panel-body">
				<?=$sql2['conteudo'];?>
			</div>
		</div>
		<? } ?>
	</div>
</div>