<? 
if($_SERVER['REQUEST_METHOD'] == "POST")  {
	$nome = clear_mysql($_POST['nome']);
	$artista = clear_mysql($_POST['artista']);
	$musica = clear_mysql($_POST['musica']);
	$audio = clear_mysql($_POST['audio']);
	$video = clear_mysql($_POST['video']);
	$letra = clear_mysql($_POST['letra']);
	$prosseguir = true;

	if(empty($nome) || empty($artista) || empty($musica) || empty($audio) || empty($video)) {
		$form_return .= aviso_red("Preencha todos os campos.");
		$prosseguir = false;		
	}

	if(strpos($audio,'youtube') === false || strpos($video,'youtube') === false) {
		$form_return .= aviso_red("Digite links válidos dos vídeos no YouTube.");
		$prosseguir = false;
	}

	$art = getArtista($artista, $mysqli);
	$id_artista = $art['id'];

	$sql = $mysqli->query("SELECT * FROM ph_musicas WHERE nome='$musica' AND id_artista='$id_artista'");

	if($sql->num_rows > 0) {
		$form_return .= aviso_red("Esta música já consta em nosso acervo de mídia. Se você não consegue achá-la no site, talvez não tenha sido revisada pela equipe ainda.<br>Se vocẽ está tentando corrigir informações dessa música, utilize a página de contato, localizada no menu ao topo do nosso site.");
		$prosseguir = false;
	}

	if($art == false) {
		$form_return .= aviso_red("Este artista não consta em nosso acervo de mídia. É necessário que ele esteja previamente cadastrado pela nossa equipe para que você possa enviar músicas dele.");
		$prosseguir = false;
	}

	if($prosseguir == true) {
		$sql2 = $mysqli->query("INSERT INTO ph_musicas (id_artista, id_album, nome, audio, video, letra, autor, ip, data) VALUES ('$id_artista', '$id_album', '$musica', '$audio', '$video', '$letra', '$nome', '$ip', '$timestamp')");

		$form_return .= aviso_green("Enviado com sucesso! Agradecemos pela colaboração. Esta música estará disponível no site imediatamente após revisão da nossa equipe.");
		$concluido = true;
	}
} ?>
<div class="title-section">
	<h1 class="txt-truncate">Seja um <b>colaborador</b></h1>
	<div id="separator"></div>
</div>

<div class="box-content">
	<? echo $form_return;
	if(!$concluido) { ?>
	<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" class="form-send form-full">
		<div class="f-left" style="margin-right:20px;width:490px;">
			<div class="form-input half">
				<div class="icon"><i class="icon-user"></i></div>
				<input type="text" name="nome" placeholder="Qual o seu nome?" value="<?=$_POST['nome'];?>">
				<br>
			</div>

			<div class="form-input half">
				<div class="icon"><i class="icon-mic"></i></div>
				<input type="text" id="music-singer" name="artista" placeholder="Nome do artista" value="<?=$_POST['artista'];?>" class="autocomplete-artist tip-2" title="Caso seja mais de um artista, coloque o principal.">
				<br>
			</div>

			<div class="form-input half">
				<div class="icon"><i class="icon-music"></i></div>
				<input type="text" id="music-name" name="musica" placeholder="Nome da música" value="<?=$_POST['musica'];?>">
				<br>
			</div>

			<div class="form-input half">
				<div class="icon"><i class="icon-play"></i></div>
				<input type="text" name="audio" placeholder="Link do vídeo da música no YouTube" value="<?=$_POST['audio'];?>" class="tip-2" title="Este é o link do vídeo do audio da música, ou seja, um vídeo que contenha somente a música, sem adicionais. Como um lyric video.">
				<br>
			</div>

			<div class="form-input half">
				<div class="icon"><i class="icon-youtube-play"></i></div>
				<input type="text" name="video" placeholder="Link do vídeo oficial no YouTube" value="<?=$_POST['video'];?>" class="tip-2" title="Este é o link do vídeo oficial da música, não necessariamente somente o audio da música.">
				<br>
			</div>
		</div>

		<div class="f-left" style="width:490px;">
			<div class="form-input half textarea">
				<div class="icon"><i class="icon-pencil"></i></div>
				<textarea name="letra" id="music-lyrics" placeholder="Letra da música"><?=$_POST['letra'];?></textarea>
				<br>
			</div>

			<div class="alert alert-yellow" style="margin-bottom:10px;">Todo o conteúdo passará por revisão da equipe.</div>
			<div class="alert alert-blue" style="margin-bottom:10px;">Tentaremos obter a letra automaticamente, revise-a.</div>

			<button type="submit" class="btn-two f-right" style="height:50px;">Concluído</button>
		</div>

		<br>
	</form>
	<? } ?>
</div>

<input type="hidden" id="pag-number" value="5">