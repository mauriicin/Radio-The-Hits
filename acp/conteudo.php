<? 
$p = htmlspecialchars(addslashes($_REQUEST['p']));

switch($p) {
case 1: $pagina = "mdl/home/minha_conta.php"; $mdl['title'] = 'Minha conta'; break;
case 2: $pagina = "mdl/home/chat_equipe.php"; $mdl['title'] = 'Chat da equipe'; break;
case 3: $pagina = "mdl/home/media.php"; $mdl['title'] = 'Mídia'; break;
case 4: $pagina = "mdl/home/site.php"; $mdl['title'] = 'Ir para o site'; break;
case 5: $pagina = "mdl/home/deslogar.php"; $mdl['title'] = 'Deslogar'; break;

case 6: $pagina = "mdl/admin/config.php"; $mdl['title'] = 'Configurações'; break;
case 7: $pagina = "mdl/admin/gerenciar_avisos.php"; $mdl['title'] = 'Gerenciar avisos'; break;
case 8: $pagina = "mdl/admin/enviar_alerta.php"; $mdl['title'] = 'Emitir alerta'; break;
case 9: $pagina = "mdl/admin/logs.php"; $mdl['title'] = 'Logs'; break;
case 10: $pagina = "mdl/admin/gerenciar_contas.php"; $mdl['title'] = 'Contas (painel)'; break;
case 11: $pagina = "mdl/admin/gerenciar_cargos.php"; $mdl['title'] = 'Cargos (painel)'; break;
case 12: $pagina = "mdl/admin/pedidos_equipe.php"; $mdl['title'] = 'Pedidos para entrar na equipe'; break;

case 13: $pagina = "mdl/conteudo/slide.php"; $mdl['title'] = 'Slide'; break;
case 14: $pagina = "mdl/conteudo/destaque.php"; $mdl['title'] = 'Músicas em destaque'; break;
case 15: $pagina = "mdl/conteudo/paginas.php"; $mdl['title'] = 'Páginas'; break;
case 26: $pagina = "mdl/conteudo/menu.php"; $mdl['title'] = 'Menu'; break;
case 27: $pagina = "mdl/conteudo/sub_menu.php"; $mdl['title'] = 'Sub-menu'; break;

case 16: $pagina = "mdl/playhits/artistas.php"; $mdl['title'] = 'Artistas'; break;
case 17: $pagina = "mdl/playhits/albuns.php"; $mdl['title'] = 'Álbuns'; break;
case 18: $pagina = "mdl/playhits/musicas.php"; $mdl['title'] = 'Músicas'; break;
case 19: $pagina = "mdl/playhits/playlists.php"; $mdl['title'] = 'Playlists'; break;
case 25: $pagina = "mdl/playhits/top.php"; $mdl['title'] = 'Top 10'; break;

case 20: $pagina = "mdl/noticias/noticias.php"; $mdl['title'] = 'Notícias'; break;
case 21: $pagina = "mdl/noticias/categorias.php"; $mdl['title'] = 'Categorias'; break;

case 22: $pagina = "mdl/radio/iniciar.php"; $mdl['title'] = 'Iniciar programa'; break;
case 23: $pagina = "mdl/radio/pedidos.php"; $mdl['title'] = 'Pedidos'; break;
case 24: $pagina = "mdl/radio/grade.php"; $mdl['title'] = 'Grade de programação'; break;



default:
$pagina = "mdl/home.php";
$mdl['title'] = 'Página inicial';
break;
}

if(file_exists($pagina)) {
	echo "<div id=\"title-pag\"><h1>".$mdl['title']."</h1></div>";
	echo "<div class=\"content\">";
	include $pagina;
	echo "</div>";
} else {
	erro404();
}

((empty($p) && $pagina != 'mdl/home.php')) ? erro404() : '';

