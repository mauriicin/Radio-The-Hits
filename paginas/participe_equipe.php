<? if($_POST['form_processa'] == 's') {
	$nome = clear_mysql($_POST['nome']);
	$email = clear_mysql($_POST['email']);
	$twitter = clear_mysql($_POST['twitter']);
	$cargo = clear_mysql($_POST['cargo']);
	$msg = clear_mysql($_POST['observacao']);
	$prosseguir = true;

	if($nome == '') {
		$form_return .= aviso_red('Digite seu nome.');
		$prosseguir = false;
	}

	if($email == '') {
		$form_return .= aviso_red('Digite seu e-mail.');
		$prosseguir = false;
	}

	$sql5 = $mysqli->query("SELECT * FROM equipe_pedidos WHERE nick='$autor' ORDER BY id DESC LIMIT 1");
	$sql6 = $sql5->fetch_assoc();

	if($sql6['data'] > time() - 60) {
		$form_return .= aviso_red('Aguarde 1 minuto para enviar outro pedido.');
		$prosseguir = false;
	}

	if($prosseguir == true) {
		$sql7 = $mysqli->query("INSERT INTO equipe_pedidos (nome, email, twitter, cargo, observacao, data, ip) VALUES ('$nome', '$email', '$twitter', '$cargo', '$msg', '$timestamp', '$ip')");
		
		$form_return .= aviso_green("Enviado com sucesso! Revisaremos seu pedido o mais breve possível e entraremos em contato com você através de seu e-mail e/ou twitter. Fique atento!");
		$concluido = true;
	} 
}
?>
<div class="main-content">
	<div class="title-section">
		<h1 class="txt-truncate">Participe da <b>equipe</b></h1>
		<div id="separator"></div>
	</div>

	<div class="box-content">
		<div class="alert alert-yellow">
			Ficamos felizes que queira participar da nossa equipe, mas lembre-se: isto é um trabalho voluntário. Você não receberá nenhum salário.
		</div>

		<? echo $form_return;
		if(!$concluido) { ?>
		<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" class="form-send">
			<div class="form-input full">
				<div class="icon"><i class="icon-user"></i></div>
				<input type="text" name="nome" placeholder="Qual o seu nome?" value="<?=$_POST['nome'];?>">
				<br>
			</div>

			<div class="form-input full">
				<div class="icon"><i class="icon-mail-alt"></i></div>
				<input type="text" name="email" placeholder="Qual o seu e-mail?" value="<?=$_POST['email'];?>">
				<br>
			</div>

			<div class="form-input full">
				<div class="icon"><i class="icon-twitter"></i></div>
				<input type="text" name="twitter" placeholder="Qual o seu twitter? Deixe em branco se não tiver" value="<?=$_POST['twitter'];?>">
				<br>
			</div>

			<div class="form-input full">
				<div class="icon"><i class="icon-link"></i></div>
				<input type="text" name="cargo" placeholder="Qual o cargo desejado?" value="<?=$_POST['cargo'];?>">
				<br>
			</div>

			<div class="form-input full textarea">
				<div class="icon"><i class="icon-comment"></i></div>
				<textarea name="observacao" placeholder="Porque deseja entrar na equipe?"><?=$_POST['observacao'];?></textarea><br>
				<small>Fale-nos sobre sua experiência.</small>
				<br>
			</div>

			<br><br>

			<input type="hidden" name="form_processa" value="s">
			<button type="submit" class="btn-two">Concluído</button>

			<br>
		</form>
		<? } ?>
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