<?php 

/**
 * Rádio TheHits - Todos os direitos reservados.
 * É proibido a cópia de qualquer código presente neste projeto.
 *
 * by @_theFX
 */

if(!$fc2_included) {
    include "functions_config.php";
    $fc2_included = true;
}

// Funções
function anti_injecao($palavra) {
	$palavra = trim($palavra);
	$palavra = strip_tags($palavra);
	$palavra = addslashes($palavra);
	$palavra = htmlspecialchars($palavra);
	return $palavra;
}

function clear($palavra) {
	$palavra = htmlspecialchars_decode($palavra);
	$palavra = strip_tags($palavra);
	$palavra = stripslashes($palavra);
    $palavra = implode("",explode("\\",$palavra));
    $palavra = stripslashes(trim($palavra));
	return $palavra;

	// Usar para exibir strings (retorno do banco de dados)
}

function clear_mysql($palavra) {
	$palavra = htmlspecialchars($palavra);
	$palavra = strip_tags($palavra);
	$palavra = addslashes($palavra);
	return $palavra;

	// Usar para enviar strings ao banco de dados (ida ao banco de dados)
}

function clear_img($palavra) {
    $palavra = htmlspecialchars_decode($palavra);
    $palavra = strip_tags($palavra);
    $palavra = addslashes($palavra);
    return $palavra;
}

function encurtar($conteudo, $max) {
    $conteudo = strlen($conteudo) > $max ? substr($conteudo,0,$max) . "..." : $conteudo;
    return $conteudo;
}

setlocale(LC_ALL, 'en_US.UTF8');
function trataurl($str, $replace=array(), $delimiter='-') {
	if(!empty($replace)) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}

function red_alert($conteudo) {return '<div class="alert alert-red">'.$conteudo.'</div>';}
function blue_alert($conteudo) {return '<div class="alert alert-blue">'.$conteudo.'</div>';}
function green_alert($conteudo) {return '<div class="alert alert-green">'.$conteudo.'</div>';}
function yellow_alert($conteudo) {return '<div class="alert alert-yellow">'.$conteudo.'</div>';}

function aviso_red($conteudo) {return '<div class="alert alert-red">'.$conteudo.'</div>';}
function aviso_blue($conteudo) {return '<div class="alert alert-blue">'.$conteudo.'</div>';}
function aviso_green($conteudo) {return '<div class="alert alert-green">'.$conteudo.'</div>';}
function aviso_yellow($conteudo) {return '<div class="alert alert-yellow">'.$conteudo.'</div>';}

function distanceOfTimeInWords($fromTime, $toTime = 0, $showLessThanAMinute = false) {
    $distanceInSeconds = round(abs($toTime - $fromTime));
    $distanceInMinutes = round($distanceInSeconds / 60);
    
    if ( $distanceInMinutes <= 1 ) {
        if ( !$showLessThanAMinute ) {
            return ($distanceInMinutes == 0) ? 'menos de 1m' : '1 min';
        } else {
            if ( $distanceInSeconds < 5 ) {
                return ($distanceInSeconds + 1).'s';
            }
            if ( $distanceInSeconds < 10 ) {
                return 'Menos de 10s';
            }
            if ( $distanceInSeconds < 20 ) {
                return 'Menos de 20s';
            }
            if ( $distanceInSeconds < 40 ) {
                return 'Meio min';
            }
            if ( $distanceInSeconds < 60 ) {
                return 'Menos de um min';
            }
            
            return '1 min';
        }
    }
    if ( $distanceInMinutes < 45 ) {
        return $distanceInMinutes . ' mins';
    }
    if ( $distanceInMinutes < 90 ) {
        return '1 hora';
    }
    if ( $distanceInMinutes < 1440 ) {
        return '' . round(floatval($distanceInMinutes) / 60.0) . ' horas';
    }
    if ( $distanceInMinutes < 2880 ) {
        return '1 dia';
    }
    if ( $distanceInMinutes < 43200 ) {
        return '' . round(floatval($distanceInMinutes) / 1440) . ' dias';
    }
    if ( $distanceInMinutes < 86400 ) {
        return '1 mês';
    }
    if ( $distanceInMinutes < 525600 ) {
        return round(floatval($distanceInMinutes) / 43200) . ' meses';
    }
    if ( $distanceInMinutes < 1051199 ) {
        return '1 ano';
    }
    
    return strtolower(round(floatval($distanceInMinutes) / 525600) . ' anos');
}

/**
    * Função para fazer upload de arquivos
    * @author Rafael Wendel Pinheiro
    * @param File $arquivo Arquivo a ser salvo no servidor
    * @param String $pasta Local onde o arquivo será salvo
    * @param Array $tipos Extensões permitidas para o arquivo
    * @param String $nome Nome do arquivo. Null para manter o nome original
    * @return array
*/
function uploadFile($arquivo, $pasta, $tipos, $nome, $name = false, $up = false){
    if($_SERVER['SERVER_NAME'] == 'thehits.localhost') {
        $dominio = 'http://thehits.localhost/';
    } else {
        $dominio = 'http://www.radiothehits.com/';
    }
    $pasta = '../media/uploads/';
    (($name == false)) ? $prefix = 'u-' : $prefix = $name;
    $nome = $prefix . $nome;

    if($up == true) {
        $pasta = '../../media/uploads/';
    }

    if(isset($arquivo)){
        $infos = explode(".", $arquivo["name"]);

        if(!$nome){
            for($i = 0; $i < count($infos) - 1; $i++){
                $nomeOriginal = $nomeOriginal . $infos[$i] . ".";
            }
        }
        else{
            $nomeOriginal = $nome . ".";
        }

        $tipoArquivo = $infos[count($infos) - 1];

        $tipoPermitido = false;
        foreach($tipos as $tipo){
            if(strtolower($tipoArquivo) == strtolower($tipo)){
                $tipoPermitido = true;
            }
        }
        if(!$tipoPermitido){
            $retorno["erro"] = 1; // tipo ñ permitido
        }
        else{
            if(move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeOriginal . $tipoArquivo)){
                chmod($pasta . $nomeOriginal . $tipoArquivo, 0644);
                $retorno["caminho"] = '/media/uploads/'. $nomeOriginal . $tipoArquivo;
            }
            else{
                $retorno["erro"] = 2; // erro ao fazer upload
            }
        }
    }
    else{
        $retorno["erro"] = 3; // arquivo não setado
    }
    return $retorno;
}

function uploadFileUrl($url, $name = false) {
    $url = trim($_POST["url"]);

    if($url) {
        $file = fopen($url,"rb");

        if($file) {
            $valid_exts = array("jpg","jpeg","gif","png");
            $ext = end(explode(".",strtolower(basename($url))));

            if(in_array($ext,$valid_exts)) {
               $novoNome = md5(microtime()) . $extensao;

               (($name == false)) ? $prefix = 'upl-' : $prefix = $name;
               $novoNome = $prefix . $novoNome;
               $destino = '../media/uploads/' . $novoNome;

               $newfile = fopen($destino . $novoNome, "wb");
               if($newfile) {
                  while(!feof($file)) {
                    fwrite($newfile,fread($file,1024 * 8),1024 * 8);
                  }
                }

                $retorno["caminho"] = '/media/uploads/'. $novoNome;
           } else {
                $retorno['erro'] = 1; // Não permito não fera.
            }
        } else {
            $retorno['erro'] = 2; // Não deu, ué.
        }
    } else {
        $retorno['erro'] = 3; // Não setado.
    }

    return $retorno;
}

function erro404() {
	header("HTTP/1.0 404 Not Found");
	readfile('404/index.html');
	exit();
}

function getAlbum($id, $mysqli) {
    if(is_numeric($id)) {
        $sql = $mysqli->query("SELECT * FROM ph_albuns WHERE id='$id' LIMIT 1");
    } else {
        $sql = $mysqli->query("SELECT * FROM ph_albuns WHERE nome='$id' LIMIT 1");
    }

    $sql2 = $sql->fetch_assoc();
    if($sql->num_rows > 0) { return $sql2; } else { return false;}
}

function getArtista($id, $mysqli) {
    if(is_numeric($id)) {
        $sql = $mysqli->query("SELECT * FROM ph_artistas WHERE id='$id' LIMIT 1");
    } else {
        $sql = $mysqli->query("SELECT * FROM ph_artistas WHERE nome='$id' LIMIT 1");
    }

    $sql2 = $sql->fetch_assoc();
    if($sql->num_rows > 0) { return $sql2; } else { return false;}
}

function get_tag( $attr, $value, $xml ) {

    $attr = preg_quote($attr);
    $value = preg_quote($value);

    $tag_regex = '/<span[^>]*'.$attr.'="'.$value.'">(.*?)<\\/span>/si';

    preg_match($tag_regex,
        $xml,
        $matches);
    return $matches[1];
}

function hasCargoE($cargo, $nick, $mysqli) {
    if(is_numeric($nick)) {
        $sql = $mysqli->query("SELECT * FROM acp_usuarios WHERE id='$nick' LIMIT 1");
    } else {
        $sql = $mysqli->query("SELECT * FROM acp_usuarios WHERE nick='$nick' LIMIT 1");
    }

    $sql2 = $sql->fetch_assoc();
    $cargos = explode('|', $sql2['cargos_e']);

    if(in_array($cargo, $cargos)) {
        return true;
    } else {
        return false;
    }
}