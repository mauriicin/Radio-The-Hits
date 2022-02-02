<? $id = anti_injecao($_GET['id']);

$sql = $mysqli->query("SELECT * FROM paginas WHERE id='$id' LIMIT 1");
$sql2 = $sql->fetch_assoc();

$autt = $_SESSION['login'];
$sql3 = $mysqli->query("SELECT id FROM acp_usuarios WHERE nick='$autt'");

if($sql2['restrito'] == 's' && $sql3->num_rows == 0) { $er = true; erro404(); }
if($sql2['restrito'] == 's' && !isset($_SESSION['login'])) { $er = true; erro404(); }

(($sql->num_rows == 0)) ? erro404() : '';

$pag_info['title'] = 'Rádio TheHits - ' . $sql2['titulo']; ?>
<div class="main-content">
	<div class="title-section">
		<h1 class="txt-truncate"><?=clear($sql2['titulo']);?></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content">
		<article class="news">
			<?=$sql2['conteudo'];?>
		</article>
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