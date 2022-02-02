<? if($permissoes[10] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$titulo = clear_mysql($_POST['titulo']);
		$conteudo = $_POST['conteudo'];
		$restrito = $_POST['restrito'];
		$prosseguir = true;

		if($restrito == 'on') { $restrito = 's'; } else { $restrito = 'n'; }
		if($restrito != 's' && $restrito != 'n') { $restrito = 'n'; }
	
		if($titulo == '') {
			notificar("Digite um título.","red");
			$prosseguir = false;
		}
		
		if($conteudo == '') {
			notificar("Digite um conteúdo.","red");
			$prosseguir = false;
		}
		
		if($prosseguir == true) {
			mysql_query("INSERT INTO paginas (titulo, conteudo, restrito, autor, data) VALUES ('$titulo', '$conteudo', '$restrito', '$autor', '$timestamp')");
			logger("O usuário adicionou uma nova página. [$titulo]", "acao");

			$sql4 = mysql_query("SELECT * FROM paginas WHERE autor='$autor' ORDER BY id DESC LIMIT 1");
			$sql5 = mysql_fetch_array($sql4);
			notificar("Sucesso!","blue");
			notificar("Link: <a target=\"_blank\" href= \"/paginas/".$sql5['id']."/".trataurl($sql5['titulo'])."\">www.radiothehits.com/paginas/".$sql5['id']."/".trataurl($sql5['titulo'])."</a>","yellow");
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
	  			<label class="col-lg-2 control-label">Conteúdo</label>
	  			<div class="col-lg-10"><textarea name="conteudo" class="ckeditor"><?=$_POST['conteudo'];?></textarea></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Página restrita</label>
	  			<div class="col-lg-10">
	  				<input type="checkbox" name="restrito" type="checkbox" <?=(($_POST['restrito'] == 's')) ? 'checked="checked"' : '';?>><br>
	  				<small>Caso marque, somente os membros da equipe poderão visualizá-la.</small>
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
		$conteudo = $_POST['conteudo'];
		$restrito = $_POST['restrito'];
		$prosseguir = true;

		if($restrito == 'on') { $restrito = 's'; } else { $restrito = 'n'; }
		if($restrito != 's' && $restrito != 'n') { $restrito = 'n'; }
	
		if($titulo == '') {
			notificar("Digite um título.","red");
			$prosseguir = false;
		}
		
		if($conteudo == '') {
			notificar("Digite um conteúdo.","red");
			$prosseguir = false;
		}
		
		if($prosseguir == true) {
			mysql_query("UPDATE paginas SET titulo='$titulo', conteudo='$conteudo', restrito='$restrito' WHERE id='$id' LIMIT 1");
			logger("O usuário editou a página de ID #$id", "acao");

			$sql3 = mysql_query("SELECT * FROM paginas WHERE id='$id' LIMIT 1");
			$ex = mysql_fetch_array($sql3); 

			notificar("Link: <a target=\"_blank\" href= \"/paginas/".$ex['id']."/".trataurl($ex['titulo'])."\">www.radiothehits.com/paginas/".$ex['id']."/".trataurl($ex['titulo'])."</a>","blue");
			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM paginas WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<div class="well">Link para a página:<br><br>
	  		<a href="/paginas/<?=$ex['id'];?>/<?=trataurl($ex['titulo']);?>" target="_blank"><span class="label label-primary">http://www.radiothehits.com/paginas/<?=$ex['id'];?>/<?=trataurl($ex['titulo']);?></span></a>
	  	</div>

	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Título</label>
	  			<div class="col-lg-10"><input type="text" name="titulo" class="form-control input-sm" value="<?=$ex['titulo'];?>"></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Conteúdo</label>
	  			<div class="col-lg-10"><textarea name="conteudo" class="ckeditor"><?=$ex['conteudo'];?></textarea></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Página restrita</label>
	  			<div class="col-lg-10">
	  				<input type="checkbox" name="restrito" type="checkbox" <?=(($ex['restrito'] == 's')) ? 'checked="checked"' : '';?>><br>
	  				<small>Caso marque, somente os membros da equipe poderão visualizá-la.</small>
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
	mysql_query("DELETE FROM paginas WHERE id='$id' LIMIT 1");
	logger("O usuário deletou a página [$id]", "acao");
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
					<th>Autor</th>
					<th>Data</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				<? $limite = 10;
				$pagina = $_GET['pag'];
				((!$pagina)) ? $pagina = 1 : '';
				$inicio = ($pagina * $limite) - $limite;

				$query = "paginas ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) { ?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['titulo'], 60));?></a></td>
					<td><?=$sql2['autor'];?></td>
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