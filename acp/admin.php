<? session_start();
include "lib/config.php";
include "lib/functions.php";

if(!isset($_SESSION['login'])) {
	header("Location: index.php");
	die();
}

$menu_cats = array("Início", "Administração", "Conteúdo", "PlayHits", "Notícias", "Rádio");

/*	array([ $permissao ], [ $link ], [ $nome ], [ $notificações ]);
    se $permissao for 0, é acesso livro para todos 
*/

// Início
$nao_lido = 0;
$avisos = '';

$sql = mysql_query("SELECT * FROM acp_avisos ORDER BY id DESC");
while($sql2 = mysql_fetch_array($sql)) {
	$lidos = explode('|', $sql2['lido']);
	if(!in_array($dados['id'], $lidos)) { $nao_lido++; }
}

$menu_links[] = array(
	array(0, "admin.php", "Página inicial", $nao_lido),
	array(0, "?p=1", "Minha conta", 0),
	array(0, "?p=2", "Chat da equipe", 0),
	array(0, "?p=3", "Biblioteca de mídia", 0),
	array(0, "/", "Ir para o site", 0),
	
	// p=5 - deslogar
);

// Administração
$menu_links[] = array(
	array(1, "?p=6", "Configurações gerais", 0),
	array(2, "?p=7", "Gerenciar avisos", 0),
	array(3, "?p=8", "Emitir alerta", 0),
	array(4, "?p=9", "Logs", 0),
	array(5, "?p=10", "Contas", 0),
	array(6, "?p=11", "Cargos", 0),
	array(7, "?p=12", "Pedidos para entrar na equipe", 0),
);

// Conteúdo
$menu_links[] = array(
	array(8, "?p=13", "Slide", 0),
	array(9, "?p=14", "Músicas em destaque", 0),
	array(10, "?p=15", "Páginas", 0),
	array(23, "?p=26", "Menu", 0),
	array(24, "?p=27", "Sub-menu", 0)
);


// PlayHits
$menu_links[] = array(
	array(11, "?p=16", "Artistas", 0),
	array(12, "?p=17", "Álbuns", 0),
	array(13, "?p=18", "Músicas", 0),
	array(14, "?p=19", "Playlists", 0),
	array(22, "?p=25", "Top 10", 0),
);

// Notícias
$menu_links[] = array(
	array(15, "?p=20", "Notícias", 0),
	// PER 16 => STATUS ATIVO
	// PER 17 => NOTÍCIA FIXA
	array(18, "?p=21", "Categorias", 0),
);

// Rádio
$menu_links[] = array(
	array(19, "?p=22", "Iniciar programa", 0),
	array(20, "?p=23", "Pedidos", 0),
	array(21, "?p=24", "Grade de programação", 0),
);


(($_GET['p'] == '')) ? $_GET['p'] = 0 : ''; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="language" content="pt-br">

	<meta name="robots" content="noindex, nofollow">
	<meta name="url" content="http://www.radiothehits.com">

	<title>Rádio TheHits - Painel de gerenciamento</title>
	
	<link rel="icon" href="/media/images/favicon.png">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Viga|Signika:400,300,600">

	<link rel="stylesheet" href="/media/css/acp_general.css">
	<link rel="stylesheet" href="/media/css/acp_style.css" class="cssfx">
</head>

<body class="panel">
	<div class="page">
		<aside class="sidebar">
			<div class="avatar"><div id="img" style="background-image:url(<?=clear_img($dados['avatar']);?>);"></div></div>
			<a href="?p=5"><div class="logout"><button class="btn btn-primary btn-block">Desconectar</button></div></a>

			<nav class="menu">
				<? $i = 0;
				foreach($menu_cats as $cat_atual) {
					$ii = 0;
					$dados_links = $menu_links[$i];
					$exibir = false;

					foreach($dados_links as $link_atual) {
						$permissao_need = $link_atual[0];
						$link = $link_atual[1];
						$nome = $link_atual[2];
						$ntf = $link_atual[3];
						$id_pag = str_replace("?p=", "", $link);

						if($permissoes[$permissao_need] == 's') {
							if($ii == 0) {
								echo "<div class=\"category\"><h1>$cat_atual</h1>";
								$exibir = true;
							}

							if($id_pag == $_GET['p']) {
								$bread_cat = $cat_atual;
								$bread_pag = $nome;
							}

							$ii++;

							if ($ntf > 0) {
								$ntf = '<div class="ntf">'.$ntf.'</div>';
							} else {
								$ntf = '';
							}

							echo "<a href=\"$link\">$nome $ntf</a>";
						}
					}

					if($exibir) { echo '</div>'; }
					$i++;
				} 
				?>
			</nav>
		</aside>

		<section class="content"><? include "conteudo.php"; ?></section>
	</div>

	<script src="/media/js/jquery.js"></script>
	<script src="/media/ckeditor/ckeditor.js"></script>
	<script src="/media/js/acp_general.js"></script>
	<script src="/media/js/acp_panel.js"></script>
</body>
</html>