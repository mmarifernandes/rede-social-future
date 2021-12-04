<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FEED</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    $db = new SQLite3("future.db");
    $db->exec("PRAGMA foreign_keys = ON");

  if(isset($_GET['email']) && $_GET['email'] != null) {
    $login = $_GET['email'];
    $nome = $login;
    echo $nome;

    echo '<div class="container-box">';
    echo '<header class="header"></header>';
    echo '<main class="main">';

// ME INTERESSA
    echo '<section class="menu">';
    if(isset($_POST["descricao"])) {
      $var;
      foreach($_POST as $indice => $item) {
          if($indice == "pagina") {
              $var = "pagina";
              $valor = $_POST[$indice];
              break;
          }else if($indice == "grupo") {
              $valor = $_POST[$indice];
              $var = "grupo";
              break;
          }
      }
      $testenome = $db->query("select nome from $var where nome = '$valor'")->fetchArray()['nome'];
      if($testenome == null || $testenome != $valor) {
          $db->exec("insert into $var (nome, descricao) values ('".$valor."','".$_POST["descricao"]."')");
          $codigogrupag = $db->query("select codigo from $var where nome = '$valor'")->fetchArray()['codigo'];
          // VALIDAR SE ESTÁ ERRADO OU NÃO
          $db->exec("insert into ".$var."_usuario (usuario, $var, adm) values ('".$_POST["usuario"]."', $codigogrupag, 1)");
          // PROBLEMA COM A CHAVE ESTRANGEIRA (não aceita usuarios naõ existentes)
          echo " $var criado com sucesso";
      }else {
          header('Location: /feed.php?email='.$login.'&error=nome ja existente');
      }
    }
    if(isset($_GET['excluir'])) {
      $arrayexcluir = explode('_',$_GET['excluir']);
      $codigoitem = $arrayexcluir[0];
      $item = $arrayexcluir[1];
      $db->exec("update ".$item."_usuario set ativo = 0 where $item = $codigoitem and usuario = '$login'");
    }
    if(isset($_POST['campo']) && isset($_POST['pesquisa'])) {
      $selectpesquisa = $db->query("select nome, codigo from ".$_POST['pesquisa']." where nome like '%".$_POST['campo']."%'");
      $arraypesquisa = [];
      $cont = 0;
      while($rowpesquisa = $selectpesquisa->fetchArray()) {
        $arraypesquisa[$cont] = $rowpesquisa['nome'];
        $cont++;
        $arraypesquisa[$cont] = $rowpesquisa['codigo'];
        $cont++;
      }
    }
    if(isset($_GET['error'])) {
      echo "<h5>".$_GET['error']."</h5>";
    }
    echo "<h3>Criar Grupo ou Página</h3>";
    echo "<button onclick=\"paginaGrupo('grupo', '".$login."')\">Grupo</button>";
    echo "<button onclick=\"paginaGrupo('pagina', '".$login."')\">Pagina</button>";
    echo "<div id=\"formulario\"></div>";
    echo "<div><h3>Meus Grupos</h3></div>";
    $meusgrupos = $db->query("select grupo.nome, grupo.codigo from grupo join grupo_usuario on grupo_usuario.grupo = grupo.codigo join usuario on usuario.email = grupo_usuario.usuario where usuario.email = '".$login."' and grupo_usuario.ativo = 1");
    while($row = $meusgrupos->fetchArray()) {
      echo $row['nome']. ' <a href="feed.php?email='.$login.'&excluir='.$row['codigo'].'_grupo">Sair</a> <br>';
    }
    echo "<div><h3>Minhas páginas</h3></div>";
    $minhaspaginas = $db->query("select pagina.nome, pagina.codigo from pagina join pagina_usuario on pagina_usuario.pagina = pagina.codigo join usuario on usuario.email = pagina_usuario.usuario where usuario.email = '".$login."' and pagina_usuario.ativo = 1");
    while($row2 = $minhaspaginas->fetchArray()) {
      echo 'teste';
      echo $row2['nome']. ' <a href="feed.php?email='.$login.'&excluir='.$row2['codigo'].'_pagina">Sair</a> <br>';
    }
    echo "<div><h3>Procurar</h3></div>";
    echo "<div class='divprocura'>
    <form action='feed.php?email=$login' method='post'>
    <select name='pesquisa'>
    <option value='grupo'>Grupo</option>
    <option value='pagina'>Pagina</option>
    </select>
    <input name='campo'>
    <button type='submit'>Pesquisar</button>
    </form>
    <br>
    </div>";
    if(isset($arraypesquisa) && $arraypesquisa!= null) {
      echo "<table>";
      for($contp = 0; $contp < count($arraypesquisa); $contp = $contp +2) {
        echo "<tr><td>".$arraypesquisa[$contp]."</td><td>Entrar/Sair</td></tr>";
      }
      echo "</table>";
    }

    echo '</section>';
















// NÃO ME INTERESSA
    echo '<section class="feed">';
  
    echo '<div id = postar>';
    echo '<div id = nome>';
    echo 'select nome from usuario where email = '.'"'.$login.'"'.'';
    $results1 = $db->query('select nome from usuario where email = '.'"'.$login.'"'.'');
    while ($row = $results1->fetchArray()) {
      echo ucfirst(strtolower($row['nome']));
    }
    echo '</div>';
    
    echo '<form name="formpost" method="post" action="#">';
    echo '<select id="selectassuntos" name="selectassuntos">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row = $results4->fetchArray()) {
		echo "<option value=\"".$row["codigo"]."\">".strtolower($row["nome"])."</option>\n";
	}
	echo '</select>';
  echo'<input type="button" id = "mais" value="+" onclick="add();">';
  echo'<input type="hidden" id = "array" name ="array">';

  echo '<div id="add"></div>';
    echo '<textarea id="conteudo" name="conteudo" rows="4" cols="90" placeholder = "O que você está pensando?">';
    echo '</textarea>';
    
    echo '<button name="postar" type="submit">Publicar</button>';
    echo '</form>';
    echo '</div>';
    
    
    $results = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'POST' order by data desc");
    while ($row = $results->fetchArray()) {
      
      $results3 = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'COMENTARIO' and referencia = ".$row["codigo"]."");
      $results5 = $db->query("select group_concat(assunto.nome, ', ') as assunto from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = ".$row["codigo"]);
      $results7 = $db->query("select usuario.nome as usuarionome from interacao join usuario on usuario.email = interacao.usuario where tipo = 'CURTIR' and referencia =".$row["codigo"]);
      $results8 = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario, referencia from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'COMPARTILHAMENTO' and referencia =".$row["codigo"]." order by data desc");

 while ($row8 = $results8->fetchArray()) {
        $results9 = $db->query("select usuario.nome as usuarionome from interacao join usuario on usuario.email = interacao.usuario where tipo = 'CURTIR' and referencia =".$row8["codigo"]);

   echo '<div id="post" name='.$row8["codigo"].'>';
   echo $row8["usuario"]. ' compartilhou';
      

	
    echo '<div id = nome>';
    echo ucfirst(strtolower($row["usuario"]));
    echo '<div id = data>';
    echo $row["data"];
      while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '</div>';
    
    echo '</div>';
   
  
    echo '<div id = conteudo>';
    echo $row["conteudo"];
    echo '</div>';

    

 echo '<form name="formcurtir" method="post" action="#">';
    echo '<div id = reactions>';

     echo '<button type="submit" name="curtir">Curtir</button>';
	echo '<input type="hidden" name="codigocoment2" value="'.$row8["codigo"].'">';

  echo '<select id="selectassuntoscoment" name="selectassuntoscoment">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row4 = $results4->fetchArray()) {
		echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	}
	echo '</select>';
  echo'<input type="button" id = "maiscoment" value="+" onclick="add1();">';
  while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '<div id="add1"></div>';

  echo'<input type="hidden" id = "array1" name ="array1">';

// echo '<p>Deseja marcar alguém?</p>';
    echo '</form>';
    echo '</div>';
  while ($row9 = $results9->fetchArray()) {
    echo $row9["usuarionome"]. ' curtiu'. '<br>';

    }
    echo '</div>';

  }

      echo '<div id="post" name='.$row["codigo"].'>';
      echo $row["codigo"];

    $id = $row['codigo'];	
    echo '<div id = nome>';
    echo ucfirst(strtolower($row["usuario"]));
    echo '<div id = data>';
    echo $row["data"];
      while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '</div>';
    
    echo '</div>';
   
  
    echo '<div id = conteudo>';
    echo $row["conteudo"];
    echo '</div>';


    echo '<form name="formcurtir" method="post" action="#">';
    echo '<div id = reactions>';

     echo '<button type="submit" name="curtir">Curtir</button>';
	echo '<input type="hidden" name="codigocoment2" value="'.$row["codigo"].'">';

  echo '<select id="selectassuntoscoment" name="selectassuntoscoment">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row4 = $results4->fetchArray()) {
		echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	}
	echo '</select>';
  echo'<input type="button" id = "maiscoment" value="+" onclick="add1();">';
  while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '<div id="add1"></div>';

  echo'<input type="hidden" id = "array1" name ="array1">';

    echo '</form>';
    echo '</div>';

    echo '<form name="formccompartilhar" method="post" action="#">';
    echo '<div id = compartilhar>';

    echo '<button type="submit" name="compartilhar">Compartilhar</button>';
  	echo '<input type="hidden" name="codigocoment3" value="'.$row["codigo"].'">';
    echo '</div>';

    echo '</form>';
    


      while ($row7 = $results7->fetchArray()) {
    echo $row7["usuarionome"]. ' curtiu'. '<br>';
    
  }
    echo '<div id = coment>';

    echo '<form name="formcomment" method="post" action="#">';
    echo '<input type="hidden" name="codigocoment" value="'.$row["codigo"].'">';
    
    echo '<textarea id="comentario" name="conteudocomentario" rows="4" cols="90" placeholder = "Escreva algo">';
    echo '</textarea>';
    
    echo '<button name = "comentar"type="submit">Comentar</button>';
    echo '</form>';

    echo '</div>';
    // echo '<br>';
    while ($row3= $results3->fetchArray()) {
      
      echo '<div id="comentarios" name='.$row3["codigo"].'>';
      echo '<div id = nome>';
      echo ucfirst(strtolower($row3["usuario"]));
      echo '<div id = data>';
      echo $row3["data"];
      echo '</div>';
      echo '</div>';
      echo $row3["conteudo"];
      
      echo '<div id = reactions>';
      echo '<button id="myBtn">Curtir</button>';
      echo '<div id="myModal" class="modal">';
      echo '<div class="modal-content">';
      echo '<span class="close">&times;</span>';
      echo '<p>Some text in the Modal..</p>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '<div id = coment>';
      
      echo '<form name="formcomment" method="post" action="#">';
      echo '<input type="hidden" name="codigocoment" value="'.$row3["codigo"].'">';
      // echo $_POST['codigocoment'];
      echo '<textarea id="comentario" name="conteudocomentario" rows="2" cols="70" placeholder = "Escreva algo">';
      echo '</textarea>';
      
      echo '<button name = "comentar"type="submit">Comentar</button>';
      echo '</form>';
      
    echo '</div>';
    $results6 = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'COMENTARIO' and referencia = ".$row3["codigo"]."");
    while ($row6 = $results6->fetchArray()) {
    
    echo '<div id="comentarios2" name='.$row6["codigo"].'>';
    echo '<div id = nome>';
    echo ucfirst(strtolower($row6["usuario"]));
    echo '<div id = data>';
    echo $row6["data"];
    echo '</div>';
    echo '</div>';
    echo $row6["conteudo"];
    
    echo '<div id = reactions>';
    echo '<button id="myBtn">Curtir</button>';
    echo '<div id="myModal" class="modal">';
    echo '<div class="modal-content">';
    echo '<span class="close">&times;</span>';
    echo '<p>Some text in the Modal..</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div id = coment>';
    
    echo '<form name="formcomment" method="post" action="#">';
    echo '<input type="hidden" name="codigocoment" value="'.$row6["codigo"].'">';
    
    echo '<textarea id="comentario" name="conteudocomentario" rows="2" cols="70" placeholder = "Escreva algo">';
    echo '</textarea>';
    
    echo '<button name = "comentar"type="submit">Comentar</button>';
    echo '</form>';
    
    echo '</div>';
    echo '</div>';
    
  }
    echo '</div>';
    
  }
  echo '</div>';
}
echo '</section>';
echo '<section class="event"></section>';
echo '</main>';
echo '</div>';

$total = $db->query("select count(*) as total from interacao")->fetchArray()["total"];
if (isset($_POST['postar'])){
  $x = $_POST['array'];
  $valores = explode(",",$x);
  echo $x;
  $total++;
  $post_content  = $_POST['conteudo'];
  $db->exec("insert into interacao (codigo, usuario, tipo, cidade, conteudo) values ($total, '".$login."', 'POST',  1, '".$post_content."')");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
if (!empty($_POST['array'])){
	for($i=0;$i<count($valores);$i++){
					// echo $valores[$i];
					$db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
			}
}
}
if (isset($_POST['comentar'])){
  $total++;
  $comment_content  = $_POST['conteudocomentario'];
  $db->exec("insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values ($total, '".$login."', 'COMENTARIO', 1, '".$comment_content."', ".$_POST['codigocoment'].")");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
}
if (isset($_POST['curtir'])){
  echo 'asdad';
  $total++;
  $x = $_POST['array1'];
  $valores = explode(",",$x);
  $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '".$login."', 'CURTIR', 1, ".$_POST['codigocoment2'].")");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
if (!empty($_POST['array1'])){
	for($i=0;$i<count($valores);$i++){
					// echo $valores[$i];
					$db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
			}
}
}					
if (isset($_POST['compartilhar'])){
  $total++;
  $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '".$login."', 'COMPARTILHAMENTO', 1, ".$_POST['codigocoment3'].")");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
}	

  }else {
      echo 'erro ao entrar no feed, faça login novamente';
    }
  $db->close();
?>
      
</body>

<!-- JAVASCRIPT -->
<script src="script.js"></script>
</html>