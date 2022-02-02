<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

include "config.php";
include "functions2.php";

$_config = $mysqli->query("SELECT * FROM config LIMIT 1");
$config = $_config->fetch_assoc();

$host = $config['radio_ip'];
$port = $config['radio_porta'];

$fp = fsockopen($host, $port, $errno, $errstr); 
if(!$fp)
{
	$success = 2;
}
if($success != 2)
{
	fputs($fp,"GET /index.html HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n"); //get 7.html
	while(!feof($fp))
	{
		$pg .= fgets($fp, 1000);
	}
	fclose($fp);
	
	// locutor
	$paage = ereg_replace(".*<font class=default>Stream Title: </font></td><td><font class=default><b>", "", $pg);
	$paage = ereg_replace("</b></td></tr><tr><td width=100 nowrap>.*", "", $paage);
	
	// programa
	$pge = ereg_replace(".*<font class=default>Stream Genre: </font></td><td><font class=default><b>", "", $pg);
	$pge = ereg_replace("</b></td></tr><tr><td width=100 nowrap>.*", "", $pge);
	
	/*
	$pe = ereg_replace(".*<font class=default>Stream Genre: </font></td><td><font class=default><b>", "", $pg);
	$pe = ereg_replace("</b></td></tr><tr><td width=100 nowrap>.*", "", $pe);
	*/
	
	// musica
	$musica = ereg_replace(".*<font class=default>Current Song: </font></td><td><font class=default><b>", "", $pg);
	$musica = ereg_replace("</b></td></tr></table>.*", "", $musica);
	$numbers = explode(",",$paage);
	$servertitle = $numbers[0];
	$connected = $numbers[1];
}

$fp2 = fsockopen("$host", $port, $errno, $errstr);
if(!$fp2)
{
	$success2 = 2;
}
if($success2 != 2)
{
	fputs($fp2,"GET /7.html HTTP/1.0\r\nUser-Agent: XML Getter (Mozilla Compatible)\r\n\r\n");
	while(!feof($fp2))
	{
		$pg2 .= fgets($fp2, 1000);
	}
	
	fclose($fp2);
	$pag = ereg_replace(".*<body>", "", $pg2);
	$pag = ereg_replace("</body>.*", ",", $pag); 
	$numbers = explode(",",$pag);
	
	// ouvintes
	$currentlisteners = $numbers[0];
}

$nome = ($paage);
$programa = ($pge);

$avatar = $config['radio_autodj'];

if($nome == 'Auto DJ') {
	$avatar = $config['radio_autodj'];
	$nome = $paage;
} else if($nome != '+ Playlist') {
	$sql4 = $mysqli->query("SELECT * FROM acp_usuarios WHERE nome='$paage' LIMIT 1");
	$sql5 = $sql4->fetch_assoc();

	$avatar = $sql5['avatar'];
	$nome = $sql5['nome'];
}

$retorno['locutor'] = $nome;
$retorno['programa'] = $programa;
$retorno['avatar'] = $avatar;

/*

if($programa == "ES01") {
	$cURL = curl_init('http://www.radiothehits.com/a_info/playing.html');
	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
	$resultado = curl_exec($cURL);
	curl_close($cURL);

	$current['singer'] = get_tag('class', 'current-singer', $resultado);
	$current['music'] = get_tag('class', 'current-music', $resultado);

	$previous['singer'] = get_tag('class', 'previous-singer', $resultado);
	$previous['music'] = get_tag('class', 'previous-music', $resultado);

	$coming['singer'] = get_tag('class', 'coming-singer', $resultado);
	$coming['music'] = get_tag('class', 'coming-music', $resultado);

	$tipos = array('current', 'previous', 'coming');

	foreach ($tipos as $atual) {
		if($atual == 'current') { $nome_musica = $current['music']; }
		if($atual == 'previous') { $nome_musica = $previous['music']; }
		if($atual == 'coming') { $nome_musica = $coming['music']; }

		$sql = $mysqli->query("SELECT * FROM ph_musicas WHERE nome='$nome_musica' LIMIT 1");
		$sql2 = $sql->fetch_assoc();

		$artista = getArtista($sql2['id_artista'], $mysqli);
		$album = getAlbum($sql2['id_album'], $mysqli);

		$id = $sql2['id'];
		$sql3 = $mysqli->query("SELECT id FROM ph_musicas_likes WHERE id_musica='$id' AND ip='$ip'");
		if($sql3->num_rows > 0) { $liked = true; } else { $liked = false; }

		if($atual == 'current') {
			$current['singer-link'] = '/playhits/artistas/'.$artista['id'].'/'.trataurl($artista['nome']);
			$current['music-link'] = '/playhits/musicas/'.$sql2['id'].'/'.trataurl($sql2['nome']);
			$current['album'] = $album['imagem'];
			$current['like_id'] = $sql2['id'];
			$current['liked'] = $liked;
		}

		if($atual == 'previous') {
			$previous['singer-link'] = '/playhits/artistas/'.$artista['id'].'/'.trataurl($artista['nome']);
			$previous['music-link'] = '/playhits/musicas/'.$sql2['id'].'/'.trataurl($sql2['nome']);
			$previous['album'] = $album['imagem'];
			$previous['like_id'] = $sql2['id'];
			$previous['liked'] = $liked;
		}

		if($atual == 'coming') {
			$coming['singer-link'] = '/playhits/artistas/'.$artista['id'].'/'.trataurl($artista['nome']);
			$coming['music-link'] = '/playhits/musicas/'.$sql2['id'].'/'.trataurl($sql2['nome']);
			$coming['album'] = $album['imagem'];
			$coming['like_id'] = $sql2['id'];
			$coming['liked'] = $liked;
		}
	}

	$retorno = array(
		"tipo" => "auto",
		"current" => $current,
		"previous" => $previous,
		"coming" => $coming
		);
} else {
	$sql4 = $mysqli->query("SELECT * FROM acp_usuarios WHERE nick='$locutor' LIMIT 1");
	$sql5 = $sql4->fetch_assoc();

	$avatar = $sql5['avatar'];
	$nome = $sql5['nome'] . ' ' . $sql5['apelido'];

	$retorno = array(
		"tipo" => "loc",
		"avatar" => $avatar,
		"nome" => $nome,
		"programa" => $programa
		);
}

*/

echo json_encode($retorno);