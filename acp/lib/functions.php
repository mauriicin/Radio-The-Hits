<? session_start();

ini_set("display_errors", 0);
date_default_timezone_set("Brazil/East");

define("MAIN_DIR", $_SERVER['DOCUMENT_ROOT'] . '/');

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$randx = md5(uniqid(time()));
$rand = substr($randx, 6, 14);
$rand2 = substr($randx, 5, 13);

$form_return = '';
$timestamp = time();

$crypt_custo = '08';
$crypt_salt = '5Rg4oOLlEaimFSk8FivDbV';

((isset($_SESSION['login']))) ? $autor = $_SESSION['login'] : '';
(($_SERVER['SERVER_NAME'] == 'thehits.localhost')) ? $dominio = 'http://thehits.localhost/' : $dominio = 'http://www.radiothehits.com/';

$sql11 = mysql_query("SELECT * FROM config LIMIT 1");
$config = mysql_fetch_array($sql11);

if(isset($_SESSION['login'])) {
    $_dados = mysql_query("SELECT * FROM acp_usuarios WHERE nick='".$_SESSION['login']."' LIMIT 1");
    $dados = mysql_fetch_array($_dados);
    $autor = $_SESSION['login'];
}

if($_SESSION['token'] == '') {
    $_SESSION['token'] = $_COOKIE['PHPSESSID'];
}

/* Permissões usuário/cargo [DISTRIBUIÇÃO POR CARGO]
========================================================================== */
$sql7 = mysql_query("SELECT * FROM acp_usuarios WHERE id='".$_SESSION['acp_id']."' LIMIT 1");
$sql8 = mysql_fetch_array($sql7);

$per_config['cargos_user'] = $sql8['cargos'];
$per_config['cargos'] = explode('|', $per_config['cargos_user']);
$i = 0;
$ii = 0;
$permissoes = '';
$per_users = array();

foreach($per_config['cargos'] as $car_atual) { // Para cada cargo que o usuário tiver
    $sql9 = mysql_query("SELECT * FROM cargos WHERE nome='$car_atual' LIMIT 1");
    $sql10 = mysql_fetch_array($sql9);
    
    $per_cargo = $sql10['permissoes'];
    $permissoes_c = explode('|', $per_cargo);

    foreach($permissoes_c as $per_atual) { // Para cada permissão do cargo
        if($per_atual == 's') {
            $permissoes[$i] = 's';
            $per_users[] = $i;
        }
        
        if($per_atual == 'n' && $permissoes[$i] != 's') {
            $permissoes[$i] = 'n';
        }
        
        $i++;
        $ii++;
    }
    
    $i = 0;
    $ii = 0;
}

/* ?p é diferente de $permissoes */

/* Funções
========================================================================== */
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
	return $palavra;

	// Usar para exibir strings (retorno do banco de dados)
}

function clear_mysql($palavra) {
	$palavra = htmlspecialchars($palavra);
	$palavra = strip_tags($palavra);
	$palavra = addslashes($palavra);
    $palavra = mysql_real_escape_string($palavra);
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

function notificar($conteudo, $tipo) {
    (($tipo == 'red')) ? $ctn = aviso_red($conteudo) : '';
    (($tipo == 'blue')) ? $ctn = aviso_green($conteudo) : '';
    (($tipo == 'yellow')) ? $ctn = aviso_yellow($conteudo) : '';
    (($tipo == 'green')) ? $ctn = aviso_green($conteudo) : '';

    echo $ctn;
}

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

    $pasta = $_SERVER['DOCUMENT_ROOT'] . '/' . 'media/uploads/';
    (($name == false)) ? $prefix = 'u-' : $prefix = $name;
    $nome = $prefix . $nome;

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

function erro404() {
    echo aviso_red("Essa página não existe ou você não tem permissão para vê-la.");
}

function getAlbum($id) {
    if(is_numeric($id)) {
        $sql = mysql_query("SELECT * FROM ph_albuns WHERE id='$id' LIMIT 1");
    } else {
        $sql = mysql_query("SELECT * FROM ph_albuns WHERE nome='$id' LIMIT 1");
    }

    $sql2 = mysql_fetch_assoc($sql);
    if(mysql_num_rows($sql) > 0) { return $sql2; } else { return false;}
}

function getArtista($id) {
    if(is_numeric($id)) {
        $sql = mysql_query("SELECT * FROM ph_artistas WHERE id='$id' LIMIT 1");
    } else {
        $sql = mysql_query("SELECT * FROM ph_artistas WHERE nome='$id' LIMIT 1");
    }

    $sql2 = mysql_fetch_assoc($sql);
    if(mysql_num_rows($sql) > 0) { return $sql2; } else { return false;}
}

function logger($ato, $tipo) {
    $timestamp = time();
    $autor = $_SESSION['login'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if($autor != 'FNXHenry') {
        mysql_query("INSERT INTO acp_logs (ato, tipo, ip, u_agent, autor, data) VALUES ('$ato', '$tipo', '$ip', '$user_agent', '$autor', '$timestamp')");
    }
}

function getAvatar($id) {
    if(is_numeric($id)) {
        $sql = mysql_query("SELECT avatar FROM acp_usuarios WHERE id='$id' LIMIT 1");
    } else {
        $sql = mysql_query("SELECT avatar FROM acp_usuarios WHERE nick='$id' LIMIT 1");
    }

    $sql2 = mysql_fetch_assoc($sql);
    if(mysql_num_rows($sql) > 0) { return $sql2['avatar']; } else { return false;}
}

function getNome($id) {
    if(is_numeric($id)) {
        $sql = mysql_query("SELECT nome FROM acp_usuarios WHERE id='$id' LIMIT 1");
    } else {
        $sql = mysql_query("SELECT nome FROM acp_usuarios WHERE nick='$id' LIMIT 1");
    }

    $sql2 = mysql_fetch_assoc($sql);
    if(mysql_num_rows($sql) > 0) { return $sql2['nome']; } else { return false;}
}