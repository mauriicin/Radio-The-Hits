<? $seq = array(1, 2, 3, 4, 4, 3);
$i = 0;
$sql = $mysqli->query("SELECT * FROM noticias WHERE status='Ativo' AND fixo='s' ORDER BY id DESC");
while($sql2 = $sql->fetch_assoc()) {
	$sql3 = $mysqli->query("SELECT * FROM noticias_cat WHERE id='".$sql2['cat_id']."' LIMIT 1");
	$sql4 = $sql3->fetch_assoc(); ?>
	<a href="/noticias/ler/<?=$sql2['id'];?>/<?=trataurl($sql2['titulo']);?>"><div class="box-news sz-<?=$seq[$i];?>" style="background-image: url(<?=clear_img($sql2['imagem']);?>);">
		<div id="infos">
			<div class="cat" style="background:<?=$sql4['cor'];?>"><?=clear($sql4['nome']);?></div><br>
			<div class="info">
				<div class="title tip txt-truncate" title="<?=clear($sql2['titulo']);?>"><?=clear($sql2['titulo']);?></div><br>
				<div class="desc txt-truncate"><?=clear($sql2['descricao']);?></div>
			</div>
		</div>
	</div></a>
<? $i++; }


$limit = 6 - $sql->num_rows;
$sql5 = $mysqli->query("SELECT * FROM noticias WHERE status='Ativo' AND fixo='n' ORDER BY id DESC LIMIT $limit");
while($sql6 = $sql5->fetch_assoc()) {
	$sql7 = $mysqli->query("SELECT * FROM noticias_cat WHERE id='".$sql6['cat_id']."' LIMIT 1");
	$sql8 = $sql7->fetch_assoc(); ?>
	<a href="/noticias/ler/<?=$sql6['id'];?>/<?=trataurl($sql6['titulo']);?>"><div class="box-news sz-<?=$seq[$i];?>" style="background-image: url(<?=clear_img($sql6['imagem']);?>);">
		<div id="infos">
			<div class="cat" style="background:<?=$sql8['cor'];?>"><?=clear($sql8['nome']);?></div><br>
			<div class="info">
				<div class="title tip txt-truncate" title="<?=clear($sql6['titulo']);?>"><?=clear($sql6['titulo']);?></div>
				<div class="desc txt-truncate"><?=clear($sql6['descricao']);?></div>
			</div>
		</div>
	</div></a>
<? $i++; } ?>