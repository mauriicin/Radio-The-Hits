<? if($permissoes[20] == 'n') { erro404(); die(); }

if($_GET['a'] == '') { ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">


		<? $limite = 20;
		$pagina = $_GET['pag'];
		((!$pagina)) ? $pagina = 1 : '';
		$inicio = ($pagina * $limite) - $limite;

		$query = "radio_pedidos ORDER BY id DESC";

		$sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
		while($sql2 = mysql_fetch_array($sql)) { ?>
		<div class="well">
		Pedido feito há <b><?=strtolower(distanceOfTimeInWords($sql2['data'], time(), true));?></b><br><br>
		Nome: <b><?=clear($sql2['nome']);?></b><br>
		Nome do artista: <b><?=clear($sql2['cantor']);?></b><br>
		Nome da música: <b><?=clear($sql2['musica']);?></b><br>
		</div>
		<? } ?>
		<? if(mysql_num_rows($sql) == 0) {
			echo aviso_red("Nenhum registro.");
		} ?>


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