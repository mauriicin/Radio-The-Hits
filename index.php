<?php 
include "lib/config.php";
include "lib/functions.php";
include "lib/system.php";

$network_side = <<<EOD
<div class="title-section margin">
<h1>Curta-nos <b>no facebook</b></h1>
<div id="separator"></div>
</div>

<div class="box-content">
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fradiothehitsfm&width=310&height=258&colorscheme=light&show_faces=true&header=false&stream=false&show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:310px; height:258px;" allowTransparency="true"></iframe>
</div>

<div class="title-section margin">
<h1>Siga-nos <b>no twitter</b></h1>
<div id="separator"></div>
</div>

<div class="box-content">
<a class="twitter-timeline" data-width="310" data-height="214" data-link-color="#F8C001" href="https://twitter.com/radiothehits">Tweets by radiothehits</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
</div>
EOD;

$network_side_face = <<<EOD
<div class="title-section margin">
<h1>Curta-nos <b>no facebook</b></h1>
<div id="separator"></div>
</div>

<div class="box-content">
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fradiothehitsfm&width=310&height=258&colorscheme=light&show_faces=true&header=false&stream=false&show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:310px; height:258px;" allowTransparency="true"></iframe>
</div>
EOD;

$DEV_img = array();
$DEV_img[] = 'http://www.jornaldeibaiti.com.br/wp-content/uploads/2014/07/demi-lovato.jpg';
$DEV_img[] = 'http://imguol.com/c/entretenimento/2014/05/04/4maio2014---demi-lovato-durante-sua-participacao-no-fantastico-1399255349517_1027x618.jpg';
$DEV_img[] = 'http://i.huffpost.com/gen/1744831/thumbs/o-DEMI-LOVATO-2014-facebook.jpg';
$DEV_img[] = 'http://static.tumblr.com/4pxlsbd/xzJn3p0ei/tfios_soundtrack_cover.jpg';
$DEV_img[] = 'http://www.thehoya.com/wp-content/uploads/2014/06/the-fault-in-our-stars-movie-wallpaper-5.jpg';
$DEV_img[] = 'http://wp.clicrbs.com.br/zoom/files/2014/08/Jogos-Vorazes-Em-chamas.jpg';
$DEV_img[] = 'http://i.huffpost.com/gen/1744831/thumbs/o-DEMI-LOVATO-2014-facebook.jpg';
$DEV_img[] = 'http://static.tumblr.com/4pxlsbd/xzJn3p0ei/tfios_soundtrack_cover.jpg';
$DEV_img[] = 'http://www.thehoya.com/wp-content/uploads/2014/06/the-fault-in-our-stars-movie-wallpaper-5.jpg';
$DEV_img[] = 'http://capricho.abril.com.br/imagem/580x362/show-estreia-demi-lovato-brasil-150506.jpg?v=140423104513';
$DEV_img[] = 'http://f.i.uol.com.br/fotografia/2013/10/14/326583-970x600-1.jpeg';
$DEV_img[] = 'http://www.blastr.com/sites/blastr/files/iron-man-3-tony-stark-robert-downey-jr_0.jpg';

ob_start();
require_once 'conteudo.php';
$content_data = ob_get_contents();
ob_end_clean();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
    <meta name="language" content="pt-br">

    <meta property="og:site_name" content="Rádio TheHits">
    <meta property="og:url" content="http://www.radiothehits.com/">
    <meta property="og:title" content="Rádio TheHits - mais rádio, mais música!">
    <meta property="og:image" content="http://www.radiothehits.com/fb-cover.png">
    <meta property="og:description" content="Ouça música online, Ouça nossas Playlists! Seus artistas preferidos o dia todo na Rádio TheHits.">
    
    <meta name="title" content="Rádio TheHits">
    <meta name="description" content="Mais rádio, mais música">
    <meta name="keywords" content="radio, thehits, rádio, brasil, música, pop, rock, rap, ouvir música, fm">

    <title><?=$title_pag;?></title>
    <link rel="icon" href="/media/images/favicon.jpg">
    <link rel="stylesheet" href="/media/css/style.css" class="cssfx">
    <link rel="stylesheet" href="/media/css/general.css">
    <link rel="stylesheet" href="/media/css/fontello.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open Sans:400,300,600,700">
        <script src="/media/js/jquery.js"></script>
        <script src="/media/js/player.js"></script>
        <script src="/media/js/musica.js"></script>

    <script type="text/javascript">
    radio_content = '<object type="application/x-shockwave-flash" data="/media/others/WHMSonic.swf" width="372" height="60" id="WHMSonicPlayer1" style="visibility: visible;"><param name="menu" value="false"><param name="id" value="WHMSonicPlayer1"><param name="allowFullscreen" value="true"><param name="allowScriptAccess" value="always"><param name="bgcolor" value="#FFFFFF"><param name="wmode" value="transparent"><param name="flashvars" value="path=/media/others/WHMSonic.swf&source=<?=$config['radio_ip'];?>:<?=$config['radio_porta'];?>&volume=100&autoplay=true&width=372&height=60&twitter=https://twitter.com/sonicpanel&facebook=http://www.facebook.com/whmsonicfans&logo=http://www.whmsonic.com/flashplayer.php&url=http://www.radiothehits.com/&embedCallback=null&bgcolor=#FFFFFF&wmode=transparent&containerId=WHMSonicPlayer1"></object>';
    radio_playing_ck = <?=(($_COOKIE['radio'] == 'pause')) ? 'false' : 'true';?>;

    title_pag = '<?=$title_pag;?>';
    window.parent.document.title = title_pag;
    parent.pl.start();

    <? $artistas = array();
    $sql3 = $mysqli->query("SELECT nome FROM ph_artistas");
    while($sql4 = $sql3->fetch_assoc()) {
        $artistas[] = $sql4['nome'];
    }

    $musicas = array();
    $sql5 = $mysqli->query("SELECT nome FROM ph_musicas WHERE status='aprovada'");
    while($sql6 = $sql5->fetch_assoc()) {
        $musicas[] = $sql6['nome'];
    }

    $_artistas = '';
    foreach ($artistas as $atual) {
        $_artistas .= '"'.$atual.'",';
    }

    $_musicas = '';
    foreach ($musicas as $atual) {
        $_musicas .= '"'.$atual.'",';
    }

    $_artistas = substr($_artistas, 0, -1);
    $_musicas = substr($_musicas, 0, -1); ?>
    r_list_artists = [<?=$_artistas;?>];
    </script>
    <? if(!empty($code_script)) {
        echo '<script type="text/javascript">';
        echo $code_script;
        echo '</script>';
    } ?>
</head>

<body>
    <div class="loader-corner"></div>
    <header class="top-info"><div class="align">
        <a href="/"><div id="logo"></div></a>
        <div id="bar"></div>
        <div id="infos">Mais rádio, mais música</div>

        <div id="search">
            <form action="/pesquisar" method="post">
                <input type="text" name="search" placeholder="o que vc quer ouvir hoje?" autocomplete="off">
                <button type="submit"><i class="icon-search"></i></button>
                <br>
            </form>
        </div>
        <br>
    </div></header>

    <header class="top r-img">
        <nav class="menu">
            <center>
                <a href="/inicio">Início</a>

                <? 

                                $sql7 = $mysqli->query("SELECT * FROM menu ORDER BY id DESC");
                while($sql8 = $sql7->fetch_assoc()) {
                    echo '<a id="link-'.$sql8['id'].'" href="#">'.$sql8['titulo'].' <i class="icon-down-open"></i></a>';
                } ?>
                <a href="/contato">Contato</a>
            </center>

            <? $sql7 = $mysqli->query("SELECT * FROM menu ORDER BY id DESC");
            while($sql8 = $sql7->fetch_assoc()) {
                $sql9 = $mysqli->query("SELECT * FROM sub_menu WHERE id_menu='".$sql8['id']."'");

                if($sql9->num_rows > 0) { ?>
            <div id="sub-<?=$sql8['id'];?>" class="sub-menu">
                <div class="arrow"></div>

                <div class="links">
                    <? $i = 0;
                    while($sql10 = $sql9->fetch_assoc()) {
                        $i  ;
                        if($sql9->num_rows == $i) { $last = ' class="last"'; } else { $last = ''; }
                        ?>
                    <a href="<?=$sql10['link'];?>"><li<?=$last;?>><i class="icon-<?=$sql10['icone'];?>"></i> <span><?=$sql10['nome'];?></span></li></a>
                    <? } ?>
                </div>
            </div>
            <? } } ?>
        </nav>

        <div class="align">
            <!--
            <div id="player">
                <div class="avatar"><div class="img" style="background-image:url(<?=$config['radio_autodj'];?>);"></div></div>
                <div class="info">
                    <div id="broadcaster" class="r-broadcaster pointer" onclick="radio.info(false);">...</div><br>
                    <div id="program" class="r-program pointer" onclick="radio.info(false);">...</div><br>

                    <div id="listeners">
                        <i class="icon-headphones"></i>
                        <span class="r-listeners">...</span> ouvintes
                    </div>

                    <div class="controls">
                        <?=(($_COOKIE['radio'] == 'pause')) ? '<div class="btn control" onclick="parent.player.pl.play();"><i class="icon-play"></i></div>' : '<div class="btn control" onclick="parent.player.pl.pause();"><i class="icon-pause"></i></div>';?>
                        <div class="btn heart r-liked"><i class="icon-heart"></i></div>
                        <div class="btn clock r-time tip" title="..."><i class="icon-clock"></i></div>
                        <div class="btn music tip" title="Faça um pedido ao locutor" onclick="radio.pedidos();"><i class="icon-music"></i></div>
                    </div>
                </div>
                    <a href="/radio/pop-up"><div class="top-10-btn"><i class="icon-clock"></i> Ouça á Rádio</div></a>

                <br>
            </div> -->

            <!--
            <div id="player">
                <div class="f-left">
                    <div id="title">Agora toca</div>
                    <div id="img" class="r-img" style="background-image:url(<?=$config['radio_autodj'];?>);"></div>
                </div>

                <div class="infos">
                    <div class="box-info singer r-broadcaster">Carregando</div></a><br>
                    <div class="box-info r-program">Carregando</div>

                    <div id="controls">
                        <?=(($_COOKIE['radio'] == 'pause')) ? '<div class="btn control" onclick="parent.pl.play();"><i class="icon-play"></i></div>' : '<div class="btn control" onclick="parent.pl.pause();"><i class="icon-pause"></i></div>';?>
                                                <?=(($_COOKIE['radio'] == 'pause')) ? '<div class="btn control" onclick="parent.pl.play();"><i class="icon-play"></i></div>' : '<div class="btn control" onclick="parent.pl.pause();"><i class="icon-pause"></i></div>';?>
                        <div class="btn heart tip" title="Gostei da música" onclick="radio.heart();"><i class="icon-heart"></i></div>
                        <div class="btn music tip" title="Fazer pedidos" onclick="radio.pedidos();"><i class="icon-music"></i></div>
                    </div>
                    <? if($config['radio_top'] == 's') { ?>
                    <a href="/radio/top-10"><div class="top-10-btn"><i class="icon-clock"></i> Vote no Top 10</div></a>
                    <? } ?>
                </div>
            </div> -->

            <div id="logo"></div>
            <div id="separador"></div>
            <div id="playergrande">
                  <div class="img-fix">
                    <div id="img">
                    <div class="r-image r-img" style="background-image:url(/media/images/album-cover.jpg);"><div class="cimacd"></div></div>
                                    </div>
                              </div>
                    <div id="status">
                    <div id="title"><i class="icon-headphones space"></i>Tocando Agora:</div>
                    <div class="puxamusica">Carregando</div>
                    <div id="espacamento"></div>
                    <div id="title"><i class="icon-music space"></i>Próxima Música:</div>
                    <div class="puxamusica-prox space">Carregando</div>
                                    </div>
                    <div id="controls">
<a href="/paginas/5/aplicativo"><div class="btnn tip"  title="Ouça pelo App."><i class="icon-mobile"></i></div></a>                     
                            <a class="geratt" target="_blank"><div class="btnn tip" title="Compartilhar no Twitter"><i class="icon-twitter"></i></div></a>
                                <a href="https://www.instagram.com/radiothehits/" target="_blank"><div class="btnn tip"  title="Nosso Instagram"><i class="icon-instagram"></i></div></a>
                                <div class="btnn tip" title="Fazer pedidos" onclick="radio.pedidos();"><i class="icon-music"></i></div>
                    </div>
                    <a onclick="window.open('http://radiothehits.com/popup/', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=725');"><div class="top-10-btn" onclick="parent.pl.pause();"><i class="icon-play"></i> Ouça via Pop-Up</div></a>
                        
                        </div>

            <!--<div id="slide">
                <div id="slider" class="nivoSlider">
                    <? $sql = $mysqli->query("SELECT * FROM slide ORDER BY id DESC");
                    while($sql2 = $sql->fetch_assoc()) {?>
                    <a href="<?=$sql2['link'];?>" onclick="ctn.slide(<?=$sql2['id'];?>);" target="_blank"><img src="<?=$sql2['imagem'];?>" alt="" title="<a href='<?=$sql2['link'];?>' onclick='ctn.slide(<?=$sql2['id'];?>);' target='_blank'><div class='f-left'><span class='title'><?=clear(encurtar($sql2['titulo'], 60));?></span><br><span class='desc'><?=clear(encurtar($sql2['descricao'], 70));?></span></div></a><br>"></a>
                    <? } ?>
                </div>
            </div>-->

            <br>
        </div>

        
        <!--<div id="playlist" class="r-playlist"><div class="align">
            <div id="played" class="box-music">
                <div id="title"><div class="title previous">No ar</div></div>

                <div id="img" class="r-previous-album r-img" style="background-image:url(/media/images/album-cover.jpg);"></div>

                <div id="infos">
                    <div class="singer">Agora você ouve:</div>
                    <div class="puxamusica">Carregando</div>
                </div>

                <div id="controls">
                    
                    <div class="btn r-previous-like" onclick="radio.like(0, this);"><i class="icon-heart"></i></div>
                    <a href="#" class="r-previous-music-link"><div class="btn"><i class="icon-pencil"></i></div></a>
                

                <?=(($_COOKIE['radio'] == 'pause')) ? '<div class="btn control" onclick="parent.pl.play();"><i class="icon-play"></i></div>' : '<div class="btn control" onclick="parent.pl.pause();"><i class="icon-pause"></i></div>';?>
                <div class="btn tip" title="Faça Seu Pedido" onclick="radio.pedidos();"><i class="icon-pencil"></i></div>
                <div class="btn heart r-liked" onclick="radio.heart();"><i class="icon-heart"></i></div>
                <a class="geratt" href="https://twitter.com/share?url=<?=$dominio;?>/noticias/ler/<?=$id;?>/<?=trataurl($sql2['titulo']);?>/&via=radiothehits&text=<?=clear($sql2['titulo']) . ' - ';?>" target="_blank"><div class="btn tip"  title="Nosso Twitter"><i class="icon-twitter"></i></div></a>
                <a href="https://www.facebook.com/radiothehitsfm" target="_blank"><div class="btn tip" title="Nossa Fã-Page"><i class="icon-facebook"></i></div></a>
                <a href="https://www.instagram.com/radiothehits/" target="_blank"><div class="btn tip"  title="Nosso Instagram"><i class="icon-instagram"></i></div></a>
                <div class="btn clock r-time tip" title="..."><i class="icon-clock"></i></div>
                </div>
            </div>

                    <a href="#." onclick="window.open('http://radiothehits.com/popup/', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1000, HEIGHT=725');"><div class="top-10-btn"><i class="icon-play"></i> Ouça á Rádio</div></a>
            <? if($config['radio_top'] == 's') { ?>
                    <a href="/radio/top-10"><div class="top-10-btn"><i class="icon-clock"></i> Vote no Top 10</div></a>
                    <? } ?>
            <br>
        </div>-->
</div>
    </header>
    
    <?=$content_data;?>

    <footer class="rodape">

        <div id="black-layer"></div>
        <div id="black-layer2"></div>

        <div class="align">
            <div id="mobile">
                <div class="title-section">
                    <h1>TheHits <b>no seu celular</b></h1>
                    <div id="separator"></div>
                </div>

                <a href="https://play.google.com/store/apps/details?id=com.cabin.thehits" target="_blank"><i class="icon-mobile"></i> Escute a rádio no Android</a><br>
                <a href="#"><i class="icon-mobile"></i> Escute a rádio no iOS</a><br>
            </div>

            <a href="/"><div id="logo"></div></a>

            <div id="network">
                <div class="title-section">
                    <h1>Redes <b>sociais</b></h1>
                    <div id="separator"></div>
                </div>

                <a href="http://www.facebook.com/radiothehitsfm" target="_blank"><i class="icon-facebook"></i> facebook.com/radiothehitsfm</a><br>
                <a href="http://www.twitter.com/radiothehits" target="_blank"><i class="icon-twitter"></i> twitter.com/radiothehits</a><br>
            </div>
        </div>
    </footer>

    <footer class="rights"><div class="align">
        <div class="f-left">Rádio TheHits � - Todos os direitos reservados pela Lei nº 9.610, de 19 de fevereiro de 1998.</div>
        <div class="f-right">Desenvolvido por <a href="https://twitter.com/@eitayagu" target="_blank">Yago M.</a>, <a href="http://www.twitter.com/@hnrqq" target="_blank">Henrique A.</a> e <a href="http://www.twitter.com/@heeysouzaa" target="_blank">Maurício</a></div>
    </div></footer>

    <div class="data-ph-player"><div id="data-ph-player"></div></div>
    <div class="data-pl-info"></div>
<div id="data-player" style="position:fixed;"></div>

    <script src="/media/js/jquery.js"></script>
    <script src="/media/js/jquery-ui.js"></script>
    <script src="/media/js/general.js"></script>
    <script src="/media/js/site.js"></script>
    <? if($_GET['p'] == '') {?><script src="/media/js/home.js"></script><? } ?>
    <? if($_GET['p'] == 1) {?><script src="/media/js/music.js"></script><? } ?>
    <? if($_GET['p'] == 4) {?><script src="/media/js/news.js"></script><? } ?>
    <? if($_GET['p'] == 5) {?><script src="/media/js/page.js"></script><? } ?>
    <? if($_GET['p'] == 6) {?><script src="/media/js/top.js"></script><? } ?>
</body>
</html>