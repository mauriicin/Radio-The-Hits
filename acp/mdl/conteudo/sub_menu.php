<? if($permissoes[24] == 'n') { erro404(); die(); }

if($_GET['a'] == 1) {
	if($_POST['form_processa'] == 's') {
		$titulo = clear_mysql($_POST['titulo']);
		$icone = clear_mysql($_POST['icone']);
		$link = clear_mysql($_POST['link']);
		$menu_pai = anti_injecao($_POST['menu_pai']);
		$prosseguir = true;

		if($titulo == '') {
			notificar("Digite um título.","red");
			$prosseguir = false;
		}
		
		if($icone == '') {
			notificar("Escolha um ícone.","red");
			$prosseguir = false;
		}

		if($menu_pai == '') {
			notificar("Escolha um menu pai.","red");
			$prosseguir = false;
		}

		if($link == '') {
			notificar("Digite um link.","red");
			$prosseguir = false;
		}
		
		if($prosseguir == true) {
			mysql_query("INSERT INTO sub_menu (id_menu, nome, icone, link, autor, data) VALUES ('$menu_pai', '$titulo', '$icone', '$link', '$autor', '$timestamp')");
			logger("O usuário adicionou um novo sub-menu.", "acao");

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
					<label class="col-lg-2 control-label">Link</label>
					<div class="col-lg-10"><input type="text" name="link" class="form-control input-sm" value="<?=$_POST['link'];?>"><br><small>Use caminho local. Ex: /paginas/1/equipe</small></div><br>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Ícone</label>
					<div class="col-lg-9" style="padding-top:10px;">
						<select name="icone" data-placeholder="Escolha um ícone..." class="chosen-select" style="width:350px;" tabindex="2">
							<option value=""></option>
							<option <?=(($_POST['icone'] == 'search')) ? 'selected' : '';?> value="search">search</option>
							<option <?=(($_POST['icone'] == 'play')) ? 'selected' : '';?> value="play">play</option>
							<option <?=(($_POST['icone'] == 'pause')) ? 'selected' : '';?> value="pause">pause</option>
							<option <?=(($_POST['icone'] == 'heart')) ? 'selected' : '';?> value="heart">heart</option>
							<option <?=(($_POST['icone'] == 'clock')) ? 'selected' : '';?> value="clock">clock</option>
							<option <?=(($_POST['icone'] == 'headphones')) ? 'selected' : '';?> value="headphones">headphones</option>
							<option <?=(($_POST['icone'] == 'music')) ? 'selected' : '';?> value="music">music</option>
							<option <?=(($_POST['icone'] == 'stop')) ? 'selected' : '';?> value="stop">stop</option>
							<option <?=(($_POST['icone'] == 'shuffle')) ? 'selected' : '';?> value="shuffle">shuffle</option>
							<option <?=(($_POST['icone'] == 'fast-backward')) ? 'selected' : '';?> value="fast-backward">fast-backward</option>
							<option <?=(($_POST['icone'] == 'pencil')) ? 'selected' : '';?> value="pencil">pencil</option>
							<option <?=(($_POST['icone'] == 'loop')) ? 'selected' : '';?> value="loop">loop</option>
							<option <?=(($_POST['icone'] == 'mobile')) ? 'selected' : '';?> value="mobile">mobile</option>
							<option <?=(($_POST['icone'] == 'facebook')) ? 'selected' : '';?> value="facebook">facebook</option>
							<option <?=(($_POST['icone'] == 'twitter')) ? 'selected' : '';?> value="twitter">twitter</option>
							<option <?=(($_POST['icone'] == 'gplus')) ? 'selected' : '';?> value="gplus">gplus</option>
							<option <?=(($_POST['icone'] == 'right-open')) ? 'selected' : '';?> value="right-open">right-open</option>
							<option <?=(($_POST['icone'] == 'th-list')) ? 'selected' : '';?> value="th-list">th-list</option>
							<option <?=(($_POST['icone'] == 'fast-forward')) ? 'selected' : '';?> value="fast-forward">fast-forward</option>
							<option <?=(($_POST['icone'] == 'ok-circled')) ? 'selected' : '';?> value="ok-circled">ok-circled</option>
							<option <?=(($_POST['icone'] == 'up-open')) ? 'selected' : '';?> value="up-open">up-open</option>
							<option <?=(($_POST['icone'] == 'down-open')) ? 'selected' : '';?> value="down-open">down-open</option>
							<option <?=(($_POST['icone'] == 'cancel')) ? 'selected' : '';?> value="cancel">cancel</option>
							<option <?=(($_POST['icone'] == 'user')) ? 'selected' : '';?> value="user">user</option>
							<option <?=(($_POST['icone'] == 'mic')) ? 'selected' : '';?> value="mic">mic</option>
							<option <?=(($_POST['icone'] == 'youtube-play')) ? 'selected' : '';?> value="youtube-play">youtube-play</option>
							<option <?=(($_POST['icone'] == 'thumbs-up')) ? 'selected' : '';?> value="thumbs-up">thumbs-up</option>
							<option <?=(($_POST['icone'] == 'thumbs-down')) ? 'selected' : '';?> value="thumbs-down">thumbs-down</option>
							<option <?=(($_POST['icone'] == 'instagram')) ? 'selected' : '';?> value="instagram">instagram</option>
							<option <?=(($_POST['icone'] == 'users')) ? 'selected' : '';?> value="users">users</option>
							<option <?=(($_POST['icone'] == 'mail-alt')) ? 'selected' : '';?> value="mail-alt">mail-alt</option>
							<option <?=(($_POST['icone'] == 'comment')) ? 'selected' : '';?> value="comment">comment</option>
							<option <?=(($_POST['icone'] == 'link')) ? 'selected' : '';?> value="link">link</option>
						</select>
					</div><br>
				</div>

				<div class="form-group">
					<label class="col-lg-3 control-label">Menu pai</label>
					<div class="col-lg-9" style="padding-top:10px;">
						<select name="menu_pai" data-placeholder="Escolha um menu..." class="chosen-select" style="width:350px;" tabindex="2">
							<option value=""></option>
							<? $sql4 = mysql_query("SELECT * FROM menu ORDER BY titulo ASC");
							while($sql5 = mysql_fetch_array($sql4)) { ?>
							<option value="<?=$sql5['id'];?>" <?=(($_POST['menu_pai'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['titulo']);?></option>
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
		$id = anti_injecao($_GET['id']);

		if($_POST['form_processa'] == 's') {
			$titulo = clear_mysql($_POST['titulo']);
			$icone = clear_mysql($_POST['icone']);
			$link = clear_mysql($_POST['link']);
			$menu_pai = anti_injecao($_POST['menu_pai']);
			$prosseguir = true;

			if($titulo == '') {
				notificar("Digite um título.","red");
				$prosseguir = false;
			}

			if($icone == '') {
				notificar("Escolha um ícone.","red");
				$prosseguir = false;
			}

			if($menu_pai == '') {
				notificar("Escolha um menu pai.","red");
				$prosseguir = false;
			}

			if($link == '') {
				notificar("Digite um link.","red");
				$prosseguir = false;
			}

			if($prosseguir == true) {
				mysql_query("UPDATE sub_menu SET nome='$titulo', id_menu='$menu_pai', icone='$icone', link='$link' WHERE id='$id' LIMIT 1");
				logger("O usuário editou o sub-menu #$id", "acao");

				notificar("Sucesso!","blue");
				foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
			}
		}

		$sql3 = mysql_query("SELECT * FROM sub_menu WHERE id='$id' LIMIT 1");
		$ex = mysql_fetch_array($sql3); ?>
		<div class="panel panel-primary">
			<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
			<div class="panel-body">
				<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
					<?=$form_return;?>

					<div class="form-group">
						<label class="col-lg-2 control-label">Título</label>
						<div class="col-lg-10"><input type="text" name="titulo" class="form-control input-sm" value="<?=$ex['nome'];?>"></div><br>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Link</label>
						<div class="col-lg-10"><input type="text" name="link" class="form-control input-sm" value="<?=$ex['link'];?>"><br><small>Use caminho local. Ex: /paginas/1/equipe</small></div><br>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label">Ícone</label>
						<div class="col-lg-9" style="padding-top:10px;">
							<select name="icone" data-placeholder="Escolha um ícone..." class="chosen-select" style="width:350px;" tabindex="2">
								<option value=""></option>
								<option <?=(($ex['icone'] == 'search')) ? 'selected' : '';?> value="search">search</option>
								<option <?=(($ex['icone'] == 'play')) ? 'selected' : '';?> value="play">play</option>
								<option <?=(($ex['icone'] == 'pause')) ? 'selected' : '';?> value="pause">pause</option>
								<option <?=(($ex['icone'] == 'heart')) ? 'selected' : '';?> value="heart">heart</option>
								<option <?=(($ex['icone'] == 'clock')) ? 'selected' : '';?> value="clock">clock</option>
								<option <?=(($ex['icone'] == 'headphones')) ? 'selected' : '';?> value="headphones">headphones</option>
								<option <?=(($ex['icone'] == 'music')) ? 'selected' : '';?> value="music">music</option>
								<option <?=(($ex['icone'] == 'stop')) ? 'selected' : '';?> value="stop">stop</option>
								<option <?=(($ex['icone'] == 'shuffle')) ? 'selected' : '';?> value="shuffle">shuffle</option>
								<option <?=(($ex['icone'] == 'fast-backward')) ? 'selected' : '';?> value="fast-backward">fast-backward</option>
								<option <?=(($ex['icone'] == 'pencil')) ? 'selected' : '';?> value="pencil">pencil</option>
								<option <?=(($ex['icone'] == 'loop')) ? 'selected' : '';?> value="loop">loop</option>
								<option <?=(($ex['icone'] == 'mobile')) ? 'selected' : '';?> value="mobile">mobile</option>
								<option <?=(($ex['icone'] == 'facebook')) ? 'selected' : '';?> value="facebook">facebook</option>
								<option <?=(($ex['icone'] == 'twitter')) ? 'selected' : '';?> value="twitter">twitter</option>
								<option <?=(($ex['icone'] == 'gplus')) ? 'selected' : '';?> value="gplus">gplus</option>
								<option <?=(($ex['icone'] == 'right-open')) ? 'selected' : '';?> value="right-open">right-open</option>
								<option <?=(($ex['icone'] == 'th-list')) ? 'selected' : '';?> value="th-list">th-list</option>
								<option <?=(($ex['icone'] == 'fast-forward')) ? 'selected' : '';?> value="fast-forward">fast-forward</option>
								<option <?=(($ex['icone'] == 'ok-circled')) ? 'selected' : '';?> value="ok-circled">ok-circled</option>
								<option <?=(($ex['icone'] == 'up-open')) ? 'selected' : '';?> value="up-open">up-open</option>
								<option <?=(($ex['icone'] == 'down-open')) ? 'selected' : '';?> value="down-open">down-open</option>
								<option <?=(($ex['icone'] == 'cancel')) ? 'selected' : '';?> value="cancel">cancel</option>
								<option <?=(($ex['icone'] == 'user')) ? 'selected' : '';?> value="user">user</option>
								<option <?=(($ex['icone'] == 'mic')) ? 'selected' : '';?> value="mic">mic</option>
								<option <?=(($ex['icone'] == 'youtube-play')) ? 'selected' : '';?> value="youtube-play">youtube-play</option>
								<option <?=(($ex['icone'] == 'thumbs-up')) ? 'selected' : '';?> value="thumbs-up">thumbs-up</option>
								<option <?=(($ex['icone'] == 'thumbs-down')) ? 'selected' : '';?> value="thumbs-down">thumbs-down</option>
								<option <?=(($ex['icone'] == 'instagram')) ? 'selected' : '';?> value="instagram">instagram</option>
								<option <?=(($ex['icone'] == 'users')) ? 'selected' : '';?> value="users">users</option>
								<option <?=(($ex['icone'] == 'mail-alt')) ? 'selected' : '';?> value="mail-alt">mail-alt</option>
								<option <?=(($ex['icone'] == 'comment')) ? 'selected' : '';?> value="instagram">comment</option>
								<option <?=(($ex['icone'] == 'link')) ? 'selected' : '';?> value="instagram">link</option>
							</select>
						</div><br>
					</div>

					<div class="form-group">
						<label class="col-lg-3 control-label">Menu pai</label>
						<div class="col-lg-9" style="padding-top:10px;">
							<select name="menu_pai" data-placeholder="Escolha um menu..." class="chosen-select" style="width:350px;" tabindex="2">
								<option value=""></option>
								<? $sql4 = mysql_query("SELECT * FROM menu ORDER BY titulo ASC");
								while($sql5 = mysql_fetch_array($sql4)) { ?>
								<option value="<?=$sql5['id'];?>" <?=(($ex['id_menu'] == $sql5['id'])) ? 'selected="selected"' : '';?>><?=clear($sql5['titulo']);?></option>
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

		if($_GET['a'] == 3) {
			$id = anti_injecao($_GET['id']);
			mysql_query("DELETE FROM sub_menu WHERE id='$id' LIMIT 1");
			logger("O usuário deletou o sub-menu [$id]", "acao");
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
							<th>Menu pai</th>
							<th>Data</th>
							<th>Opções</th>
						</tr>
					</thead>
					<tbody>
						<? $limite = 10;
						$pagina = $_GET['pag'];
						((!$pagina)) ? $pagina = 1 : '';
						$inicio = ($pagina * $limite) - $limite;

						$query = "sub_menu ORDER BY id DESC";
						$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
						while($sql2 = mysql_fetch_array($sql)) {
							$sql4 = mysql_query("SELECT titulo FROM menu WHERE id='".$sql2['id_menu']."' LIMIT 1");
							$sql5 = mysql_fetch_array($sql4); ?>
							<tr>
								<td><?=$sql2['id'];?></td>
								<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
								<td><?=$sql5['titulo'];?></td>
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