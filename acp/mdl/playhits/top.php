<? if($permissoes[22] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$id_musica = anti_injecao($_POST['musica']);
		$prosseguir = true;

		$sql8 = mysql_query("SELECT id FROM radio_top WHERE id_musica='$id_musica'");

		if(mysql_num_rows($sql8) > 0) {
			notificar("Esta música já está no Top 10.", "red");
			$prosseguir = false;
		}
		
		if($prosseguir == true) {
			$sql6 = mysql_query("SELECT * FROM radio_top WHERE data_termino != 0 AND id_programacao != 0 LIMIT 1");
			$sql7 = mysql_fetch_array($sql6);
			$id_programacao = $sql7['id_programcao'];
			$data_termino = $sql7['data_termino'];
			mysql_query("INSERT INTO radio_top (id_musica, id_programacao, data_termino, autor, data) VALUES ('$id_musica', '$id_programacao', '$data_termino', '$autor', '$timestamp')");
			logger("O usuário adicionou uma nova música no Top 10.", "acao");

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
				<label class="col-lg-3 control-label">Música a ser adicionada</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="musica" data-placeholder="Escolha uma música..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM ph_musicas ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) {
							$art = getArtista($sql5['id_artista']); ?>
						<option value="<?=$sql5['id'];?>" <?=(($_POST['musica'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=$art['nome'];?> - <?=clear($sql5['nome']);?></option>
						<? } ?>
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

if($_GET['a'] == 2) {
	if($_POST['form_processa'] == 's') {
		$id_programacao = anti_injecao($_POST['programacao']);
		$termino = anti_injecao($_POST['termino']);
		$prosseguir = true;
	
		if($termino == '') {
			notificar("Digite um horário de término da votação.","red");
			$prosseguir = false;
		}

		$a = $termino;
		$hora = substr($a, 11);
		$minuto = substr($a, 14);
		$b = explode('/', $a);
		$dia = $b[0];
		$mes = $b[1];
		$ano = substr($b[2], 0, 4);
		
		$termino = mktime($hora,$minuto,00,$mes,$dia,$ano);
		
		if($prosseguir == true) {
			mysql_query("UPDATE radio_top SET id_programacao='$id_programacao', data_termino='$termino'");
			logger("O usuário editou as configurações do Top 10 #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM radio_top WHERE id_programacao > 0 LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
				<label class="col-lg-3 control-label">Programação da rádio que será tocado o Top 10</label>
				<div class="col-lg-9" style="padding-top:10px;">
					<select name="programacao" data-placeholder="Escolha uma programação..." class="chosen-select" style="width:350px;" tabindex="2">
						<option value=""></option>
						<? $sql4 = mysql_query("SELECT * FROM radio_prog ORDER BY nome ASC");
						while($sql5 = mysql_fetch_array($sql4)) { ?>
						<option value="<?=$sql5['id'];?>" <?=(($ex['id_programacao'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['nome']);?></option>
						<? } ?>
					</select>
				</div><br>
			</div>

			<div class="form-group">
	  			<label class="col-lg-2 control-label">Horário de término da votação</label>
	  			<div class="col-lg-10"><input type="text" name="termino" class="form-control input-sm" value="<?=date('d/m/Y H:i', $ex['data_termino']);?>"><br><small>Use o modelo DD/MM/AAAA HH:MM - Ex: 16/12/2014 15:30</small></div><br>
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
	mysql_query("DELETE FROM radio_top WHERE id='$id' LIMIT 1");
	logger("O usuário deletou uma música do Top 10 [$id]", "acao");
}

if($_GET['a'] == '') { ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?> - Músicas</h3></div>
	<div class="panel-body">
		<a href="?p=<?=$_GET['p'];?>&a=1" class="btn btn-success">Adicionar</a>
		<a href="?p=<?=$_GET['p'];?>&a=2" class="btn btn-warning">Configurações dessa semana</a><br><br>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nome da música</th>
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

				$query = "radio_top ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) { 
					$sql3 = mysql_query("SELECT * FROM ph_musicas WHERE id='".$sql2['id_musica']."' LIMIT 1");
					$sql4 = mysql_fetch_array($sql3); ?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><?=clear(encurtar($sql4['nome'], 60));?></td>
					<td><?=$sql2['autor'];?></td>
					<td><?=date('d/m/y H:i', $sql2['data']);?></td>
					<td><button type="button" class="btn btn-danger btn-xs" onclick="deletar(this);" rel="?p=<?=$_GET['p'];?>&a=3&id=<?=$sql2['id'];?>">Deletar</button>
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