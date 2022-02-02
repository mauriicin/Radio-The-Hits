<? if($permissoes[4] == 'n') { erro404(); die(); }

if($_GET['a'] == 2) {
	$id = anti_injecao($_GET['id']);
		
	$sql3 = mysql_query("SELECT * FROM acp_logs WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
	  <div class="panel-heading">
			<h3 class="panel-title"><?=$mdl['title'];?></h3>
	  </div>
	  <div class="panel-body">
	  	<div class="well">
			Usuário que executou a ação: <b><?=$ex['autor'];?></b><br>
			Ação: <b><?=$ex['ato'];?></b><br>
			IP: <b><?=$ex['ip'];?></b><br>
			Data em que a ação foi realizada: <b><?=date('d/m/y H:i;s', $ex['data']);?></b><br>
			User Agent: <b><?=$ex['u_agent'];?></b><br>
		</div>
	  </div>
</div>
<? }
if($_GET['a'] == '') { ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">
		
			<a href="?p=<?=$_GET['p'];?>" class="btn btn-success">Todos</a>
			<a href="?p=<?=$_GET['p'];?>&e=2" class="btn btn-primary">Ação</a>
			<a href="?p=<?=$_GET['p'];?>&e=1" class="btn btn-danger">Acesso</a>
			<br><br>

			<script type="text/javascript">
			function procurarNick() {
				id = $("#id-nick").val();
				$(".form-procurarnick").animate({'opacity': 0.5});

				$.ajax({
					url: 'lib/procurar_nick.php?id='+id,
					type: 'get',
					success: function (html) {
						$(".form-procurarnick-add").html(html);
						$(".form-procurarnick").animate({'opacity': 1});
					}
				});
			}
			</script>

			<form action="javascript:procurarNick();" class="form-horizontal form-procurarnick">
				<fieldset>
					<legend>Encontrar nick de usuário usando o ID</legend>
					<div class="form-group">
						<div class="col-lg-1">
							<input type="text" class="form-control" id="id-nick" placeholder="ID">
						</div>

						<div class="col-lg-1">
							<button type="submit" class="btn btn-primary">Pesquisar</button>
						</div>
					</div>

					<div class="form-procurarnick-add"></div>
				</fieldset>
			</form>
		
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Ato</th>
						<th>Usuário</th>
						<th>Data</th>
						<th>IP</th>
					</tr>
				</thead>
				<tbody>
					<? $limite = 20;
					$pagina = $_GET['pag'];
					((!$pagina)) ? $pagina = 1 : '';
					$inicio = ($pagina * $limite) - $limite;

					$query = "acp_logs ORDER BY id DESC";

					if($_GET['e'] == 1) {
						$query = "acp_logs WHERE tipo='acesso' ORDER BY id DESC";
					}
					if($_GET['e'] == 2) {
						$query = "acp_logs WHERE tipo='acao' ORDER BY id DESC";
					}

					if($_GET['u'] != '') {
						$sql4 = mysql_query("SELECT * FROM acp_usuarios WHERE id='".anti_injecao($_GET['u'])."' LIMIT 1");
						$sql5 = mysql_fetch_array($sql4);
						$u = $sql5['nick'];

						$query = "acp_logs WHERE tipo='acao' AND autor='$u' ORDER BY id DESC";
					}

					$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
					while($sql2 = mysql_fetch_array($sql)) { ?>
					<tr>
						<td><?=$sql2['id'];?></td>
						<td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>" class="tt" title="<?=$sql2['ato'];?>"><?=clear(encurtar($sql2['ato'], 60));?></a></td>
						<td><?=$sql2['autor'];?></td>
						<td><?=date('d/m/y H:i', $sql2['data']);?></td>
						<td><?=$sql2['ip'];?></td>
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