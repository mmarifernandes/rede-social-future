<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <!-- estilos css -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <script>
        function verificaPattern() {
            if (document.getElementById("grupo") != undefined) {
                var nome = document.getElementById("grupo");
            }
            let padrao = new RegExp(nome.pattern);
            if (!padrao.test(nome.value)) {
                alert('Nome no formato inválido');
            } else {
                document.getElementById("form").submit();
            }
        }
    </script>
    <?php
        // abre o acesso ao banco de dados
        $db = new SQLite3("future.db");
        $db->exec("PRAGMA foreign_keys = ON");

        // só permite acesso ao feed se existir um usuário
        if(isset($_GET['email']) && $_GET['email'] != null) {

            $login = $db->query("select email from usuario where email like '".$_GET['email']."'")->fetchArray()["email"];
            if(isset($login)) {
                $nome = $login;

                function url($campo, $valor, $login, $vfinal = '') {
                    $result = array();
                    if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
                    if (isset($_GET["ordeby"])) $result["ordeby"] = "ordeby=".$_GET["ordeby"];
                    if (isset($_GET["ofset"])) $result["ofset"] = "ofset=".$_GET["ofset"];
                    if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
                    if ($vfinal != '') $result["vfinal"] = "vfinal=".$vfinal;
                    $result[$campo] = $campo."=".$valor;
                    return("feed.php?email=".$login."&".strtr(implode("&", $result), " ", "+"));
                }

                echo '<div class="container-box">';
                echo '<header class="header"></header>';
                echo '<main class="main">';
                echo '<section class="menu">';

                if (isset($_POST["descricao"])) {
                    $valor = strtoupper($_POST["grupo"]);
                    $testenome = $db->query("select nome from grupo where nome = '$valor'")->fetchArray()['nome'];
                    if ($testenome == null || $testenome != $valor) {
                        $db->exec("insert into grupo (nome, descricao) values ('" . $valor . "','" . $_POST["descricao"] . "')");
                        $codigogrupag = $db->query("select codigo from grupo where nome = '$valor'")->fetchArray()['codigo'];
                        $db->exec("insert into grupo_usuario (usuario, grupo, adm) values ('" . $_POST["usuario"] . "', $codigogrupag, 1)");
                        echo "Grupo criado com sucesso";
                    } else {
                        header('Location: /feed.php?email=' . $login . '&error=nome ja existente');
                    }
                }

                if (isset($_POST['campo']) || isset($_GET['vfinal'])) {
                    $camponovo = isset($_POST['campo']) ? $_POST['campo'] : isset($_GET['vfinal']);

                    $camponovo = $camponovo == '*' ? ' ' : $camponovo;
                    if($camponovo == ' ') {
                        $newtotal = $db->query("select count(*) as total from grupo where ativo = 1")->fetchArray()['total'];
                    }else {
                        $newtotal = $db->query("select count(*) as total from grupo where nome like '%" . $camponovo . "%' AND ativo = 1")->fetchArray()['total'];
                    }
                    $ordeby = (isset($_GET["ordeby"])) ? $_GET["ordeby"] : "nome asc";
                    $limit = 5;
                    $ofset = (isset($_GET["ofset"])) ? max(0, min($_GET["ofset"], $newtotal-1)) : 0;
                    $ofset = $ofset-($ofset%$limit); 
                    if($camponovo == ' ') {
                        $selectpesquisa = $db->query("select nome, codigo from grupo where ativo = 1 order by ". $ordeby. " limit ".$limit. " offset ". $ofset);
                    }else {
                        $selectpesquisa = $db->query("select nome, codigo from grupo where nome like '%" . $camponovo . "%' AND ativo = 1 order by ". $ordeby. " limit ".$limit. " offset ". $ofset);
                    }
                    $arraypesquisa = [];
                    $cont = 1;
                    while ($rowpesquisa = $selectpesquisa->fetchArray()) {
                        $arraypesquisa[$cont] = $rowpesquisa['nome'];
                        $cont++;
                        $arraypesquisa[$cont] = $rowpesquisa['codigo'];
                        $cont++;
                    }
                    $arraypesquisa[0] = $camponovo;
                }

                if (isset($_GET['error'])) {
                    echo "<h5>" . $_GET['error'] . "</h5>";
                }

                echo "<h3>Criar Grupo</h3>";
                echo "<div id=\"formulario\">";
                echo "<form id='form' action='feed.php?email=". $login . "' method='post'>";
                echo "<table><tr><td>Nome grupo: ";
                echo "<input type='text' id='grupo' name='grupo' maxlength='100' pattern='([a-zA-Z0-9]+ |[a-zA-Z0-9]+)+'>";
                echo "</td></tr><tr><td>Descrição:";
                echo "<textarea name='descricao' maxlength='200'></textarea>"; 
                echo "</td></tr><tr><td><input type='text' name='usuario' class='hidden' value='".$login."'>";
                echo "</td></tr><tr><td><button type='button' id='button' onclick='verificaPattern()' name='confirma'>Criar grupo</button>";
                echo "</td></tr></table></form>";


                echo "</div>";
                echo "<br><div><h3>Meus Grupos</h3></div>";

                $total = $db->query("select count(*) as total from grupo join grupo_usuario on grupo_usuario.grupo = grupo.codigo join usuario on usuario.email = grupo_usuario.usuario where usuario.email = '" . $login . "' and grupo_usuario.ativo = 1")->fetchArray()['total'];
                $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "nome asc";
                $limit = 5;
                $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
                $offset = $offset-($offset%$limit); 

                $meusgrupos = $db->query("select grupo.nome, grupo.codigo from grupo join grupo_usuario on grupo_usuario.grupo = grupo.codigo join usuario on usuario.email = grupo_usuario.usuario where usuario.email = '" . $login . "' and grupo_usuario.ativo = 1 order by grupo.".$orderby." limit ".$limit." offset ".$offset."");

                echo "<table border=1>";
                echo "<tr><td>Ordernar<a href='".url("orderby", "nome+asc", $login)."'>&#x25BE;</a><a href='".url("orderby", "nome+desc", $login)."'>&#x25B4;</a></td><tr>";
                while ($row = $meusgrupos->fetchArray()) {
                    echo "<tr><td><a href=\"pagina_grupo.php?valorgp=".$row['nome']."&login=".$login."\">" .ucfirst(strtolower($row['nome'])) . "</a></td></tr>";
                }

                echo "</table>";
                for ($page = 0; $page < ceil($total/$limit); $page++) {
                    echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit, $login)."\">".($page+1)."</a>")." \n";
                }

                echo "<div><h3>Procurar por Grupo</h3></div>";
                echo "<div class='divprocura'>";
                echo "<form action='feed.php?email=$login' method='post'>";
                echo "<input name='campo'>";
                echo "<button type='submit'>Pesquisar</button>";
                echo "</form>";
                echo "<br>";
                echo "</div>";

                // caso exista valores retornados da pesquisa imprime na tela, na parte do menu
                if (isset($arraypesquisa) && $arraypesquisa != null) {
                    $campo = $arraypesquisa[0] != '' ? $arraypesquisa[0] : '*';
                    echo "<br><table border=1>";
                    echo "<tr><td>Ordernar<a href='".url("ordeby", "nome+asc", $login, $campo)."'>&#x25BE;</a><a href='".url("ordeby", "nome+desc", $login, $campo)."'>&#x25B4;</a></td><tr>";
                    for ($contp = 1; $contp < count($arraypesquisa); $contp = $contp + 2) {
                        echo "<tr><td><a href=\"pagina_grupo.php?valorgp=".$arraypesquisa[$contp]."&login=".$login."\">" . $arraypesquisa[$contp] . "</a></td></tr>";
                    }
                    echo "</table>";
                    for ($page = 0; $page < ceil($newtotal/$limit); $page++) {
                        echo (($ofset == $page*$limit) ? ($page+1) : "<a href=\"".url("ofset", $page*$limit, $login, $campo)."\">".($page+1)."</a>")." \n";
                    }
                }
                echo '</section>';







































                // início do feed principal
                echo '<section class="feed">';
                echo '<div id = postar>';
                $results1 = $db->query('select usuario.nome as nome, cidade.nome as cidade, uf.nome as uf, pais.nome as pais from usuario join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where email = ' . '"' . $login . '"' . '');
                while ($row = $results1->fetchArray())
                {
                    echo '<div id = nome>';
                    echo ucwords(strtolower($row['nome']));
                    echo '</div>';
                    echo ucwords(strtolower($row['cidade']));
                    echo ', ';
                    echo ucwords(strtolower($row['uf']));
                    echo ', ';

                    echo ucwords(strtolower($row['pais']));

                }

                echo '<form name="formpost" method="post" action="#">';
                echo '<select id="selectassuntos" name="0">';
                $results4 = $db->query("select nome, codigo from assunto");
                while ($row = $results4->fetchArray())
                {
                    echo "<option value=\"" . $row["codigo"] . "\">" . strtolower($row["nome"]) . "</option>\n";
                }
                echo '</select>';
                echo '<input type="button" id = "mais" value="+" onclick="add();">';
                echo "<input type=\"button\" id = \"del\" name = \"delassuntos\" value=\"-\" onclick=\"tira1()\";>";

                echo '<input type="hidden" id = "array" name ="array">';

                echo '<div id="add"></div>';
                echo '<textarea id="conteudo" name="conteudo" rows="4" cols="90" style="max-width:100%;" placeholder = "O que você está pensando?">';
                echo '</textarea>';

                echo '<button name="postar" type="submit">Publicar</button>';
                echo '</form>';
                echo '</div>';
                // FIM


                //FEED
                $teste = $db->query("select a.codigo, usuario.email as email, a.conteudo, a.hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, usuario.nome as usuario, a.tipo as tipo, case when a.referencia is null then -1 else a.referencia end as referencia from interacao a join usuario on a.usuario = usuario.email left join interacao b on b.codigo = a.referencia join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where a.ativo = 1 group by a.codigo, a.referencia order by data desc;");
                // FIM
                // AQUI EH ONDE ORGANIZA OS COMENTARIOS E POST
                $comments = array();
                while ($rowteste = $teste->fetchArray())
                {
                    $rowteste['childs'] = array();
                    $referencia = $rowteste['referencia'];
                    $comments[$rowteste['codigo']] = $rowteste;
                    // print_r($comments);
                    
                }
                foreach ($comments as $k => & $v)
                {
                    if ($v['referencia'] != - 1)
                    {
                        $comments[$v['referencia']]['childs'][] = & $v;
                    }
                }
                unset($v);

                foreach ($comments as $k => $v)
                {
                    if ($v['referencia'] != - 1)
                    {
                        // print_r($v['referencia']);
                        unset($comments[$k]);
                    }
                }

                // CHAMANDO A FUNÇÃO
                display_comments($comments, 1, $db);
                // FIM
                // FUNÇÃO QUE FAZ TUDO (MOSTRA OS POSTS/COMENTARIOS/TUDO)
                function display_comments(array $comments, $level = 0, $db)
                {
                    $login = $_GET['email'];

                    foreach ($comments as $info)
                    {

                        // SE O POST FOR CURTIR OU COMPARTILHAR NÃO TEM CONTEÚDO ENTAO EH DIFERENTE O JEITO DE MOSTRAR
                        if ($info["tipo"] == 'CURTIR' || $info["tipo"] == 'COMPARTILHAMENTO')
                        {
                            echo '<div class = "reactions" value = ' . $info["codigo"] . '>';

                            //envia dados para o delete
                            if ($login == $info["email"])
                            {
                                echo '<form name="formdelete" method="post" action="#">';
                                echo '<input type="hidden" name="codigo" value="' . $info["codigo"] . '">';
                                echo '<input type="hidden" name="tipo" value="' . $info["tipo"] . '">';
                                echo '<input type="hidden" name="referencia" value="' . $info["referencia"] . '">';
                                echo '<button type="submit" name="delete">Apagar</button>';
                                echo '<a href=update_dados.php?email='.$login.'&codigo='.$info["codigo"].'>&#x1F4DD;</a>';
                                echo '</form>';

                            }
                            //
                            echo '<br>';
                            echo $info["tipo"] == 'CURTIR' ? ucwords(strtolower($info["usuario"])) . ' curtiu' . '<br>' : ucwords(strtolower($info["usuario"])) . ' compartilhou' . '<br>';

                            echo '<div id = data>';
                            echo ucwords(strtolower($info["data"]));
                            echo '<br>';
                            echo ucwords(strtolower($info["cidade"])) . ", ";;
                            echo ucwords(strtolower($info["uf"])) . ", ";
                            echo ucwords(strtolower($info["pais"]));

                            $results5 = $db->query("select group_concat(assunto.nome, ', ') as assunto from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = " . $info["codigo"]);

                            // MOSTRA OS ASSUNTOS DA INTERACAO
                            while ($row5 = $results5->fetchArray())
                            {
                                echo '<div class = assuntos2>';
                                echo $row5["assunto"];
                                echo '</div>';
                            }
                            echo '</div>';
                            // echo '</div>';
                            //  echo '<div id = coment>';
                            // DENTRO DO FORM É FEITO OS COMENTARIOS
                            echo '<form name="formreacoes" method="post" action="#">';
                            echo '<input type="hidden" name="codigocoment" value="' . $info["codigo"] . '">';

                            // ASSUNTO COMENTARIOS
                            echo '<select id="selectassuntos' . $info["codigo"] . '" name="' . $info["codigo"] . '">';
                            $results4 = $db->query("select nome, codigo from assunto");
                            while ($row = $results4->fetchArray())
                            {
                                echo "<option value=\"" . $row["codigo"] . "\">" . strtolower($row["nome"]) . "</option>\n";
                            }
                            echo '</select>';

                            echo "<input type=\"button\" id = \"mais\" name = \"assuntoscomentario\" value=\"+\" onclick=\"add1('" . $info["codigo"] . "')\";>";
                            echo "<input type=\"button\" id = \"del\" name = \"delassuntoscomentario\" value=\"-\" onclick=\"tira('" . $info["codigo"] . "')\";>";

                            echo '<input type="hidden" id="arrayt" name ="arrayt">';

                            echo '<div id="add' . $info["codigo"] . '"></div>';

                            echo '<textarea id="comentario" name="conteudocomentario" rows="4" cols="90" style="max-width:100%;" placeholder = "Escreva algo">';
                            echo '</textarea>';

                            echo '<button name = "comentar"type="submit">Comentar</button>';
                            // echo '</form>';
                            

                            // FORM DE CURTIR
                            // echo '<form name="formcurtir" method="post" action="#">';
                            // echo '<div id = reactions>';
                            echo '<button type="submit" name="curtir">Curtir</button>';
                            echo '<input type="hidden" name="codigocoment2" value="' . $info["codigo"] . '">';
                            echo '<input type="hidden" id="arrayt" name ="arrayt">';
                            // echo '</form>';
                            // COMPARTILHAR
                            // echo '<form name="formccompartilhar" method="post" action="#">';
                            echo '<input type="hidden" id="arrayt" name ="arrayt">';
                            echo '<button type="submit" name="compartilhar">Compartilhar</button>';
                            echo '<input type="hidden" name="codigocoment3" value="' . $info["codigo"] . '">';
                            echo '</form>';
                            echo '</div>';

                            // SE ELE TIVER 'CHILDS' (CHILDS = COMENTARIO/CURTIDA/INTERACAO) ELE CHAMA A FUNÇÃO DE NOVO
                            if (!empty($info['childs']))
                            {
                                echo '<div class="post" name=' . $info["codigo"] . '>';

                                display_comments($info['childs'], $level + 1, $db);
                                echo '</div>';

                            }
                        }
                        else
                        {
                            // MESMA COISA Q O DE CIMA MAS É PRA POST E COMENTARIO
                            echo $info["tipo"] == 'POST' ? '<div class ="post" value = ' . $info["codigo"] . '>' : '<div class ="comentarios" value = ' . $info["codigo"] . '>';

                            //envia dados para o delete
                            if ($login == $info["email"])
                            {
                                echo '<form name="formdelete" method="post" action="#">';
                                echo '<input type="hidden" name="codigo" value="' . $info["codigo"] . '">';
                                echo '<input type="hidden" name="tipo" value="' . $info["tipo"] . '">';
                                echo '<input type="hidden" name="referencia" value="' . $info["referencia"] . '">';
                                echo '<button type="submit" name="delete">Apagar</button>';
                                echo '<a href=update_dados.php?email='.$login.'&codigo='.$info["codigo"].'>&#x1F4DD;</a>';
                                echo '</form>';
                            }

                            echo '<div id = nome>';
                            echo ucwords(strtolower($info["usuario"]));
                            echo '<div id = data>';
                            echo $info["data"];
                            echo '<br>';
                            echo ucwords(strtolower($info["cidade"])) . ", ";;
                            echo ucwords(strtolower($info["uf"])) . ", ";
                            echo ucwords(strtolower($info["pais"]));
                            $results5 = $db->query("select group_concat(assunto.nome, ', ') as assunto from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = " . $info["codigo"]);

                            while ($row5 = $results5->fetchArray())
                            {
                                echo '<div id = assuntos>';
                                echo $row5["assunto"];
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '<div class = "conteudo">';
                            echo $info["conteudo"];
                            echo '</div>';

                            //  echo '<div id = coment>';
                            // COMENTAR
                            echo '<form name="formreacoes" method="post" action="#">';
                            echo '<input type="hidden" name="codigocoment" value="' . $info["codigo"] . '">';

                            echo '<select id="selectassuntos' . $info["codigo"] . '" name="' . $info["codigo"] . '">';
                            $results4 = $db->query("select nome, codigo from assunto");
                            while ($row = $results4->fetchArray())
                            {
                                echo "<option value=\"" . $row["codigo"] . "\">" . strtolower($row["nome"]) . "</option>\n";
                            }
                            echo '</select>';
                            echo "<input type=\"button\" id = \"mais\" name = \"assuntoscomentario\" value=\"+\" onclick=\"add1('" . $info["codigo"] . "')\";>";
                            echo "<input type=\"button\" id = \"del\" name = \"delassuntoscomentario\" value=\"-\" onclick=\"tira('" . $info["codigo"] . "')\";>";

                            echo '<input type="hidden" id="arrayt" name ="arrayt">';

                            echo '<div id="add' . $info["codigo"] . '"></div>';

                            echo '<textarea id="comentario" name="conteudocomentario" rows="4" cols="90" style="max-width:95%;" placeholder = "Escreva algo">';
                            echo '</textarea>';
                            echo '<button name="comentar" type="submit" >Comentar</button>';
                            // echo '</form>';
                            // CURTIR
                            // echo '<div class = reactions2>';
                            // echo '<form name="formcurtir" method="post" action="#">';
                            echo '<button type="submit" name="curtir">Curtir</button>';
                            echo '<input type="hidden" name="codigocoment2" value="' . $info["codigo"] . '">';
                            echo '<input type="hidden" id="arrayt" name ="arrayt">';
                            // echo '</form>';
                            

                            // COMPARTILHAR
                            //  echo '<form name="formccompartilhar" method="post" action="#">';
                            echo '<div id = compartilhar>';
                            echo '<input type="hidden" id="arrayt" name ="arrayt">';
                            echo '<button type="submit" name="compartilhar">Compartilhar</button>';
                            echo '<input type="hidden" name="codigocoment3" value="' . $info["codigo"] . '">';
                            echo '</div>';
                            echo '</form>';

                            // echo str_repeat('-', $level + 1).' comment '.$info['codigo']."\n";
                            if (!empty($info['childs']))
                            {
                                echo '<div class="comentarios" name=' . $info["codigo"] . '>';

                                display_comments($info['childs'], $level + 1, $db);
                                echo '</div>';

                            }
                            echo '</div>';

                        }
                    }
                }
                echo '</section>';

                $resultsF = $db->query('select distinct nome as amigo, a.usuario2 as user2, a.usuario1 as user1, a.ativo as ativo
                from amizade as a
                left join amizade as b on a.usuario2 = b.usuario2
                left join usuario as p on a.usuario2 = p.email
                where a.usuario1  = ' . '"' . $login . '"' . '');

                echo '<section class="event">';
                echo '<center>';
                echo '<h3>Amigos</h3>';
                echo '<h6>Clique em um amigo se deseja excluí-lo da sua lista de amizades.</h6>';
                echo '</center>';
                while ($rowF = $resultsF->fetchArray()) {
                    echo '<br>';
                    echo '<center>';
                    echo ($rowF["ativo"] == 0 ? "" : "<button type='button' disabled><a href=\"delete_amizade.php?usuario1=" . $login . "&usuario2=" . $rowF["user2"] . "\" onclick=\"return(confirm('Excluir " . ucwords(strtolower($rowF["amigo"])) . " da sua lista de amizades?'));\">" . " &#128100 " . ucwords(strtolower($rowF["amigo"])) . "</a></button>");
                    echo '</center>';
                }

                echo '</section>';
                echo '</main>';
                echo '</div>';


                $total = $db->query("select count(*) as total from interacao")
                    ->fetchArray() ["total"];
                if (isset($_POST['postar']))
                {
                    $x = $_POST['array'];
                    $valores = explode(",", $x);
                    echo $x;
                    $total = $total + 1;
                    $post_content = $_POST['conteudo'];
                    if ($post_content == "")
                    {
                        echo "<font color=\"red\" size=\"50px\"> ERRO! </font>";
                        echo '<script>';
                        echo 'alert("Você precisa digitar algo antes!")';
                        echo '</script>';
                        echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                    }
                    else
                    {
                        $db->exec("insert into interacao (codigo, usuario, tipo, cidade, conteudo) values ($total, '" . $login . "', 'POST',  1, '" . $post_content . "')");
                        if (!empty($_POST['array']))
                        {
                            for ($i = 0;$i < count($valores);$i++)
                            {
                                // echo $valores[$i];
                                $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                            }
                        }
                        echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                    }
                }
                if (isset($_POST['comentar']))
                {
                    // print_r($_POST['array2']);
                    $a = $_POST['arrayt'];
                    // print_r($x);
                    echo $a;
                    $valores = explode(",", $a);
                    $total = $total + 1;
                    $comment_content = $_POST['conteudocomentario'];
                    if ($comment_content == "")
                    {
                        echo "<font color=\"red\" size=\"50px\"> ERRO! </font>";
                        echo '<script>';
                        echo 'alert("Você precisa digitar algo antes!")';
                        echo '</script>';
                        echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                    }
                    else
                    {
                        $db->exec("insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values ($total, '" . $login . "', 'COMENTARIO', 1, '" . $comment_content . "', " . $_POST['codigocoment'] . ")");
                        if (!empty($_POST['arrayt']))
                        {
                            for ($i = 0;$i < count($valores);$i++)
                            {
                                $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                            }
                        }
                        echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                    }
                }
                if (isset($_POST['curtir']))
                {
                    echo 'asdad';
                    $total = $total + 1;

                    $x = $_POST['arrayt'];
                    $valores = explode(",", $x);
                    $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '" . $login . "', 'CURTIR', 1, " . $_POST['codigocoment2'] . ")");
                    if (!empty($_POST['arrayt']))
                    {
                        for ($i = 0;$i < count($valores);$i++)
                        {
                            // echo $valores[$i];
                            $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                        }
                    }
                    echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                }
                if (isset($_POST['compartilhar']))
                {
                    $total++;

                    $x = $_POST['arrayt'];
                    $valores = explode(",", $x);
                    // $comment_content  = $_POST['conteudocomentario'];
                    $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '" . $login . "', 'COMPARTILHAMENTO', 1, " . $_POST['codigocoment3'] . ")");
                    if (!empty($_POST['arrayt']))
                    {
                        for ($i = 0;$i < count($valores);$i++)
                        {
                            // echo $valores[$i];
                            $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                        }
                    }
                    echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                }
                if (isset($_POST['delete'])){
                    
                        $delete = $db->query("select codigo, tipo, referencia from interacao where ativo = 1 and referencia = ". $_POST["codigo"]);
                        while ($row = $delete->fetchArray()){
                                    // echo $row["codigo"];
                                    // echo "espaco";
                        $delete2 = $db->query("select codigo, tipo, referencia from interacao where ativo = 1 and referencia = ". $row["codigo"]);
                        while ($row2 = $delete2->fetchArray()){
                            echo $row2["codigo"];
                            $db->exec("update interacao set ativo = 0 where codigo = " . $row2["codigo"]);
                            $db->exec("update interacao set ativo = 0 where referencia = " . $row2["codigo"]);
                            $db->exec("update assunto_interacao set ativo = 0 where interacao = " . $row2["codigo"]);
                        }
                        }
                        $db->exec("update interacao set ativo = 0 where codigo = " . $_POST["codigo"]);
                        $db->exec("update interacao set ativo = 0 where referencia = " . $_POST["codigo"]);
                        $db->exec("update assunto_interacao set ativo = 0 where interacao = " . $_POST["codigo"]);

                    
                    // $db->exec("delete from citacao_usuario where interacao = ".$_POST["codigo"]);
                    // echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";

                }
            }else {
                echo 'erro ao entrar no feed, faça login novamente';
            }
        }else {
            echo 'erro ao entrar no feed, faça login novamente';
        }
        $db->close();
    ?>
</body>
</html>