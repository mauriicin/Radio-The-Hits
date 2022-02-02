<? if($permissoes[7] == 'n') { erro404(); die(); } ?>

<? $sql = mysql_query("SELECT * FROM equipe_pedidos ORDER BY id DESC");
$sql2 = mysql_query("SELECT * FROM equipe_pedidos WHERE lida='n' ORDER BY id DESC"); ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	<div class="panel-body">
		Existe um total de <b><?=mysql_num_rows($sql);?></b> pedidos para entrada na equipe, <b><?=mysql_num_rows($sql2);?></b> não lidos.
	</div>
</div>

<? while($sql3 = mysql_fetch_array($sql)) {
	mysql_query("UPDATE equipe_pedidos SET lida='s' WHERE id='".$sql3['id']."'"); ?>
<div class="panel panel-<?=(($sql3['lida'] == 'n')) ? 'danger' : 'success';?>">
	  <div class="panel-heading">
			<h3 class="panel-title">Pedido feito por <?=$sql3['nick'];?> - Lida: <?=(($sql3['lida'] == 'n')) ? 'NÃO' : 'SIM';?></h3>
	  </div>
	  <div class="panel-body">
			<b>Nick:</b> <?=clear($sql3['nick']);?> - <b>E-mail:</b> <?=clear($sql3['email']);?> - <b>Twitter:</b> <?=clear($sql3['twitter']);?><br><br>
			<b>Cargo desejado:</b> <?=clear($sql3['cargo']);?><br>
			<b>Observação:</b> <?=clear($sql3['observacao']);?>
	  </div>
</div>
<? } ?>