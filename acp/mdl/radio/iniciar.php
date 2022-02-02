<? if($permissoes[19] == 'n') { erro404(); die(); }
	
if($_GET['a'] == 1) {
	$scpass = $config['radio_senhakick'];
	$scfp = fsockopen($config['radio_ip'], $config['radio_porta'], $errno, $errstr, 30);

	if($scfp) {
		fputs($scfp,"GET /admin.cgi?pass=$scpass&mode=&mode=kicksrc HTTP/1.0\r\nUser-Agent: SHOUTcast Song Status (Mozilla Compatible)\r\n\r\n");

		while(!feof($scfp)) {
			$page .= fgets($scfp, 1000);
		}

		fclose($scfp);

		if($res){$sucesso = true; } else {$sucesso = false;}
	}
?>
<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
	  <div class="panel-body">
	  	O locutor atual foi expulso. Entre na rádio agora.<br><br>
	  	<center><a href="?p=$_GET['p']&a=1"><button type="button" class="btn btn-primary btn-lg">Expulsar novamente</button></a></center>
	  </div>
</div>
<? }

if($_GET['a'] == '') { ?>
<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?> - Informações</h3></div>
	<div class="panel-body">
		Para iniciar sua locução, você deve kickar/expulsar o locutor atual (ou o AutoDJ) clicando no botão abaixo. Lembre-se que o locutor atual (caso não seja o AutoDJ) deve estar ciente de que você iniciará sua programação.<br><br>
		<div class="alert alert-red">Se você kickar/expulsar o locutor atual sem avisá-lo, você poderá ser demitido.</div>
	</div>
</div>

<div class="panel panel-success">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?> - Configurações da rádio</h3></div>
	<div class="panel-body">
		<b>IP:</b> <?=$config['radio_ip'];?><br>
		<b>Porta:</b> <?=$config['radio_porta'];?><br>
		<b>Senha:</b> <?=$config['radio_senha'];?><br>
		<b>Tipo de transmissão:</b> <?=$config['radio_tipo'];?><br><br>

		Você deve colocar seu nome e o nome de sua programação.
	</div>
</div>

<div class="panel panel-danger">
	<div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?> - Iniciar</h3></div>
	<div class="panel-body">
		Clique no botão abaixo para expulsar o locutor atual e iniciar sua programação. Você terá cerca de 5 segundos para entrar na rádio antes que o AutoDJ entre.<br><br>
		<center><a href="?p=<?=$_GET['p'];?>&a=1"><button type="button" class="btn btn-danger btn-lg">Iniciar locução</button></a></center>
	</div>
</div>
<? } ?>