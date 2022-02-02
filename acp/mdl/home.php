<? $sql = mysql_query("SELECT id FROM noticias WHERE status='Ativo'");
$sql2 = mysql_query("SELECT id FROM ph_artistas");
$sql3 = mysql_query("SELECT id FROM ph_albuns");
$sql4 = mysql_query("SELECT id FROM ph_musicas WHERE status='aprovada'"); ?>
<h1>Estatísticas</h1>

<center>
	<div class="chart" data-percent="66" data-bar-color="#FFCC00">
		<div class="center"><center>
			<b><?=mysql_num_rows($sql);?></b><br><span>notícias</span>
		</center></div>
	</div>

	<div class="chart" data-percent="64" data-bar-color="#039DDA">
		<div class="center"><center>
			<b><?=mysql_num_rows($sql2);?></b><br><span>artistas</span>
		</center></div>
	</div>

	<div class="chart" data-percent="80" data-bar-color="#00CC66">
		<div class="center"><center>
			<b><?=mysql_num_rows($sql3);?></b><br><span>álbuns</span>
		</center></div>
	</div>

	<div class="chart" data-percent="69" data-bar-color="#CC33FF">
		<div class="center"><center>
			<b><?=mysql_num_rows($sql4);?></b><br><span>músicas</span>
		</center></div>
	</div>
</center>

<hr>

<div class="panel panel-info-dark widgets">
	<div class="panel-heading">
		<h3 class="panel-title">Facebook</h3>
	</div>
	<div class="panel-body" style="height:292px;">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fradiothehitsfm&amp;width=310&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:258px;" allowTransparency="true"></iframe>
	</div>
</div>

<div class="panel panel-info widgets">
	<div class="panel-heading">
		<h3 class="panel-title">Twitter</h3>
	</div>
	<div class="panel-body" style="height:292px;">
		<a class="twitter-timeline" href="https://twitter.com/radiothehits" data-widget-id="486265870562238464">Tweets de @radiothehits</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
</div>

<br>

<hr>

<? $nao_lido = 0;
$avisos = '';
$sql = mysql_query("SELECT * FROM acp_avisos ORDER BY id DESC");
while($sql2 = mysql_fetch_array($sql)) {
	$lidos = explode('|', $sql2['lido']);
	if(!in_array($dados['id'], $lidos)) { $nao_lido++; }

	$avisos .= '<div class="box-content">
	<div class="avatar-img" style="background-image:url('.getAvatar($sql2['autor'], $mysqli).');"></div>
	<div class="f-left">Aviso por <b>'.getNome($sql2['autor'], $mysqli).'</b><br class="normal">Em <b>'.date('d/m/Y H:i', $sql2['data']).'</b></div>';

	if(!in_array($dados['id'], $lidos)) {
		$avisos .= '<button id="btn-read-'.$sql2['id'].'" class="btn btn-success f-right" onclick="panel.read_w('.$sql2['id'].');">Marcar como lido</button>';
	} else {
		$avisos .= '<button class="btn btn-default f-right">Você já leu este aviso</button>';
	}

	$avisos .= '
	<br>
	<div class="box-well m-top">'.$sql2['conteudo'].'</div>
	</div>';
} ?>

<h1 class="m-btm">Avisos (<b><?=$nao_lido;?></b> não lidos)</h1>
<?=$avisos;?>