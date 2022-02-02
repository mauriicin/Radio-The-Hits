<? if($permissoes[11] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$nome = clear_mysql($_POST['nome']);
		$fc = clear_mysql($_POST['fc']);
		$imagem = $_FILES["imagem"];
		$ult_album = clear_mysql($_POST['ult_album']);
		$facebook = clear_mysql($_POST['facebook']);
		$twitter = clear_mysql($_POST['twitter']);
		$prosseguir = true;

		$sql6 = mysql_query("SELECT * FROM ph_albuns WHERE id='$ult_album' LIMIT 1");
		$sql7 = mysql_fetch_array($sql6);
		$ult_album = $sql7['nome'];
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		if($imagem == '') {
			notificar("Digite a URL de uma imagem.","red");
			$prosseguir = false;
		}

		if(strstr($facebook, "http://") || strstr($facebook, "www.") || strstr($facebook, "facebook.com") || strstr($twitter, "http://") || strstr($twitter, "www.") || strstr($twitter, "twitter.com")) {
			notificar("Não envie links nos campos Facebook ou Twitter. Envie apenas o nome de usuário.","red");
			$prosseguir = false;
		}

		if($facebook != '') { $facebook = 'http://www.facebook.com/' . $facebook; } else {$facebook='';}
		if($twitter != '') { $twitter = 'http://www.twitter.com/' . $twitter; } else {$twitter='';}

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

		if($prosseguir == true) {
			$caminho_img = $upload['caminho'];
			mysql_query("INSERT INTO ph_artistas (nome, imagem, ult_album, facebook, twitter, autor, data, fc) VALUES ('$nome', '$caminho_img', '$ult_album', '$facebook', '$twitter', '$autor', '$timestamp', '$fc')") or die(mysql_error());
			logger("O usuário adicionou um novo artista no painel.", "acao");

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
	  			<label class="col-lg-2 control-label">Link do fã-clube</label>
	  			<div class="col-lg-10"><input type="text" name="fc" class="form-control input-sm" value="<?=$_POST['fc'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
				<label class="col-lg-2 control-label">Imagem</label>
				<div class="col-lg-10"><input type="file" name="imagem" class="form-control"></div><br>
			</div>

	  		<div class="form-group">
				<label class="col-lg-3 control-label">Último álbum</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="ult_album" data-placeholder="Escolha um álbum..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_albuns ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($_POST['ult_album'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

	  		<div class="form-group">
				<label class="col-lg-2 control-label">Facebook</label>
				<div class="col-lg-5">
					<input type="text" name="facebook" class="form-control input-sm" placeholder="Digite apenas o usuário (ex: FNXHenry)" value="<?=(($ex['facebook']!=''))?substr($ex['facebook'], 24):'';?>">
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Twitter</label>
				<div class="col-lg-5">
					<input type="text" name="twitter" class="form-control input-sm" placeholder="Digite apenas o usuário (ex: @FNXHenry)" value="<?=(($ex['twitter']!=''))?substr($ex['twitter'], 23):'';?>">
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
		$nome = clear_mysql($_POST['nome']);
		$fc = clear_mysql($_POST['fc']);
		$imagem = $_FILES["imagem"];
		$ult_album = clear_mysql($_POST['ult_album']);
		$facebook = clear_mysql($_POST['facebook']);
		$twitter = clear_mysql($_POST['twitter']);
		$prosseguir = true;

		$sql6 = mysql_query("SELECT * FROM ph_albuns WHERE id='$ult_album' LIMIT 1");
		$sql7 = mysql_fetch_array($sql6);
		$ult_album = $sql7['nome'];
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		if($imagem == '') {
			notificar("Digite a URL de uma imagem.","red");
			$prosseguir = false;
		}

		if($ult_album == '') {
			notificar("Digite o nome do último álbum.","red");
			$prosseguir = false;
		}

		if(strstr($facebook, "http://") || strstr($facebook, "www.") || strstr($facebook, "facebook.com") || strstr($twitter, "http://") || strstr($twitter, "www.") || strstr($twitter, "twitter.com")) {
			notificar("Não envie links nos campos Facebook ou Twitter. Envie apenas o nome de usuário.","red");
			$prosseguir = false;
		}

		if($facebook != '') { $facebook = 'http://www.facebook.com/' . $facebook; } else {$facebook='';}
		if($twitter != '') { $twitter = 'http://www.twitter.com/' . $twitter; } else {$twitter='';}

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

		$sql3 = mysql_query("SELECT * FROM ph_artistas WHERE id='$id' LIMIT 1");
		$ex = mysql_fetch_array($sql3);
		
		$caminho_img = $upload['caminho'];
		if(empty($imagem["name"])) { $caminho_img = $ex['imagem']; }
		
		if($prosseguir == true) {
			mysql_query("UPDATE ph_artistas SET nome='$nome', fc='$fc', imagem='$caminho_img', ult_album='$ult_album', facebook='$facebook', twitter='$twitter' WHERE id='$id' LIMIT 1");
			logger("O usuário editou o artista de ID #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM ph_artistas WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Nome</label>
	  			<div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=$ex['nome'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Link do fã-clube</label>
	  			<div class="col-lg-10"><input type="text" name="fc" class="form-control input-sm" value="<?=$ex['fc'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
				<label class="col-lg-2 control-label">Imagem</label>
				<div class="col-lg-10"><input type="file" name="imagem" class="form-control"><br>Imagem atual: <img src="<?=$ex['imagem'];?>"></div><br>
			</div>

	  		<div class="form-group">
				<label class="col-lg-3 control-label">Último álbum</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="ult_album" data-placeholder="Escolha um álbum..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_albuns ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['ult_album'] == $sql5['nome'])) ? 'selected="selected"' : '';?>><?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

	  		<div class="form-group">
				<label class="col-lg-2 control-label">Facebook</label>
				<div class="col-lg-5">
					<input type="text" name="facebook" class="form-control input-sm" placeholder="Digite apenas o usuário (ex: FNXHenry)" value="<?=(($ex['facebook']!=''))?substr($ex['facebook'], 24):'';?>">
				</div><br>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">Twitter</label>
				<div class="col-lg-5">
					<input type="text" name="twitter" class="form-control input-sm" placeholder="Digite apenas o usuário (ex: @FNXHenry)" value="<?=(($ex['twitter']!=''))?substr($ex['twitter'], 23):'';?>">
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
	mysql_query("DELETE FROM ph_artistas WHERE id='$id' LIMIT 1");
	logger("O usuário deletou o artista [$id]", "acao");
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
					<th>Último álbum</th>
					<th>Data</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				<? $limite = 20;
				$pagina = $_GET['pag'];
				((!$pagina)) ? $pagina = 1 : '';
				$inicio = ($pagina * $limite) - $limite;

				$query = "ph_artistas ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) { ?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
					<td><?=$sql2['ult_album'];?></td>
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