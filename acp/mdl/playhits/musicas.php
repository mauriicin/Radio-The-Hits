<? if($permissoes[13] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$nome = clear_mysql($_POST['nome']);
		$id_artista = clear_mysql($_POST['artista']);
		$id_album = clear_mysql($_POST['album']);
		$audio = clear_mysql($_POST['audio']);
		$video = clear_mysql($_POST['video']);
		$letra = clear_mysql($_POST['letra']);
		$prosseguir = true;

		if($_POST['status'] == 1) { $status = 'aprovada'; }
		if($_POST['status'] == 2) { $status = 'reprovada'; }
		if($_POST['status'] == 3) { $status = 'aguardando'; }
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		if($audio == '') {
			notificar("Digite o link do vídeo de áudio.","red");
			$prosseguir = false;
		}

		if($video == '') {
			notificar("Digite o link do vídeo.","red");
			$prosseguir = false;
		}
		
		if($prosseguir == true) {
			mysql_query("INSERT INTO ph_musicas (id_artista, id_album, nome, audio, video, letra, status, autor, data) VALUES ('$id_artista', '$id_album', '$nome', '$audio', '$video', '$letra', '$status', '$autor', '$timestamp')") or die(mysql_error());
			logger("O usuário adicionou uma nova música.", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	} ?>
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Nome</label>
	  			<div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=$_POST['nome'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
				<label class="col-lg-3 control-label">Artista</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="artista" data-placeholder="Escolha um artista..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_artistas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($_POST['artista'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Álbum</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="album" data-placeholder="Escolha um álbum..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_albuns ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($_POST['album'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Link do audio (YouTube)</label>
	  			<div class="col-lg-10"><input type="text" name="audio" class="form-control input-sm" value="<?=$_POST['audio'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Link do vídeo (YouTube)</label>
	  			<div class="col-lg-10"><input type="text" name="video" class="form-control input-sm" value="<?=$_POST['video'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Letra da música</label>
	  			<div class="col-lg-10"><textarea name="letra" class="form-control input-sm" style="height:200px;"><?=$_POST['letra'];?></textarea>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Status</label>
	  			<div class="col-lg-5">
	  				<select class="form-control" id="status" name="status">
	  					<option value="1" <?=(($_POST['status'] == 1)) ? 'selected="selected"' : '';?>>Aprovada</option>
	  					<option value="2" <?=(($_POST['status'] == 2)) ? 'selected="selected"' : '';?>>Reprovada</option>
	  					<option value="3" <?=(($_POST['status'] == 3)) ? 'selected="selected"' : '';?>>Aguardando aprovação</option>
	  				</select>
	  			</div><br>
	  		</div>

	  		<br>

	  		<div class="form-group form-submit">
	  			<label class="col-lg-2 control-label"></label>

	  			<input type="hidden" name="form_processa" value="s" />
	  			<div class="col-lg-10"><button type="submit" class="btn btn-success">Enviar</button></div>
	  		</div>
	  	</form>
	  </div>
</div>
<? }

if($_GET['a'] == 2) {
	$id = anti_injecao($_GET['id']);
	
	if($_POST['form_processa'] == 's') {
		$nome = clear_mysql($_POST['nome']);
		$id_artista = clear_mysql($_POST['artista']);
		$id_album = clear_mysql($_POST['album']);
		$audio = clear_mysql($_POST['audio']);
		$video = clear_mysql($_POST['video']);
		$letra = clear_mysql($_POST['letra']);
		$prosseguir = true;

		if($_POST['status'] == 1) { $status = 'aprovada'; }
		if($_POST['status'] == 2) { $status = 'reprovada'; }
		if($_POST['status'] == 3) { $status = 'aguardando'; }
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		if($audio == '') {
			notificar("Digite o link do vídeo de áudio.","red");
			$prosseguir = false;
		}

		if($video == '') {
			notificar("Digite o link do vídeo.","red");
			$prosseguir = false;
		}
		
		if($prosseguir == true) {
			mysql_query("UPDATE ph_musicas SET nome='$nome', id_artista='$id_artista', id_album='$id_album', audio='$audio', video='$video', letra='$letra', status='$status' WHERE id='$id' LIMIT 1");
			logger("O usuário editou a música #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM ph_musicas WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Nome</label>
	  			<div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=clear($ex['nome']);?>"></div><br>
	  		</div>

	  		<div class="form-group">
				<label class="col-lg-3 control-label">Artista</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="artista" data-placeholder="Escolha um artista..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_artistas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_artista'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Álbum</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="album" data-placeholder="Escolha um álbum..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_albuns ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_album'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Link do audio (YouTube)</label>
	  			<div class="col-lg-10"><input type="text" name="audio" class="form-control input-sm" value="<?=clear($ex['audio']);?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Link do vídeo (YouTube)</label>
	  			<div class="col-lg-10"><input type="text" name="video" class="form-control input-sm" value="<?=clear($ex['video']);?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Letra da música</label>
	  			<div class="col-lg-10"><textarea name="letra" class="form-control input-sm" style="height:200px;"><?=clear($ex['letra']);?></textarea>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Status</label>
	  			<div class="col-lg-5">
	  				<select class="form-control" id="status" name="status">
	  					<option value="1" <?=(($ex['status'] == 'aprovada')) ? 'selected="selected"' : '';?>>Aprovada</option>
	  					<option value="2" <?=(($ex['status'] == 'reprovada')) ? 'selected="selected"' : '';?>>Reprovada</option>
	  					<option value="3" <?=(($ex['status'] == 'aguardando')) ? 'selected="selected"' : '';?>>Aguardando aprovação</option>
	  				</select>
	  			</div><br>
	  		</div>

	  		<div class="form-group form-submit">
	  			<label class="col-lg-2 control-label"></label>

	  			<input type="hidden" name="form_processa" value="s" />
	  			<div class="col-lg-10"><button type="submit" class="btn btn-success">Enviar</button></div>
	  		</div>
	  	</form>
	  </div>
</div>
<? }

if($_GET['a'] == 3) {
	$id = anti_injecao($_GET['id']);
	mysql_query("DELETE FROM ph_musicas WHERE id='$id' LIMIT 1");
	logger("O usuário deletou a música [$id]", "acao");
}

if($_GET['a'] == '') { ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">
		<a href="?p=<?=$_GET['p'];?>&a=1" class="btn btn-success">Adicionar</a><br><br>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nome</th>
					<th>Artista</th>
					<th>Álbum</th>
					<th>Data</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				<? $limite = 10;
				$pagina = $_GET['pag'];
				((!$pagina)) ? $pagina = 1 : '';
				$inicio = ($pagina * $limite) - $limite;

				$query = "ph_musicas ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) {
					$artista = getArtista($sql2['id_artista']);
					$album = getAlbum($sql2['id_album']); ?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
					<td><?=clear($artista['nome']);?></td>
					<td><?=clear($album['nome']);?></td>
					<td><?=date('d/m/y H:i', $sql2['data']);?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><button type="button" class="btn btn-warning btn-xs">Editar</button></a>
					<button type="button" class="btn btn-danger btn-xs" onclick="deletar(this);" rel="?p=<?=$_GET['p'];?>&a=3&id=<?=$sql2['id'];?>">Deletar</button>
					</td>
				</tr>
				<? } ?>
				<? if(mysql_num_rows($sql) == 0) {
					echo aviso_red("Nenhum registro a ser exibido.");
				} ?>
			</tbody>
		</table>

		<ul class="pagination">
		<? $consulta = mysql_query("SELECT id FROM $query");
		$total_registros = mysql_num_rows($consulta);

		$total_paginas = ceil($total_registros / $limite);

		$links_laterais = ceil($limite / 2);

		$inicio = $pagina - $links_laterais;
		$limite = $pagina + $links_laterais;

		for ($i = $inicio; $i <= $limite; $i++){
			if ($i == $pagina) {
				echo '<li class="active"><a href="#">'.$i.'</a></li>';
			} else {
				if ($i >= 1 && $i <= $total_paginas){
					$link = '?' . $_SERVER["QUERY_STRING"];
					$link = ereg_replace('&pag=(.*)', '', $link);
					echo '<li><a href="'.$link.'&pag='.$i.'">'.$i.'</a></li>';
				}
			}
		}
		?>
		</ul>
	</div>
</div>
<? } ?>