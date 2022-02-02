<div class="main-content">
	<div class="title-section">
		<h1 class="txt-truncate">Programação do <b>Mês</b></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content">
		<? $rows = 0;
		$sql = $mysqli->query("SELECT * FROM radio_prog WHERE horario_inicio ORDER BY horario_inicio DESC");
		while($sql2 = $sql->fetch_assoc()) {
			if(date('m', time()) == date('m', $sql2['horario_inicio'])) {
				$sql3 = $mysqli->query("SELECT nome, apelido FROM acp_usuarios WHERE id='".$sql2['id_user']."' LIMIT 1");
				$sql4 = $sql3->fetch_assoc();
				$rows++; ?>
				<b><?=clear($sql2['nome']);?></b> - Por <b><?=clear($sql4['nome']);?></b><br>
				Início: <b><?=date('d/m/Y H:i', $sql2['horario_inicio']);?></b><br>
				Término: <b><?=date('d/m/Y H:i', $sql2['horario_termino']);?></b>

				<hr class="one">
			<? 
			}
		} ?>
	</div>
</div>

<div class="side-content">
	<? include "playhits/most_played.php"; ?>

	<div class="title-section margin">
		<h1>Publicidade</h1>
		<div id="separator"></div>
	</div></a>
	
	<div id="publicity"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 310POR250 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-5432839607510840"
     data-ad-slot="9169983417"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script></div>

	<?=$network_side;?>
</div>

<br>