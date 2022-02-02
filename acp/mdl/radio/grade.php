<? if($permissoes[21] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$nome = clear_mysql($_POST['nome']);
		$inicio = clear_mysql($_POST['inicio']);
		$termino = clear_mysql($_POST['termino']);
		$prosseguir = true;
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		if($inicio == '') {
			notificar("Digite um horário de início.","red");
			$prosseguir = false;
		}

		$a = $inicio;
		$hora = substr($a, 11);
		$minuto = substr($a, 14);
		$b = explode('/', $a);
		$dia = $b[0];
		$mes = $b[1];
		$ano = substr($b[2], 0, 4);
		
		$inicio = mktime($hora,$minuto,00,$mes,$dia,$ano);

		$a = $termino;
		$hora = substr($a, 11);
		$minuto = substr($a, 14);
		$b = explode('/', $a);
		$dia = $b[0];
		$mes = $b[1];
		$ano = substr($b[2], 0, 4);
		
		$termino = mktime($hora,$minuto,00,$mes,$dia,$ano);
		
		if($prosseguir == true) {
			$id_user = $dados['id'];
			mysql_query("INSERT INTO radio_prog (id_user, nome, horario_inicio, horario_termino, autor, data) VALUES ('$id_user', '$nome', '$inicio', '$termino', '$autor', '$timestamp')");
			logger("O usuário adicionou uma nova programação na rádio.", "acao");

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
	  			<label class="col-lg-2 control-label">Horário de início</label>
	  			<div class="col-lg-10"><input type="text" name="inicio" class="form-control input-sm" value="<?=$_POST['inicio'];?>"><br><small>Use o modelo DD/MM/AAAA HH:MM - Ex: 16/12/2014 15:30</small></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Horário de término</label>
	  			<div class="col-lg-10"><input type="text" name="termino" class="form-control input-sm" value="<?=$_POST['termino'];?>"><br><small>Use o modelo DD/MM/AAAA HH:MM - Ex: 16/12/2014 15:30</small></div><br>
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
		$inicio = clear_mysql($_POST['inicio']);
		$termino = clear_mysql($_POST['termino']);
		$prosseguir = true;
	
		if($nome == '') {
			notificar("Digite um nome.","red");
			$prosseguir = false;
		}
		
		if($inicio == '') {
			notificar("Digite um horário de início.","red");
			$prosseguir = false;
		}

		$a = $inicio;
		$hora = substr($a, 11);
		$minuto = substr($a, 14);
		$b = explode('/', $a);
		$dia = $b[0];
		$mes = $b[1];
		$ano = substr($b[2], 0, 4);
		
		$inicio = mktime($hora,$minuto,00,$mes,$dia,$ano);

		$a = $termino;
		$hora = substr($a, 11);
		$minuto = substr($a, 14);
		$b = explode('/', $a);
		$dia = $b[0];
		$mes = $b[1];
		$ano = substr($b[2], 0, 4);
		
		$termino = mktime($hora,$minuto,00,$mes,$dia,$ano);
		
		if($prosseguir == true) {
			$id_user = $dados['id'];
			mysql_query("UPDATE radio_prog SET nome='$nome', horario_inicio='$inicio', horario_termino='$termino' WHERE id='$id' LIMIT 1");
			logger("O usuário editou a programação da rádio #$id", "acao");

			notificar("Sucesso!","blue");
			foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
		}
	}
	
	$sql3 = mysql_query("SELECT * FROM radio_prog WHERE id='$id' LIMIT 1");
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
	  			<label class="col-lg-2 control-label">Horário de início</label>
	  			<div class="col-lg-10"><input type="text" name="inicio" class="form-control input-sm" value="<?=date('d/m/Y H:i', $ex['horario_inicio']);?>"><br><small>Use o modelo DD/MM/AAAA HH:MM - Ex: 16/12/2014 15:30</small></div><br>
	  		</div>

	  		<div class="form-group">
	  			<label class="col-lg-2 control-label">Horário de término</label>
	  			<div class="col-lg-10"><input type="text" name="termino" class="form-control input-sm" value="<?=date('d/m/Y H:i', $ex['horario_termino']);?>"><br><small>Use o modelo DD/MM/AAAA HH:MM - Ex: 16/12/2014 15:30</small></div><br>
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
	mysql_query("DELETE FROM radio_prog WHERE id='$id' LIMIT 1");
	logger("O usuário deletou a programação da rádio [$id]", "acao");
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
					<th>Horário de início</th>
					<th>Horário de término</th>
					<th>Locutor</th>
					<th>Opções</th>
				</tr>
			</thead>
			<tbody>
				<? $limite = 10;
				$pagina = $_GET['pag'];
				((!$pagina)) ? $pagina = 1 : '';
				$inicio = ($pagina * $limite) - $limite;

				$query = "radio_prog WHERE horario_inicio > $timestamp ORDER BY id DESC";
				$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
				while($sql2 = mysql_fetch_array($sql)) {
					$sql4 = mysql_query("SELECT nick FROM acp_usuarios WHERE id='".$sql2['id_user']."' LIMIT 1");
					$sql5 = mysql_fetch_array($sql4); ?>
				<tr>
					<td><?=$sql2['id'];?></td>
					<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
					<td><?=date('d/m/y H:i', $sql2['horario_inicio']);?></td>
					<td><?=date('d/m/y H:i', $sql2['horario_termino']);?></td>
					<td><?=$sql5['nick'];?></td>
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