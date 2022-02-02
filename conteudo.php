<?php $p = ((isset($_GET['p']))) ? $p = anti_injecao($_GET['p']) : $p = 0;

// 0 = página padrão
// array( [caminho da pág], [titulo da pág])

$paginas = array(
	array('home.php', 'Rádio TheHits - Mais rádio, mais música'),
	array('playhits/ver_musica.php', 'Músicas PlayHits'),
	array('paginas/pesquisar.php', 'Pesquisar'),
	array('playhits/ver_artista.php', 'Artistas PlayHits'),
        array('noticias/ver_noticia.php', 'Notícias'),
        array('playhits/colaborar.php', 'Rádio TheHits - Colaborar'),
        array('radio/top_10.php', 'Rádio TheHits - Top 10'),
        array('paginas/equipe.php', 'Rádio TheHits - Equipe'),
        array('paginas/participe_equipe.php', 'Rádio TheHits - Participe da equipe'),
        array('paginas/ver_pagina.php', 'Ver página'),
        array('paginas/grade.php', 'Rádio TheHits - Grade de programação'),
);

$infos = $paginas[$p];
$pagina = $infos[0];
$title_pag = $infos[1];

if($pagina != 'home.php') {echo '<section class="content"><div class="align">';}

((file_exists($pagina))) ? include $pagina : erro404();
((empty($p) && $pagina != 'home.php')) ? erro404() : '';

if($pagina != 'home.php') {echo '</div></section>';}


if($pag_info['title'] != '') {$title_pag = addslashes($pag_info['title']);}