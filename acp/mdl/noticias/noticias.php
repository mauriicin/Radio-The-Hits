<? if($permissoes[15] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$titulo = clear_mysql($_POST['titulo']);
		$descricao = clear_mysql($_POST['descricao']);
		$artistas = clear_mysql($_POST['artistas']);
		$imagem = $_FILES["imagem"];
		$status = clear_mysql($_POST['status']);
		$comentarios = clear_mysql($_POST['comentarios']);
		$categoria = anti_injecao($_POST['categoria']);
		$fixo = clear_mysql($_POST['fixo']);
		$conteudo = $_POST['conteudo'];
		$prosseguir = true;

		if($permissoes[16] == 's') {
			if($status == 1) { $status = 'Ativo'; } else { $status = 'Em rascunho'; }
			if($status != 'Ativo' && $status != 'Em rascunho') { $status = 'Em rascunho'; }
		} else { $status = 'Em rascunho'; }

		if($permissoes[17] == 's') {
			if($fixo == 'on') { $fixo = 's'; } else { $fixo = 'n'; }
			if($fixo != 's' && $fixo != 'n') { $fixo = 'n'; }
		} else { $fixo = 'n'; }

		if($comentarios == 'on') { $comentarios = 's'; } else { $comentarios = 'n'; }
		if($comentarios != 's' && $comentarios != 'n') { $comentarios = 'n'; }
	
		if($titulo == '') {
			notificar("Digite um título.","red");
			$prosseguir = false;
		}
		
		if($descricao == '') {
			notificar("Digite uma descrição.","red");
			$prosseguir = false;
		}

		if($conteudo == '') {
			notificar("Digite uma notícia.","red");
			$prosseguir = false;
		}

		$tipos = array('jpg', 'jpeg', 'png', 'gif', 'bmp'); //só permite imagens
		if($prosseguir == true) { $upload = uploadFile($imagem, '../media/uploads/', $tipos, $rand); }
	
		if($upload['erro'] == 1) {
			notificar('O arquivo que você está tentando enviar não é de uma imagem válida. (Arquivos permitidos: .jpg, .jpeg, .png, .gif e .bmp)', 'red');
			$prosseguir = false;
		}
	
		if($upload['erro'] == 2) {
			notificar('Ocorreu um erro inesperado ao enviar a imagem. Contate a administração.', 'red');
			$prosseguir = false;
		}

		if($imagem["name"] == '') {
			notificar('Envie uma imagem.', 'red');
			$prosseguir = false;
		}
		
		if($prosseguir == true) {
			$caminho_img = $upload['caminho'];
			$artistas = str_replace(', ', '|', $artistas);
			mysql_query("INSERT INTO noticias (titulo, descricao, artistas, imagem, noticia, status, autor, data, fixo, comentarios, cat_id) VALUES ('$titulo', '$descricao', '$artistas', '$caminho_img', '$conteudo', '$status', '$autor', '$timestamp', '$fixo', '$comentarios', '$categoria')") or die(mysql_error());
			logger("O usuário adicionou uma notícia.", "acao");

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
	  			<label class="col-lg-2 control-label">Título</label>
	  			<div class="col-lg-10"><input type="text" name="titulo" class="form-control input-sm" value="<?=$_POST['titulo'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Descrição</label>
	  			<div class="col-lg-10"><input type="text" name="descricao" class="form-control input-sm" value="<?=$_POST['descricao'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Artistas relacionados</label>
	  			<div class="col-lg-10"><input type="text" name="artistas" class="form-control input-sm" value="<?=$_POST['artistas'];?>"><br><small>Digite o nome exato, separando por vírgula seguida de espaço. Ex: <b>Demi Lovato, Selena Gomez</b></small></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Imagem</label>
	  			<div class="col-lg-10"><input type="file" name="imagem" class="form-control input-sm"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Categoria</label>
	  			<div class="col-lg-5">
	  				<select name="categoria" class="form-control">
	  					<? $sql4 = mysql_query("SELECT * FROM noticias_cat ORDER BY nome ASC");
	  					while($sql5 = mysql_fetch_array($sql4)) { ?>
	  					<option value="<?=$sql5['id'];?>" <? if($_POST['cat_id'] == $sql5['id']) { echo 'selected="selected"'; } ?>><?=clear($sql5['nome']);?></option>
	  					<? } ?>
	  				</select>
	  			</div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Status</label>
	  			<div class="col-lg-5">
	  				<select class="form-control" id="status" name="status">
	  					<? if($permissoes[16] == 's') { ?><option value="1">Ativo</option><? } ?>
	  					<option value="2" <? if($permissoes[16] == 'n') { ?>selected="selected"<? } ?>>Rascunho/Revisão</option>
	  				</select>
	  			</div><br>
	  		</div>	  		

	  		<? if($permissoes[17] == 's') { ?>
	  		<div class="form-group">
	  			<label class="col-lg-2 control-label"></label>
	  			<div class="col-lg-2">
	  				<input type="checkbox" <? if($_POST['fixo'] == 's') { echo 'checked="checked"'; } ?> name="fixo">
	  				<div style="font-weight:bold;padding:5px;display:inline-block;">Notícia fixa</div>
	  			</div><br>
	  		</div>
	  		<? } ?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label"></label>
	  			<div class="col-lg-3">
	  				<input type="checkbox" checked="checked" name="comentarios">
	  				<div style="font-weight:bold;padding:5px;display:inline-block;">Permitir comentários</div>
	  			</div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Conteúdo</label>
	  			<div class="col-lg-10"><textarea name="conteudo" class="ckeditor"><?=$_POST['conteudo'];?></textarea></div><br>
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
		$titulo = clear_mysql($_POST['titulo']);
		$descricao = clear_mysql($_POST['descricao']);
		$artistas = clear_mysql($_POST['artistas']);
		$noticia = ($_POST['conteudo']);
		$imagem = $_FILES["imagem"];
		$status = anti_injecao($_POST['status']);
		$fixo = anti_injecao($_POST['fixo']);
		$comentarios = clear_mysql($_POST['comentarios']);
		$categoria = anti_injecao($_POST['categoria']);
		$prosseguir = true;

		if($permissoes[16] == 's') {
			if($status == 1) { $status = 'Ativo'; } else { $status = 'Em rascunho'; }
			if($status != 'Ativo' && $status != 'Em rascunho') { $status = 'Em rascunho'; }
		} else { $status = 'Em rascunho'; }

		if($permissoes[17] == 's') {
			if($fixo == 'on') { $fixo = 's'; } else { $fixo = 'n'; }
			if($fixo != 's' && $fixo != 'n') { $fixo = 'n'; }
		} else { $fixo = 'n'; }

		if($comentarios == 'on') { $comentarios = 's'; } else { $comentarios = 'n'; }
		if($comentarios != 's' && $comentarios != 'n') { $comentarios = 'n'; }
	
		if($titulo == '') {
			notificar("Digite um título.","red");
			$prosseguir = false;
		}
		
		if($descricao == '') {
			notificar("Digite uma descrição.","red");
			$prosseguir = false;
		}

		if($noticia == '') {
			notificar("Digite uma notícia.","red");
			$prosseguir = false;
		}

		$sql3 = mysql_query("SELECT * FROM noticias WHERE id='$id' LIMIT 1");
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
		if(empty($imagem["name"])) { $caminho_img = $ex['imagem']; }
		
		if($prosseguir == true) {
			$artistas = str_replace(', ', '|', $artistas);
			mysql_query("UPDATE noticias SET titulo='$titulo', descricao='$descricao', artistas='$artistas', cat_id='$categoria', imagem='$caminho_img', fixo='$fixo', noticia='$noticia', status='$status', comentarios='$comentarios' WHERE id='$id' LIMIT 1") or die(mysql_error());
			logger("O usuário editou a notícia de ID #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM noticias WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Título</label>
	  			<div class="col-lg-10"><input type="text" name="titulo" class="form-control input-sm" value="<?=$ex['titulo'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Descrição</label>
	  			<div class="col-lg-10"><input type="text" name="descricao" class="form-control input-sm" value="<?=$ex['descricao'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Artistas relacionados</label>
	  			<div class="col-lg-10"><input type="text" name="artistas" class="form-control input-sm" value="<?=str_replace('|', ', ', $ex['artistas']);?>"><br><small>Digite o nome exato, separando por vírgula seguida de espaço. Ex: <b>Demi Lovato, Selena Gomez</b></small></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Imagem</label>
	  			<div class="col-lg-10"><input type="file" name="imagem" class="form-control input-sm"><br>
	  				<small>Envie apenas caso queira mudar a atual.</small><br><br>
	  				<img src="<?=$ex['imagem'];?>">
	  			</div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Categoria</label>
	  			<div class="col-lg-5">
	  				<select name="categoria" class="form-control">
	  					<? $sql4 = mysql_query("SELECT * FROM noticias_cat ORDER BY nome ASC");
	  					while($sql5 = mysql_fetch_array($sql4)) { ?>
	  					<option value="<?=$sql5['id'];?>" <? if($ex['cat_id'] == $sql5['id']) { echo 'selected="selected"'; } ?>><?=clear($sql5['nome']);?></option>
	  					<? } ?>
	  				</select>
	  			</div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Status</label>
	  			<div class="col-lg-5">
	  				<select class="form-control" id="status" name="status">
	  					<? if($permissoes[16] == 's') { ?><option value="1" <? if($ex['status'] == 'Ativo') { echo 'selected="selected"'; } ?>>Ativo</option><? } ?>
	  					<option value="2" <? if($permissoes[16] == 'n' || $ex['status'] == 'Em rascunho') { ?>selected="selected"<? } ?>>Rascunho/Revisão</option>
	  				</select>
	  			</div><br>
	  		</div>	  		

	  		<? if($permissoes[17] == 's') { ?>
	  		<div class="form-group">
	  			<label class="col-lg-2 control-label"></label>
	  			<div class="col-lg-2">
	  				<input type="checkbox" <? if($ex['fixo'] == 's') { echo 'checked="checked"'; } ?> name="fixo">
	  				<div style="font-weight:bold;padding:5px;display:inline-block;">Notícia fixa</div>
	  			</div><br>
	  		</div>
	  		<? } ?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label"></label>
	  			<div class="col-lg-3">
	  				<input type="checkbox" <? if($ex['comentarios'] == 's') { echo 'checked="checked"'; } ?> name="comentarios">
	  				<div style="font-weight:bold;padding:5px;display:inline-block;">Permitir comentários</div>
	  			</div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Conteúdo</label>
	  			<div class="col-lg-10"><textarea name="conteudo" class="ckeditor"><?=$ex['noticia'];?></textarea></div><br>
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
	mysql_query("DELETE FROM noticias WHERE id='$id' LIMIT 1");
	mysql_query("DELETE FROM noticias_coment WHERE local='$id' LIMIT 1");
	mysql_query("DELETE FROM noticias_votos WHERE id_not='$id' LIMIT 1");
	logger("O usuário deletou uma notícia [$id]", "acao");
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
					<th>Título</th>
					<th>Status</th>
					<th>Autor</th>
					<th>Data</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				<? $limite = 10;
				$pagina = $_GET['pag'];
				((!$pagina)) ? $pagina = 1 : '';
				$inicio = ($pagina * $limite) - $limite;

				$query = "noticias ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) {
					if($sql2['status'] == 'Ativo') {
						$status = '<span class="label label-success">ATIVO</span>';
					} else {
						$status = '<span class="label label-danger">RASCUNHO</span>';
					}
					?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['titulo'], 60));?></a></td>
					<td><?=$status;?></td>
					<td><?=$sql2['autor'];?></td>
					<td><?=date('d/m/y H:i', $sql2['data']);?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><button type="button" class="btn btn-warning btn-xs">Editar</button></a>
					<button type="button" class="btn btn-danger btn-xs" onclick="deletar(this);" rel="?p=<?=$_GET['p'];?>&a=3&id=<?=$sql2['id'];?>">Deletar</button>
					</td>
				</tr>
				<? } ?>
				<? if(mysql_num_rows($sql) == 0) {
					echo aviso_red("Nenhum registro.");
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