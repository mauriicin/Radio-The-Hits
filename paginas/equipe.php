<div class="main-content">
	<div class="title-section">
		<h1>Equipe</h1>
		<div id="separator"></div>
	</div></a>

	<div id="boxs-team">
		<? $sql = $mysqli->query("SELECT * FROM cargos WHERE oculto='n' ORDER BY nome ASC");
		while($sql2 = $sql->fetch_assoc()) {
			$sql3 = $mysqli->query("SELECT * FROM acp_usuarios ORDER BY id DESC");
			while($sql4 = $sql3->fetch_assoc()) {
				if(hasCargoE(clear($sql2['nome']), clear($sql4['id']), $mysqli)) { ?>
				<div class="box-team">
					<div id="img" style="background-image:url(<?=clear_img($sql4['avatar']);?>);">
						<div id="caption">
							<center><div id="nome"><?=clear($sql4['nome']);?></div></center>
						</div>
					</div>

					<div id="infos">
						<? if($sql4['facebook'] != '' || $sql4['instagram'] != '' || $sql4['twitter'] != '') { ?>
						<div class="network">
							<? if($sql4['facebook'] != '') { ?><a href="<?=$sql4['facebook'];?>" target="_blank"><div class="box facebook"><i class="icon-facebook"></i></div></a><? } ?>
							<? if($sql4['instagram'] != '') { ?><a href="<?=$sql4['instagram'];?>" target="_blank"><div class="box instagram"><i class="icon-instagram"></i></div></a><? } ?>
							<? if($sql4['twitter'] != '') { ?><a href="<?=$sql4['twitter'];?>" target="_blank"><div class="box twitter"><i class="icon-twitter"></i></div></a><? } ?>
							<br>
						</div>
						<? } ?>

						<div class="cargo"><?=clear($sql2['nome']);?></div>
						<div class="description"><?=clear($sql4['descricao']);?></div>
					</div>
				</div>
				<? }
			}
		} ?>
	</div>

	<br>
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