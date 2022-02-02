<? $id = anti_injecao($_GET['id']);

$sql = $mysqli->query("SELECT * FROM noticias WHERE id='$id' AND status='Ativo' LIMIT 1");
$sql2 = $sql->fetch_assoc();

(($sql->num_rows == 0)) ? erro404() : '';

$pag_info['title'] = 'Rádio TheHits - ' . clear($sql2['titulo']); ?>

<div class="title-section">
	<h1 class="txt-truncate"><?=clear($sql2['titulo']);?></h1>
	<div id="separator"></div>
</div>

<div class="main-content">
	<div class="news-img" style="background-image:url(<?=clear_img($sql2['imagem']);?>)">
		<div id="caption"><center>
			<? if($sql2['fc'] != '') { echo '<a href="'.$sql2['fc'].'" target="_blank"><div class="box">Fã-clube</div></a>'; } ?>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?=$dominio;?>/noticias/ler/<?=$id;?>/<?=trataurl($sql2['titulo']);?>/" target="_blank"><div class="box"><i class="icon-facebook"></i></div></a>
			<a href="https://twitter.com/share?url=<?=$dominio;?>/&via=radiothehits&text=<?=clear($sql2['titulo']) . ' - ';?>" target="_blank"><div class="box"><i class="icon-twitter"></i></div></a>
			<a href="https://plus.google.com/share?url=<?=$dominio;?>/noticias/ler/<?=$id;?>/<?=trataurl($sql2['titulo']);?>/" target="_blank"><div class="box"><i class="icon-gplus"></i></div></a>
		</center></div>
	</div>

	<div class="box-content">
		<article class="news">
			<?=$sql2['noticia'];?>
		</article>
	</div>

	<div class="title-main">Comentários</div>
	<? if($sql2['comentarios'] == 's') { ?>
	<div class="news-comment">
		<div class="fb-comments" data-href="<?=$dominio;?>noticias/ler/<?=$id;?>/" data-width="670" data-numposts="8" data-colorscheme="light"></div>
	</div>
	<? } else {
		echo aviso_yellow("Os comentários para essa notícia foram desativados.");
	} ?>
</div>

<div class="side-content">
	<div id="publicity-2">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 310POR250 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-5432839607510840"
     data-ad-slot="9169983417"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

	<? $artistas = explode('|', $sql2['artistas']);
	$artistas = array_filter($artistas);
	if(count($artistas) > 0) { ?>
	<div class="title-section margin">
		<h1 class="txt-truncate">Artistas <b>relacionados</b></h1>
		<div id="separator"></div>
	</div>
	<? } ?>

	<?
	foreach ($artistas as $atual) {
		$sql5 = $mysqli->query("SELECT * FROM ph_artistas WHERE nome='$atual' LIMIT 1");
		$sql6 = $sql5->fetch_assoc();

		if($sql5->num_rows > 0) { ?>
		<a href="/playhits/artistas/<?=$sql6['id'];?>/<?=trataurl($sql6['nome']);?>">
			<div class="box-news-artists">
				<div id="img" style="background-image:url(<?=clear_img($sql6['imagem']);?>);"></div>
				<div id="infos" class="txt-truncate"><?=clear($sql6['nome']);?> - Ouvir</div>
			</div>
		</a>
		<? }
	} ?>

	<div class="title-section margin">
		<h1 class="txt-truncate">Notícias <b>relacionadas</b></h1>
		<div id="separator"></div>
	</div>

	<? $title = clear_mysql($sql2['titulo']);
	$sql3 = $mysqli->query("SELECT *, MATCH(titulo, noticia) AGAINST('$title') AS score FROM noticias WHERE MATCH(titulo, noticia) AGAINST('$title') AND status='Ativo' ORDER BY score DESC LIMIT 5");
	while($sql4 = $sql3->fetch_assoc()) { ?>
	<div class="box-news-related">
		<a href="/noticias/ler/<?=$sql4['id'];?>/<?=trataurl($sql4['titulo']);?>"><div id="img" style="background-image:url(<?=clear_img($sql4['imagem']);?>);"></div></a>
		<div id="infos">
			<a href="/noticias/ler/<?=$sql4['id'];?>/<?=trataurl($sql4['titulo']);?>"><div class="title txt-truncate tip" title="<?=clear($sql4['titulo']);?>"><?=clear($sql4['titulo']);?></div></a>
			<div class="desc txt-truncate"><?=clear($sql4['descricao']);?></div>
		</div>
	</div>
	<? } ?>

	<?=$network_side_face;?>
</div>

<br>