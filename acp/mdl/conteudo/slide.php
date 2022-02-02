<? if($permissoes[8] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$titulo = clear_mysql($_POST['titulo']);
		$descricao = clear_mysql($_POST['descricao']);
		$link = clear_mysql($_POST['link']);
		$imagem = $_FILES["imagem"];
		$prosseguir = true;
	
		if($titulo == '') {
			notificar("Digite um título.","red");
			$prosseguir = false;
		}

		if(strstr($link, 'http://')) {
			notificar("Não utilize \"http://\" no link.","red");
			$prosseguir = false;
		}

		if($link == '') {
			notificar("Digite um link.","red");
			$prosseguir = false;
		}

		$link = 'http://' . $link;

		$tipos = array('jpg', 'jpeg', 'png', 'gif', 'bmp'); //só permite imagens
		if($prosseguir == true) { $upload = uploadFile($imagem, '../media/uploads/', $tipos, $rand, 'slide-'); }
	
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
			mysql_query("INSERT INTO slide (titulo, link, imagem, autor, data, descricao) VALUES ('$titulo', '$link', '$caminho_img', '$autor', '$timestamp', '$descricao')");
			logger("O usuário adicionou um novo slide.", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	} ?>
<div class="panel panel-info">
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
	  			<label class="col-lg-2 control-label">Link</label>
	  			<div class="col-lg-10">
	  				<input type="text" name="link" class="form-control input-sm" value="<?=$_POST['link'];?>">
	  				<small>Não use http:// (utilize: www.demilovato.com ou demilovato.com [exemplo]).</small>
	  			</div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Imagem</label>
	  			<div class="col-lg-10">
	  				<input type="file" name="imagem" class="form-control input-sm">
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

if($_GET['a'] == 2) {
	$id = anti_injecao($_GET['id']);
	
	if($_POST['form_processa'] == 's') {
		$titulo = clear_mysql($_POST['titulo']);
		$descricao = clear_mysql($_POST['descricao']);
		$link = clear_mysql($_POST['link']);
		$imagem = $_FILES["imagem"];
		$prosseguir = true;
	
		if($titulo == '') {
			notificar("Digite um título.","red");
			$prosseguir = false;
		}

		if(strstr($link, 'http://')) {
			notificar("Não utilize \"http://\" no link.","red");
			$prosseguir = false;
		}

		if($link == '') {
			notificar("Digite um link.","red");
			$prosseguir = false;
		}

		$link = 'http://' . $link;

		$sql3 = mysql_query("SELECT * FROM slide WHERE id='$id' LIMIT 1");
		$ex = mysql_fetch_array($sql3);
				
		$tipos = array('jpg', 'jpeg', 'png', 'gif', 'bmp'); //só permite imagens
		if($prosseguir == true && !empty($imagem["name"])) { $upload = uploadFile($imagem, '../media/uploads/', $tipos, $rand, 'slide-'); }
	
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
			mysql_query("UPDATE slide SET titulo='$titulo', descricao='$descricao', link='$link', imagem='$caminho_img' WHERE id='$id' LIMIT 1");
			logger("O usuário editou o slide #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM slide WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-info">
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
	  			<label class="col-lg-2 control-label">Link</label>
	  			<div class="col-lg-10">
	  				<input type="text" name="link" class="form-control input-sm" value="<?=substr($ex['link'], 7);?>">
	  				<small>Não use http:// (utilize: www.demilovato.com ou demilovato.com [exemplo]).</small>
	  			</div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Imagem</label>
	  			<div class="col-lg-10">
	  				<img src="<?=$ex['imagem'];?>"><br>
	  				<input type="file" name="imagem" class="form-control input-sm">
	  				<small>Envie caso queira mudar a atual.</small>
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
	mysql_query("DELETE FROM slide WHERE id='$id' LIMIT 1");
	logger("O usuário deletou o slide [$id]", "acao");
}

if($_GET['a'] == '') { ?>
<div class="panel panel-info">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">
		<a href="?p=<?=$_GET['p'];?>&a=1" class="btn btn-success">Adicionar</a><br><br>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Título</th>
					<th>Link</th>
					<th>Cliques</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				<? $limite = 10;
				$pagina = $_GET['pag'];
				((!$pagina)) ? $pagina = 1 : '';
				$inicio = ($pagina * $limite) - $limite;

				$query = "slide ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) {
					$sql4 = mysql_query("SELECT id FROM slide_clicks WHERE id_slide='".$sql2['id']."'");?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['titulo'], 60));?></a></td>
					<td><?=$sql2['link'];?></td>
					<td><?=mysql_num_rows($sql4);?></td>
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