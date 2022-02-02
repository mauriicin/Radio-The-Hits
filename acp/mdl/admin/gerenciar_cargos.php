<? if($permissoes[6] == 'n') { erro404(); die(); }

if($_GET['a'] == 1) {
  if($_POST['form_processa'] == 's') {
    $nome = clear_mysql($_POST['nome']);
    $oculto = clear_mysql($_POST['oculto']);
    extract($_POST);
    $prosseguir = true;

    if($oculto == 'on') { $oculto = 's'; } else { $oculto = 'n'; }
    if($oculto != 's' && $oculto != 'n') { $oculto = 'n'; }
    
    $i = 0;
    $per = '';
    while($i < 25) {
      if($_POST["p-$i"]) { $_POST["p-$i"] = 's'; } else { $_POST["p-$i"] = 'n'; }
      $per .= $_POST["p-$i"] . '|';
      $i++;
    }
  
    if($nome == '') {
      notificar("Digite um nome.","red");
    }
    
    if($prosseguir == true) {
      mysql_query("INSERT INTO cargos (nome, permissoes, autor, data, oculto) VALUES ('$nome', '$per', '$autor', '$timestamp', '$oculto')");
      logger("O usuário adicionou um novo cargo [$nome]", "acao");

      notificar("Sucesso!","blue");
      foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
    }
  } ?>
<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
    <div class="panel-body">
      <form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
        <?=$form_return;?>

        <div class="form-group">
          <label class="col-lg-2 control-label">Nome</label>
          <div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=$_POST['nome'];?>"></div><br>
        </div>

        <div class="well">Cargos ocultos não aparecerem na página da equipe.</div>

        <div class="form-group">
          <label class="col-lg-2 control-label"></label>
          <div class="col-lg-2">
            <input type="checkbox" <? if($_POST['oculto'] == 's') { echo 'checked="checked"'; } ?> name="oculto">
            <div style="font-weight:bold;padding:5px;display:inline-block;">Cargo oculto</div>
          </div><br>
        </div>

        <div class="well">
          <? function montar($pi, $pii, $a) {
            if($a == 1) {
              $checked = 'checked="checked"';
            } else {
              $checked = '';
            }

            echo '<div class="form-group"><label for="p-'.$pi.'" class="col-lg-6 control-label">'.$pii.'</label>
            <input type="checkbox" '.$checked.' id="p-'.$pi.'" name="p-'.$pi.'" type="checkbox"></div>';
          } ?>
          <?
          $i=0;if($permissoes[$i] == 's') { montar($i, 'ACESSO AO PAINEL DE CONTROLE', 0); }

          $i=1;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > CONFIGURAÇÕES GERAIS', 0); }
          $i=2;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > GERENCIAR AVISOS', 0); }
          $i=3;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > EMITIR ALERTA', 0); }
          $i=4;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > LOGS', 0); }
          $i=5;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > CONTAS', 0); }
          $i=6;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > CARGOS', 0); }
          $i=7;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > PEDIDOS PRA ENTRAR NA EQUIPE', 0); }
          $i=8;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > SLIDE', 0); }
          $i=9;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > MÚSICAS EM DESTAQUE', 0); }
          $i=10;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > PÁGINAS', 0); }
          $i=23;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > MENU', 0); }
          $i=24;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > SUB-MENU', 0); }
          $i=11;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > ARTISTAS', 0); }
          $i=12;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > ÁLBUNS', 0); }
          $i=13;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > MÚSICAS', 0); }
          $i=14;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > PLAYLISTS', 0); }
          $i=22;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > TOP 10', 0); }
          $i=15;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > NOTÍCIAS', 0); }
          $i=16;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > NOTÍCIAS > POSTAR SEM REVISÃO', 0); }
          $i=17;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > NOTÍCIAS > POSTAR COMO FIXO', 0); }
          $i=18;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > CATEGORIAS', 0); }
          $i=19;if($permissoes[$i] == 's') { montar($i, 'RÁDIO > INICIAR PROGRAMA', 0); }
          $i=20;if($permissoes[$i] == 's') { montar($i, 'RÁDIO > PEDIDOS', 0); }
          $i=21;if($permissoes[$i] == 's') { montar($i, 'RÁDIO > GRADE DE PROGRAMAÇÃO', 0); }
          ?>
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
    $nome = clear_mysql($_POST['nome']);
    $oculto = clear_mysql($_POST['oculto']);
    extract($_POST);
    $prosseguir = true;

    if($oculto == 'on') { $oculto = 's'; } else { $oculto = 'n'; }
    if($oculto != 's' && $oculto != 'n') { $oculto = 'n'; }
    
    $i = 0;
    $per = '';
    while($i < 25) {
      if($_POST["p-$i"]) { $_POST["p-$i"] = 's'; } else { $_POST["p-$i"] = 'n'; }
      $per .= $_POST["p-$i"] . '|';
      $i++;
    }

    if($nome == '') {
      notificar("Digite um nome.","red");
      $prosseguir = false;
    }
    
    if($prosseguir == true) {
      mysql_query("UPDATE cargos SET nome='$nome', permissoes='$per', oculto='$oculto' WHERE id='$id' LIMIT 1");
      logger("O usuário editou o cargo [$nome - #$id]", "acao");

      notificar("Success!","blue");
      foreach($_POST as $nome_campo => $valor){ $_POST[$nome_campo] = '';} 
    }
  }
  
  $sql3 = mysql_query("SELECT * FROM cargos WHERE id='$id' LIMIT 1");
  $ex = mysql_fetch_array($sql3); ?>
<div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
    <div class="panel-body">
      <form action="<?=$_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
        <?=$form_return;?>

        <div class="form-group">
          <label class="col-lg-2 control-label">Nome</label>
          <div class="col-lg-10"><input type="text" name="nome" class="form-control input-sm" value="<?=$ex['nome'];?>"></div><br>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label"></label>
          <div class="col-lg-2">
            <input type="checkbox" <? if($ex['oculto'] == 's') { echo 'checked="checked"'; } ?> name="oculto">
            <div style="font-weight:bold;padding:5px;display:inline-block;">Cargo oculto</div>
          </div><br>
        </div>

        <div class="well">
          <? function montar($pi, $pii, $a) {
            if($a == 1) {
              $checked = 'checked="checked"';
            } else {
              $checked = '';
            }

            echo '<div class="form-group"><label for="p-'.$pi.'" class="col-lg-6 control-label">'.$pii.'</label>
            <input type="checkbox" '.$checked.' id="p-'.$pi.'" name="p-'.$pi.'" type="checkbox"></div>';
          } ?>
          <? $a = explode('|', $ex['permissoes']);

          $i=0;if($permissoes[$i] == 's') { montar($i, 'ACESSO AO PAINEL DE CONTROLE', (($a[$i]=='s'))? 1 : 0); }

          $i=1;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > CONFIGURAÇÕES GERAIS', (($a[$i]=='s'))? 1 : 0); }
          $i=2;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > GERENCIAR AVISOS', (($a[$i]=='s'))? 1 : 0); }
          $i=3;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > EMITIR ALERTA', (($a[$i]=='s'))? 1 : 0); }
          $i=4;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > LOGS', (($a[$i]=='s'))? 1 : 0); }
          $i=5;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > CONTAS', (($a[$i]=='s'))? 1 : 0); }
          $i=6;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > CARGOS', (($a[$i]=='s'))? 1 : 0); }
          $i=7;if($permissoes[$i] == 's') { montar($i, 'ADMINISTRAÇÃO > PEDIDOS PRA ENTRAR NA EQUIPE', (($a[$i]=='s'))? 1 : 0); }
          $i=8;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > SLIDE', (($a[$i]=='s'))? 1 : 0); }
          $i=9;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > MÚSICAS EM DESTAQUE', (($a[$i]=='s'))? 1 : 0); }
          $i=10;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > PÁGINAS', (($a[$i]=='s'))? 1 : 0); }
          $i=23;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > MENU', (($a[$i]=='s'))? 1 : 0); }
          $i=24;if($permissoes[$i] == 's') { montar($i, 'CONTEÚDO > SUB-MENU', (($a[$i]=='s'))? 1 : 0); }
          $i=11;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > ARTISTAS', (($a[$i]=='s'))? 1 : 0); }
          $i=12;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > ÁLBUNS', (($a[$i]=='s'))? 1 : 0); }
          $i=13;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > MÚSICAS', (($a[$i]=='s'))? 1 : 0); }
          $i=14;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > PLAYLISTS', (($a[$i]=='s'))? 1 : 0); }
          $i=22;if($permissoes[$i] == 's') { montar($i, 'PLAYHITS > TOP 10', (($a[$i]=='s'))? 1 : 0); }
          $i=15;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > NOTÍCIAS', (($a[$i]=='s'))? 1 : 0); }
          $i=16;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > NOTÍCIAS > POSTAR SEM REVISÃO', (($a[$i]=='s'))? 1 : 0); }
          $i=17;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > NOTÍCIAS > POSTAR COMO FIXO', (($a[$i]=='s'))? 1 : 0); }
          $i=18;if($permissoes[$i] == 's') { montar($i, 'NOTÍCIAS > CATEGORIAS', (($a[$i]=='s'))? 1 : 0); }
          $i=19;if($permissoes[$i] == 's') { montar($i, 'RÁDIO > INICIAR PROGRAMA', (($a[$i]=='s'))? 1 : 0); }
          $i=20;if($permissoes[$i] == 's') { montar($i, 'RÁDIO > PEDIDOS', (($a[$i]=='s'))? 1 : 0); }
          $i=21;if($permissoes[$i] == 's') { montar($i, 'RÁDIO > GRADE DE PROGRAMAÇÃO', (($a[$i]=='s'))? 1 : 0); }
          ?>
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
  mysql_query("DELETE FROM cargos WHERE id='$id' LIMIT 1");
  logger("O usuário deletou o cargo [$id]", "acao");

}

if($_GET['a'] == '') { ?>
<div class="panel panel-primary">
  <div class="panel-heading"><h3 class="panel-title"><?=$mdl['title'];?></h3></div>
  <div class="panel-body">
    <a href="?p=<?=$_GET['p'];?>&a=1" class="btn btn-success">Adicionar</a><br><br>
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nome</th>
          <th>Autor</th>
          <th>Data</th>
          <th>Opções</th>
        </tr>
      </thead>
      <tbody>
        <? $limite = 10;
        $pagina = $_GET['pag'];
        ((!$pagina)) ? $pagina = 1 : '';
        $inicio = ($pagina * $limite) - $limite;

        $query = "cargos WHERE nome!='Usuário' ORDER BY id DESC";
        $sql = mysql_query("SELECT * FROM $query LIMIT $inicio,$limite");
        while($sql2 = mysql_fetch_array($sql)) { ?>
        <tr>
          <td><?=$sql2['id'];?></td>
          <td><a href="?p=<?=$_GET['p'];?>&a=2&id=<?=$sql2['id'];?>"><?=clear(encurtar($sql2['nome'], 60));?></a></td>
          <td><?=$sql2['autor'];?></td>
          <td><?=date('d/m/y H:i', $sql2['data']);?></td>
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