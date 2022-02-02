<? if($permissoes[12] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$nome = clear_mysql($_POST['nome']);
		$id_artista = clear_mysql($_POST['artista']);
		$imagem = $_FILES["imagem"];
		$prosseguir = true;
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}

		$tipos = array('jpg', 'jpeg', 'png', 'gif', 'bmp'); //só permite imagens
		if($prosseguir == true) { $upload = uploadFile($imagem, '../media/', $tipos, $rand, 'ph-'); }

		if($upload['erro'] == 1) {
			notificar("O arquivo que você está tentando enviar não é de uma imagem válida. (Arquivos permitidos: .jpg, .jpeg, .pnge .bmp)","red");
			$prosseguir = false;
		}

		if($upload['erro'] == 2) {
			notificar("Ocorreu um erro inesperado ao tentar enviar sua imagem. Contate a administração.","red");
			$prosseguir = false;
		}

		$caminho_img = $upload['caminho'];

		if($prosseguir == true) {
			mysql_query("INSERT INTO ph_albuns (nome, imagem, id_artista, autor, data) VALUES ('$nome', '$caminho_img', '$id_artista', '$autor', '$timestamp')");
			logger("O usuário adicionou um novo álbum no painel.", "acao");

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
				<label class="col-lg-2 control-label">Imagem (170x170)</label>
				<div class="col-lg-10"><input type="file" name="imagem" class="form-control"></div><br>
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

if($_GET['a'] == 2) {
	$id = anti_injecao($_GET['id']);
	
	if($_POST['form_processa'] == 's') {
		$nome = clear_mysql($_POST['nome']);
		$id_artista = clear_mysql($_POST['artista']);
		$imagem = $_FILES["imagem"];
		$prosseguir = true;
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}

		$sql3 = mysql_query("SELECT * FROM ph_albuns WHERE id='$id' LIMIT 1");
		$ex = mysql_fetch_array($sql3);

		$tipos = array('jpg', 'jpeg', 'png', 'gif', 'bmp'); //só permite imagens
		if($prosseguir == true && !empty($imagem["name"])) { $upload = uploadFile($imagem, '../media/uploads/', $tipos, $rand, 'ph-'); }
	
		if($upload['erro'] == 1) {
			notificar('O arquivo que você está tentando enviar não é de uma imagem válida. (Arquivos permitidos: .jpg, .jpeg, .png, .gif e .bmp)', 'red');
			$prosseguir = false;
		}
	
		if($upload['erro'] == 2) {
			notificar('Ocorreu um erro inesperado ao tentar enviar sua imagem. Contate a administração.', 'red');
			$prosseguir = false;
		}

		$caminho_img = $upload['caminho'];
		if(empty($imagem["name"])) { $caminho_img = $ex['imagem']; }
		
		if($prosseguir == true) {
			mysql_query("UPDATE ph_albuns SET nome='$nome', id_artista='$id_artista', imagem='$caminho_img' WHERE id='$id' LIMIT 1");
			logger("O usuário editou o álbum de ID #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM ph_albuns WHERE id='$id' LIMIT 1");
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
				<label class="col-lg-2 control-label">Imagem (170x170)</label>
				<div class="col-lg-10"><input type="file" name="imagem" class="form-control"><br>Imagem atual: <img src="<?=$ex['imagem'];?>"></div><br>
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
	mysql_query("DELETE FROM ph_albuns WHERE id='$id' LIMIT 1");
	logger("O usuário deletou o álbum [$id]", "acao");
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
					<th>Data</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				<? $limite = 20;
				$pagina = $_GET['pag'];
				((!$pagina)) ? $pagina = 1 : '';
				$inicio = ($pagina * $limite) - $limite;

				$query = "ph_albuns ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) {
					$artista = getArtista($sql2['id_artista']); ?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
					<td><?=$artista['nome'];?></td>
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