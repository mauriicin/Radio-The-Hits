<? if($_POST['form_processa'] == 's') {
	$imagem = $_FILES["imagem"];
	$prosseguir = true;

	$tipos = array('jpg', 'jpeg', 'png', 'gif', 'bmp'); //só permite imagens
	if($prosseguir == true) { $upload = uploadFile($imagem, '../media/', $tipos, $rand); }
	
	if($upload['erro'] == 1) {
		notificar("O arquivo que você está tentando enviar não é de uma imagem válida. (Arquivos permitidos: .jpg, .jpeg, .pnge .bmp)","red");
		$prosseguir = false;
	}
	
	if($upload['erro'] == 2) {
		notificar("Ocorreu um erro inesperado ao tentar enviar sua imagem. Contate a administração.","red");
		$prosseguir = false;
	}
	
	if($prosseguir == true) {
		$caminho_img = $upload['caminho'];
		notificar("Imagem enviada com sucesso!<br>Link: <a href='$caminho_img' target='_blank'><b>$caminho_img</b></a>", "blue");
	}
}
?>

<div class="panel panel-primary">
	<div class="panel-heading"><h3 class="panel-title">Mídia - Uploader</h3></div>
	<div class="panel-body">
		<form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
			<?=$form_return;?>

			<div class="form-group">
				<label class="col-lg-2 control-label">Imagem</label>
				<div class="col-lg-10"><input type="file" name="imagem" class="form-control"></div><br>
			</div>

			<div class="form-group form-submit">
				<label class="col-lg-2 control-label"></label>

				<input type="hidden" name="form_processa" value="s" />
				<div class="col-lg-10"><button type="submit" class="btn btn-success">Enviar</button></div>
			</div>
		</form>
	</div>
</div>

<div class="panel panel-primary">
	  <div class="panel-heading"><h3 class="panel-title">Mídia - Imagens</h3></div>
	  <div class="panel-body">
	  	<? $path = "../media/uploads/";
	  	$diretorio = dir($path);

	  	$i = 0;
	  	while($arquivo = $diretorio -> read()){
	  		if(strlen($arquivo) > 10) {
	  			$caminho = '/media/uploads/' . $arquivo;
	  			$files[$i]['caminho'] = $caminho;
	  			$files[$i]['arquivo'] = $arquivo;
	  			$i++;
	  		}
	  	}

	  	$diretorio -> close();
	  	while($i >= 0) {
	  		$caminho = $files[$i]['caminho'];
	  		$arquivo = $files[$i]['arquivo'];
	  		$i--;

	  		if($arquivo != '') { ?>
	  		<div class="col-sm-6 col-md-3">
	  			<a href="<?=$caminho;?>" class="thumbnail" target="_blank">
	  				<div style="background:url(<?=$caminho;?>) center center no-repeat;display:inline-block;margin-right:5px;margin-bottom:5px;width:199px;height:170px;"></div>
	  				<small><?=$arquivo;?></small>
	  			</a>
	  		</div>
	  		<? } ?>
	  	<? } ?>
	  </div>
</div>