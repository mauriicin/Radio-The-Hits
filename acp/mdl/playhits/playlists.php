<? if($permissoes[14] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$nome = clear_mysql($_POST['nome']);
		$musicas = array();
		$prosseguir = true;
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		$sql8 = mysql_query("SELECT id FROM ph_musicas");
		while($sql9 = mysql_fetch_array($sql8)) {
			$campo = $_POST['m-' . $sql9['id']];

			if($campo == 'on') {
				$musicas[] = $sql9['id'];
			}
		}

		$musicas = implode('|', $musicas);

		if($prosseguir == true) {
			$equipe = 'n';
			$status = 'aprovada';

			mysql_query("INSERT INTO ph_playlists (nome, musicas, equipe, status, autor, data) VALUES ('$nome', '$musicas', '$equipe', '$status', '$autor', '$timestamp')");
			logger("O usuário adicionou uma nova playlist.", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	} ?>
	<? $musicas_nome = array();
	$musicas_id = array();
	$sql6 = mysql_query("SELECT * FROM ph_artistas ORDER BY nome ASC");
	while($sql7 = mysql_fetch_array($sql6)) { 
		$sql8 = mysql_query("SELECT * FROM ph_musicas WHERE id_artista='".$sql7['id']."'");
		while($sql9 = mysql_fetch_array($sql8)) {
			$musicas_nomes[] = clear(strtolower($sql9['nome']));
			$musicas_id[] = $sql9['id'];
		}
	}

	$nomes = '';
	foreach ($musicas_nomes as $atual) {
		$nomes .= '"'.$atual.'",';
	}

	$nomes = substr($nomes, 0, -1);
	?>

	<script type="text/javascript">
	musicas_nome = [<?=$nomes;?>];
	musicas_id = [<?=implode(',', $musicas_id);?>];

	function searchA() {
		word = $("#search-artist").val().toLowerCase();

		// find all strings in array containing 'thi'
		var matches = _.filter(musicas_nome,
			function(s) {
				return s.indexOf(word) !== -1;
			}
		);

		$(".box-m").css('display', 'none');
		for (var i = matches.length - 1; i >= 0; i--) {
			data = matches[i]; // Nome da música
			index = musicas_nome.indexOf(data);
			id_musica = musicas_id[index];

			$("#box-m-"+id_musica).css('display', 'inline-block');
		};

		$(".box-a").each(function() {
			id_attr = $(this).attr('id');
			idd = id_attr.split('-');
			id = idd[2];
			show = false;

			$("#box-a-"+id).find('.box-m').each(function() {
				if($(this).css('display') == 'inline-block') {
					show =  true;
				}
			});

			if(show) {
				$("#box-a-"+id).css('display', 'block');
			} else {
				$("#box-a-"+id).css('display', 'none');
			}
		});
	}
	</script>

<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Nome</label>
	  			<div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=$_POST['nome'];?>"></div><br>
	  		</div>

	  		<br><br>

	  		<div class="form-group">
	  			<div class="col-lg-12"><input type="text" id="search-artist" class="form-control input-sm" placeholder="Procurar música..." onkeyup="javascript:searchA();"></div><br>
	  		</div>

	  		<? $sql6 = mysql_query("SELECT * FROM ph_artistas ORDER BY nome ASC");
	  		while($sql7 = mysql_fetch_array($sql6)) { 
	  			echo '<div id="box-a-'.$sql7['id'].'" class="box-a">';
	  			echo '<h1 style="font-size:16px;">'.clear($sql7['nome']).'</h1>';

	  			$sql8 = mysql_query("SELECT * FROM ph_musicas WHERE id_artista='".$sql7['id']."'");
	  			while($sql9 = mysql_fetch_array($sql8)) { ?>

	  			<div id="box-m-<?=$sql9['id'];?>" class="box-m" style="margin:10px;display:inline-block;">
	  				<div style="font-weight:bold;display:inline-block;margin:5px;width:220px;"><?=clear($sql9['nome']);?></div>
	  				<input type="checkbox" <? if($_POST["m" . $sql9['id']] == 'on') { echo 'checked="checked"'; } ?> id="m-<?=$sql9['id'];?>" name="m-<?=$sql9['id'];?>" type="checkbox">
	  			</div>

	  		<? } echo '<hr></div>'; } ?>

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
		$musicas = array();
		$prosseguir = true;
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		$sql8 = mysql_query("SELECT id FROM ph_musicas");
		while($sql9 = mysql_fetch_array($sql8)) {
			$campo = $_POST['m-' . $sql9['id']];

			if($campo == 'on') {
				$musicas[] = $sql9['id'];
			}
		}

		$musicas = implode('|', $musicas);

		if($prosseguir == true) {
			$equipe = 'n';
			$status = 'aprovada';
			mysql_query("UPDATE ph_playlists SET nome='$nome', musicas='$musicas', equipe='$equipe', status='$status' WHERE id='$id' LIMIT 1");
			logger("O usuário editou a playlist #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM ph_playlists WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
	<? $musicas_nome = array();
	$musicas_id = array();
	$sql6 = mysql_query("SELECT * FROM ph_artistas ORDER BY nome ASC");
	while($sql7 = mysql_fetch_array($sql6)) { 
		$sql8 = mysql_query("SELECT * FROM ph_musicas WHERE id_artista='".$sql7['id']."'");
		while($sql9 = mysql_fetch_array($sql8)) {
			$musicas_nomes[] = clear(strtolower($sql9['nome']));
			$musicas_id[] = $sql9['id'];
		}
	}

	$nomes = '';
	foreach ($musicas_nomes as $atual) {
		$nomes .= '"'.$atual.'",';
	}

	$nomes = substr($nomes, 0, -1);
	?>

	<script type="text/javascript">
	musicas_nome = [<?=$nomes;?>];
	musicas_id = [<?=implode(',', $musicas_id);?>];

	function searchA() {
		word = $("#search-artist").val().toLowerCase();

		// find all strings in array containing 'thi'
		var matches = _.filter(musicas_nome,
			function(s) {
				return s.indexOf(word) !== -1;
			}
		);

		$(".box-m").css('display', 'none');
		for (var i = matches.length - 1; i >= 0; i--) {
			data = matches[i]; // Nome da música
			index = musicas_nome.indexOf(data);
			id_musica = musicas_id[index];

			$("#box-m-"+id_musica).css('display', 'inline-block');
		};

		$(".box-a").each(function() {
			id_attr = $(this).attr('id');
			idd = id_attr.split('-');
			id = idd[2];
			show = false;

			$("#box-a-"+id).find('.box-m').each(function() {
				if($(this).css('display') == 'inline-block') {
					show =  true;
				}
			});

			if(show) {
				$("#box-a-"+id).css('display', 'block');
			} else {
				$("#box-a-"+id).css('display', 'none');
			}
		});
	}
	</script>
	
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
	  		<?=$form_return;?>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Nome</label>
	  			<div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=$ex['nome'];?>"></div><br>
	  		</div>

	  		<br><br>

	  		<div class="form-group">
	  			<div class="col-lg-12"><input type="text" id="search-artist" class="form-control input-sm" placeholder="Procurar música..." onkeyup="javascript:searchA();"></div><br>
	  		</div>

	  		<? $musicas = explode('|', $ex['musicas']);
	  		$sql6 = mysql_query("SELECT * FROM ph_artistas ORDER BY nome ASC");
	  		while($sql7 = mysql_fetch_array($sql6)) { 
	  			echo '<div id="box-a-'.$sql7['id'].'" class="box-a">';
	  			echo '<h1 style="font-size:16px;">'.clear($sql7['nome']).'</h1>';

	  			$sql8 = mysql_query("SELECT * FROM ph_musicas WHERE id_artista='".$sql7['id']."'");
	  			while($sql9 = mysql_fetch_array($sql8)) { ?>

	  			<div id="box-m-<?=$sql9['id'];?>" class="box-m" style="margin:10px;display:inline-block;">
	  				<div style="font-weight:bold;display:inline-block;margin:5px;width:220px;"><?=clear($sql9['nome']);?></div>
	  				<input type="checkbox" <? if(in_array($sql9['id'], $musicas)) { echo 'checked="checked"'; } ?> id="m-<?=$sql9['id'];?>" name="m-<?=$sql9['id'];?>" type="checkbox">
	  			</div>

	  		<? } echo '<hr></div>'; } ?>
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
	mysql_query("DELETE FROM ph_playlists WHERE id='$id' LIMIT 1");
	logger("O usuário deletou a playlist [$id]", "acao");
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

				$query = "ph_playlists ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) { ?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
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