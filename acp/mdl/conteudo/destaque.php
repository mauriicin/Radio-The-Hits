<? if($permissoes[9] == 'n') {erro404();die(); }

if($_POST['form_processa'] == 's') {
	$top_1 = clear($_POST['top-1']);
	$top_2 = clear($_POST['top-2']);
	$top_3 = clear($_POST['top-3']);
	$top_4 = clear($_POST['top-4']);
	$top_5 = clear($_POST['top-5']);
	$semana = clear($_POST['semana']);
	$prosseguir = true;

	if($prosseguir == true) {
		mysql_query("UPDATE musicas_destaque SET id_um='$top_1', id_dois='$top_2', id_tres='$top_3', id_quatro='$top_4', id_cinco='$top_5', id_semana='$semana' LIMIT 1");
		logger("O usuário atualizou as configurações do site.", "acao");

		notificar("Informações atualizadas!","blue");
	}
	
}

$sql3 = mysql_query("SELECT * FROM musicas_destaque LIMIT 1");
$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">
		
		<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
			<?=$form_return;?>

			<div class="form-group">
				<label class="col-lg-3 control-label">TOP Músicas - #1</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="top-1" data-placeholder="Escolha uma música..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_musicas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_um'] == $sql5['id'])) ? 'selected="selected"' : '';?>><? $art = getArtista($sql5['id_artista']); echo $art['nome']; ?> - <?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">TOP Músicas - #2</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="top-2" data-placeholder="Escolha uma música..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_musicas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_dois'] == $sql5['id'])) ? 'selected="selected"' : '';?>><? $art = getArtista($sql5['id_artista']); echo $art['nome']; ?> - <?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">TOP Músicas - #3</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="top-3" data-placeholder="Escolha uma música..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_musicas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_tres'] == $sql5['id'])) ? 'selected="selected"' : '';?>><? $art = getArtista($sql5['id_artista']); echo $art['nome']; ?> - <?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">TOP Músicas - #4</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="top-4" data-placeholder="Escolha uma música..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_musicas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_quatro'] == $sql5['id'])) ? 'selected="selected"' : '';?>><? $art = getArtista($sql5['id_artista']); echo $art['nome']; ?> - <?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">TOP Músicas - #5</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="top-5" data-placeholder="Escolha uma música..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_musicas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_cinco'] == $sql5['id'])) ? 'selected="selected"' : '';?>><? $art = getArtista($sql5['id_artista']); echo $art['nome']; ?> - <?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Música da semana</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="semana" data-placeholder="Escolha uma música..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_musicas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_semana'] == $sql5['id'])) ? 'selected="selected"' : '';?>><? $art = getArtista($sql5['id_artista']); echo $art['nome']; ?> - <?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group form-submit">
				<label class="col-lg-3 control-label"></label>

				<input type="hidden" name="form_processa" value="s" />
				<div class="col-lg-9"><button type="submit" class="btn btn-success">Enviar</button></div>
			</div>
		</form>
		
	</div>
</div>