<? if($permissoes[5] == 'n') {erro404(); die(); }

$id = anti_injecao($_GET['id']);
$sql3x = mysql_query("SELECT * FROM acp_usuarios WHERE id='$id' LIMIT 1");
$exx = mysql_fetch_array($sql3x);

if($id != '' && $exx['login'] == 'FNXHenry' && $_SESSION['login'] != 'FNXHenry') {echo aviso_red("are u insane?");die();}


if($_GET['a'] == 1) {
  if($_POST['form_processa'] == 's') {
    $nick = clear_mysql($_POST['nick']);
    $nome = clear_mysql($_POST['nome']);
    $senha = 'HITS-acp-' . strtolower(base64_encode('$nick' . time()));
    $senha_md5 = md5($senha);
    $prosseguir = true;
  
    if($nick == '') {
      notificar("Digite um nick.","red");
      $prosseguir = false;
    }

    if($nome == '') {
      notificar("Digite um nome.","red");
      $prosseguir = false;
    }

    $_sql = mysql_query("SELECT * FROM acp_usuarios WHERE nick='$nick'");

    if(mysql_num_rows($_sql) > 0) {
      notificar("Este usuário já existe.","red");
      $prosseguir = false;
    }

    $cargos = '';
    $cargos_e = '';
      
    $sql8 = mysql_query("SELECT * FROM acp_usuarios WHERE id='".$_SESSION['acp_id']."' LIMIT 1");
    $sql9 = mysql_fetch_array($sql8);
      
    $sql9['cargos'] = explode('|', $sql9['cargos']);
    $carggs = $sql9['cargos'];
      
    $sql10 = mysql_query("SELECT * FROM cargos");
    while($sql11 = mysql_fetch_array($sql10)) {
      foreach($sql9['cargos'] as $car_atual) { // Para cada cargo que o $_SESSION [nick] tiver
        if($car_atual == $sql11['nome']) { $autorizado = true; }
      }

      if(strstr(strtolower($carggs), "webmaster") || strstr(strtolower($carggs), "administrador")) {
          $autorizado = true;
        }

      if($autorizado == true) {
        $id_cargo = $sql11['id'];
        if($_POST["c-$id_cargo"] == 'on') { $cargos .= $sql11['nome'] . '|'; }
        if($_POST["c2-$id_cargo"] == 'on') { $cargos_e .= $sql11['nome'] . '|'; }
      }
    }

    if($prosseguir == true) {
      mysql_query("INSERT INTO acp_usuarios (nick, senha, cargos, cargos_e, autor, data, nome) VALUES ('$nick', '$senha_md5', '$cargos', '$cargos_e','$autor', '$timestamp', '$nome')");
      logger("O usuário adicionou um novo usuário [$nick]", "acao");

      notificar("Sucesso!","blue");
      notificar("A senha do usuário é: <b>".$senha."</b><br>O usuário poderá mudar após o login.", "yellow");
      foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
    }
  } ?>
<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
    <div class="panel-body">
      <form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
        <?=$form_return;?>

        <div class="form-group">
          <label class="col-lg-2 control-label">Nick</label>
          <div class="col-lg-5"><input type="text" name="nick" class="form-control input-sm" value="<?=$_POST['nick'];?>"></div><br>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Nome</label>
          <div class="col-lg-5"><input type="text" name="nome" class="form-control input-sm" value="<?=$_POST['nick'];?>"></div><br>
        </div>

        <hr>

        <div class="well">Você deve selecionar o cargo do usuário e todos os outros cargos que este usuário gerencia. Exemplo: se ele for um Coordenador de Conteúdo, então selecione: Coordenador de Conteúdo, Jornalista, Tradutor, Colunista, etc. Tudo o que for relacionado ao conteúdo.</div>
        <div class="well">Se você tiver alguma dúvida sobre isso, não adicione nenhum usuário. Peça ajuda.</div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Cargos</label>
          <div class="col-lg-10">
        <? $sql4 = mysql_query("SELECT * FROM cargos ORDER BY id ASC");
        while($sql5 = mysql_fetch_array($sql4)) {
          $show = false;
          $sql6 = mysql_query("SELECT * FROM usuarios WHERE id='".$_SESSION['id']."' LIMIT 1");
          $sql7 = mysql_fetch_array($sql6);
          $sql7['cargos'] = explode('|', $sql7['cargos']);
          foreach($sql7['cargos'] as $car_atual) { // Para cada cargo que o $_SESSION [nick] tiver
            if($car_atual == $sql5['nome'] && $stop != true) { $show = true; }
            if($car_atual == 'Administrador' || $car_atual = 'CEO') { $show = true; $stop = true; } /* Se o cara for admin ele exibe os cargos e pronto, foda-se o resto */
          } 

          $check = explode('|', $ex['cargos']);
          $checked = false;
          $checked2 = false;

          foreach($check as $car_atuall) { // Para cada cargo que o usuário a ser editado tiver
            if($car_atuall == $sql5['nome']) { $checked = true; }
          } 

          if($sql5['nome'] == 'Usuário') { $show = false;}

          /* Cargos na página da equipe */
          $a = explode('|', $ex['cargos_e']);

          foreach($a as $c) { // Para cada cargo da pág equipe que o usuário a ser editado tiver
            if($c == $sql5['nome']) { $checked2 = true;}
          }

          if($show == true) { ?>
          <div style="font-weight:bold;display:inline-block;margin:5px;width:220px;"><?=$sql5['nome'];?></div>
          <input type="checkbox" <? if($checked == true) { echo 'checked="checked"'; } ?> id="c-<?=$sql5['id'];?>" name="c-<?=$sql5['id'];?>" type="checkbox">
          <div style="font-weight:bold;display:inline-block;margin:5px;margin-left:30px;width:200px;">Página da equipe</div>
          <input type="checkbox" <? if($checked2 == true) { echo 'checked="checked"'; } ?> id="c2-<?=$sql5['id'];?>" name="c2-<?=$sql5['id'];?>" type="checkbox">
          <br><br>
          <? } } ?>
          </div>
        </div>

        <div class="form-group form-submit">
          <label class="col-lg-2 control-label"></label>

          <input type="hidden" name="form_processa" value="s" />
          <div class="col-lg-10"><button type="submit" class="btn btn-success">Enviar</button></div>
        </div>
      </form>
    </div>
</div>
<? }
if($_GET['a'] == 2) {
  $id = anti_injecao($_GET['id']);
  if($_POST['form_processa'] == 's') {
    extract($_POST);
    $nick = clear_mysql($_POST['nick']);
    $nome = clear_mysql($_POST['nome']);
    $senha = 'HITS-acp-' . strtolower(base64_encode('$nick' . time()));
    $senha = clear_mysql($_POST['senha']);
    $senha_md5 = md5($senha);
    $prosseguir = true;
    
    if($nick == '') {
      notificar("Digite um nick","red");
      $prosseguir = false;
    }

    if($senha != '') {
      $senha = md5($senha);
      mysql_query("UPDATE acp_usuarios SET senha='$senha' WHERE id='$id' LIMIT 1");
      notificar("Senha alterada!", "yellow");
    }

    if($prosseguir == true) {
      $cargos = '';
      $cargos_e = '';
      
      $sql8 = mysql_query("SELECT * FROM acp_usuarios WHERE id='".$_SESSION['acp_id']."' LIMIT 1");
      $sql9 = mysql_fetch_array($sql8);
      $carggs = $sql9['cargos'];
      
      $sql9['cargos'] = explode('|', $sql9['cargos']);
      
      $sql10 = mysql_query("SELECT * FROM cargos");
      while($sql11 = mysql_fetch_array($sql10)) {
        foreach($sql9['cargos'] as $car_atual) { // Para cada cargo que o $_SESSION [nick] tiver
          if($car_atual == $sql11['nome']) { $autorizado = true; }
        }

        if(strstr(strtolower($carggs), "webmaster") || strstr(strtolower($carggs), "administrador")) {
          $autorizado = true;
        }
        
        if($autorizado == true) {
          $id_cargo = $sql11['id'];
          if($_POST["c-$id_cargo"] == 'on') { $cargos .= $sql11['nome'] . '|'; }
          if($_POST["c2-$id_cargo"] == 'on') { $cargos_e .= $sql11['nome'] . '|'; }
        }
      }

      mysql_query("UPDATE acp_usuarios SET nick='$nick', cargos='$cargos', cargos_e='$cargos_e' WHERE id='$id' LIMIT 1") or die(mysql_error());

      logger("O usuário editou o usuário #$id ($nick)", "acao");
      notificar("Sucesso!","blue");
    }
  }

  $sql3 = mysql_query("SELECT * FROM acp_usuarios WHERE id='$id' LIMIT 1");
  $ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
    <div class="panel-body">
      <form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
        <button type="button" class="btn btn-warning" onclick="advert(this);" rel="?p=<?=$_GET['p'];?>&a=5&id=<?=$ex['id'];?>">Advertir</button>
        <a href="?p=9&u=<?=$ex['id'];?>" class="btn btn-success">Logs</a><br>
        <br><br>

        <?=$form_return;?>
        <? if($ex['advert'] != 0) { echo aviso_red("O usuário possui <b>".$ex['advert']."</b> advertências.");} ?>

        <div class="well">
          <b>Último acesso:</b> <?=date('d/m/y H:i', $ex['acesso_data']);?><br>
          <b>Último IP registrado:</b> <?=$ex['acesso_ip'];?><br>
          <b>Criador desta conta:</b> <?=$ex['autor'];?><br>
          <b>Data de criação:</b> <?=date('d/m/y H:i', $ex['data']);?><br>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Nick</label>
          <div class="col-lg-3"><input type="text" name="nick" class="form-control input-sm" value="<?=$ex['nick'];?>"></div><br>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Nome</label>
          <div class="col-lg-3"><input type="text" name="nome" class="form-control input-sm" value="<?=$ex['nome'];?>"></div><br>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Nova senha</label>
          <div class="col-lg-10"><input type="password" name="senha" class="form-control input-sm" placeholder="Somente se você quiser mudar a atual"></div><br>
        </div>


        <hr>

        <div class="well">Você deve selecionar o cargo do usuário e todos os outros cargos que este usuário gerencia. Exemplo: se ele for um Coordenador de Conteúdo, então selecione: Coordenador de Conteúdo, Jornalista, Tradutor, Colunista, etc. Tudo o que for relacionado ao conteúdo.</div>
        <div class="well">Se você tiver alguma dúvida sobre isso, não adicione nenhum usuário. Peça ajuda.</div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Cargos</label>
          <div class="col-lg-10">
        <? $sql4 = mysql_query("SELECT * FROM cargos ORDER BY id ASC");
        while($sql5 = mysql_fetch_array($sql4)) {
          $show = false;
          $sql6 = mysql_query("SELECT * FROM usuarios WHERE id='".$_SESSION['id']."' LIMIT 1");
          $sql7 = mysql_fetch_array($sql6);
          $sql7['cargos'] = explode('|', $sql7['cargos']);
          foreach($sql7['cargos'] as $car_atual) { // Para cada cargo que o $_SESSION [nick] tiver
            if($car_atual == $sql5['nome'] && $stop != true) { $show = true; }
            if($car_atual == 'Administrador' || $car_atual = 'CEO') { $show = true; $stop = true; } /* Se o cara for admin ele exibe os cargos e pronto, foda-se o resto */
          } 

          $check = explode('|', $ex['cargos']);
          $checked = false;
          $checked2 = false;

          foreach($check as $car_atuall) { // Para cada cargo que o usuário a ser editado tiver
            if($car_atuall == $sql5['nome']) { $checked = true; }
          } 

          if($sql5['nome'] == 'Usuário') { $show = false;}

          /* Cargos na página da equipe */
          $a = explode('|', $ex['cargos_e']);

          foreach($a as $c) { // Para cada cargo da pág equipe que o usuário a ser editado tiver
            if($c == $sql5['nome']) { $checked2 = true;}
          }

          if($show == true) { ?>
          <div style="font-weight:bold;display:inline-block;margin:5px;width:210px;"><?=$sql5['nome'];?></div>
          <input type="checkbox" <? if($checked == true) { echo 'checked="checked"'; } ?> id="c-<?=$sql5['id'];?>" name="c-<?=$sql5['id'];?>" type="checkbox">
          <div style="font-weight:bold;display:inline-block;margin:5px;margin-left:30px;width:200px;">Página da equipe</div>
          <input type="checkbox" <? if($checked2 == true) { echo 'checked="checked"'; } ?> id="c2-<?=$sql5['id'];?>" name="c2-<?=$sql5['id'];?>" type="checkbox">
          <br><br>
          <? } } ?>
          </div>
        </div>

        <div class="form-group form-submit">
          <label class="col-lg-2 control-label"></label>

          <input type="hidden" name="form_processa" value="s" />
          <div class="col-lg-10"><button type="submit" class="btn btn-success">Enviar</button></div>
        </div>
      </form>
    </div>
</div>
<? }

if($_GET['a'] == 3) {
	$id = anti_injecao($_GET['id']);
	mysql_query("DELETE FROM acp_usuarios WHERE id='$id' LIMIT 1");
  logger("O usuário deletou uma conta (#$id)", "acao");
}


if($_GET['a'] == 5) {
	$id = anti_injecao($_GET['id']);
	$sql3 = mysql_query("SELECT * FROM usuarios WHERE id='$id' LIMIT 1");
	$ex = mysql_fetch_array($sql3);
	
	$new = $ex['advert']+1;
	mysql_query("UPDATE acp_usuarios SET advert='$new' WHERE id='$id' LIMIT 1");
  logger("O usuário deu uma advertência ao usuário de ID #$id", "acao");
}

if($_GET['a'] == '') { ?>
<div class="panel panel-primary">
  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
  <div class="panel-body">
    <a href="?p=<?=$_GET['p'];?>&a=1" class="btn btn-success">Adicionar</a>
    <a href="?p=<?=$_GET['p'];?>" class="btn btn-danger">Exibir todos</a>
    <br><br>
    <form action="?p=<?=$_GET['p'];?>" method="post" class="bs-example form-horizontal">
      <div class="form-group"><input type="text" class="form-control" id="nick" name="nick" placeholder="Pesquisar por nick"></div>
      <input type="hidden" name="form_processa" value="s">
      <button type="submit" class="btn btn-primary">Buscar</button> 
    </form>
    <br>

    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Nick</th>
          <th>Último acesso</th>
          <th>IP</th>
          <th>Opções</th>
        </tr>
      </thead>
      <tbody>
        <? $limite = 10;
        $pagina = $_GET['pag'];
        ((!$pagina)) ? $pagina = 1 : '';
        $inicio = ($pagina * $limite) - $limite;

        $query = "acp_usuarios ORDER BY id DESC";

        if($_POST['nick'] != '' && $_POST['form_processa'] == 's') {
          $busca_nick = clear_mysql($_POST['nick']);
          $query = "acp_usuarios WHERE nick='$busca_nick' ORDER BY id DESC";
          $sql_ = mysql_query("SELECT * FROM $query");

          if(mysql_num_rows($sql_) == 0) {
            $query = "acp_usuarios WHERE nick LIKE '%".$busca_nick."%' ORDER BY id DESC";
          }
        }

        $sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
        while($sql2 = mysql_fetch_array($sql)) {
          $ca = explode('|', $sql2['cargos_e']);
          $cargos = '';

          foreach($ca as $atual) {
            $cargos .= $atual . ', ';
          }
          ?>
          <tr>
            <td><?=$sql2['id'];?></td>
            <td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
            <td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nick'], 60));?></a></td>
            <td><?=date('d/m/y H:i', $sql2['acesso_data']);?></td>
            <td><?=$sql2['acesso_ip'];?></td>
            <td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><button type="button" class="btn btn-warning btn-xs">Editar</button></a>
              <button type="button" class="btn btn-danger btn-xs" onclick="deletar(this);" rel="?p=<?=$_GET['p'];?>&a=3&id=<?=$sql2['id'];?>">Deletar</button>
            </td>
          </tr>
          <? } ?>
          <? if(mysql_num_rows($sql) == 0) {
            echo aviso_red("Nenhum registro.");
          } ?>
        </tbody>
      </table>

      <ul class="pagination">
        <? $consulta = mysql_query("SELECT id FROM $query");
        $total_registros = mysql_num_rows($consulta);

        $total_paginas = ceil($total_registros / $limite);

        $links_laterais = ceil($limite / 2);

        $inicio = $pagina - $links_laterais;
        $limite = $pagina + $links_laterais;

        for ($i = $inicio; $i <= $limite; $i++){
          if ($i == $pagina) {
            echo '<li class="active"><a href="#">'.$i.'</a></li>';
          } else {
            if ($i >= 1 && $i <= $total_paginas){
              $link = '?' . $_SERVER["QUERY_STRING"];
              $link = ereg_replace('&pag=(.*)', '', $link);
              echo '<li><a href="'.$link.'&pag='.$i.'">'.$i.'</a></li>';
            }
          }
        }
        ?>
      </ul>
    </div>
  </div>
  <? } ?>