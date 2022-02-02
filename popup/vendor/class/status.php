<?php
header('Content-type: text/html; charset=UTF-8');
class Status {
	private $stream;
	private $shout;
	private $sid;

	public function __construct($stream, $sid = '1', $shout = '1'){
		$this->stream = $stream;
		$this->shout = $shout;
		$this->sid = $sid;
	}

	public function shortener($string, $limit){
		return substr_replace($string, (strlen($string) > $limit ? '...' : ''), $limit);
	}

	public function init($tipo, $base = 'https://www.habbo.com.br/habbo-imaging/avatarimage?img_format=gif&user=%avatar&action=crr=3&direction=3&head_direction=3&gesture=sml&size=b'){
		$ch = curl_init("http://" . $this->stream . "/index.html");
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);

		if(strpos($data, 'Server is currently up and public.')){
			$status = 'on';
		} else {
			$status = 'off';
		}

		if( $status == 'on' ) {
			$locutor = explode("Stream Title: </font></td><td><font class=default><b>", $data);
			$locutor = explode("</b>", $locutor[1]);
			$locutor = $locutor[0];

			$programa = explode("Stream Genre: </font></td><td><font class=default><b>", $data);
			$programa = explode("</b>", $programa[1]);
			$programa = $programa[0];

			$musica = explode("Current Song: </font></td><td><font class=default><b>", $data);
			$musica = explode("</b>", $musica[1]);
			$musica = $musica[0];

			$ouvintes = explode("<b>Stream is up at ", $data);
			$ouvintes = explode("kbps with <B>", $ouvintes[1]);
			$ouvintes = explode(" of", $ouvintes[1]);
			$ouvintes = $ouvintes[0];

			$unicos = explode('listeners (', $data);
			$unicos = explode(' unique)', $unicos[1]);
			$unicos = $unicos[0];

			$url = explode("Stream URL: </font></td><td><font class=default><b>", $data);
			$url = explode("</b>", $url[1]);
			$url = preg_replace('/<a href="(.*)">(.*)<\/a>/', '$1', $url[0]);
			$url = str_ireplace(array('http://www.'), '', $url);

		} else {
			$locutor = 'Nenhum';
			$programa = 'Nenhum';
			$ouvintes = '?';
			$musica = 'Nenhuma';
			$unicos = '?';
			$url = '?';
		}

		if($tipo == 'avatar'){
			return str_ireplace('%avatar', $locutor, $base);
		} else if($tipo == 'locutor'){
			return $this->shortener($locutor, 30);
		} else if($tipo == 'programa'){
			return $this->shortener($programa, 30);
		} else if($tipo == 'ouvintes'){
			return $ouvintes;
		} else if($tipo == 'musica'){
			return $musica;
		} else if($tipo == 'unicos'){
			return $unicos;
		} else if($tipo == 'url'){
			return $url;
		}
	}
}