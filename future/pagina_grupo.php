<link rel="stylesheet" href="style.css">

<?php

    // abre o acesso ao banco de dados
    $db = new SQLite3("future.db");
    $db->exec("PRAGMA foreign_keys = ON");
    
    // mostra os dados do grupo selecionado
    if(isset($_GET["valorgp"]) && trim($_GET["valorgp"]) && trim($_GET["login"])) {

        function url($campo, $valor, $login) {
            $result = array();
            if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
            if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
            $result[$campo] = $campo."=".$valor;
            return("pagina_grupo.php?login=".$login."&valorgp=".$_GET["valorgp"]."&".strtr(implode("&", $result), " ", "+"));
        }

        // pega os dados do grupo: codigo, nome e descrição
        $dados = $db->query("select * from grupo where nome like '".$_GET["valorgp"]."'");
        $nomeuser = $db->query("select nome from usuario where email like '". $_GET["login"]."'")->fetchArray()['nome'];
        while($row = $dados->fetchArray()){
            // mostra a quantidade de usuario do grupo
            $qtdeusers = $db->query("select count(*) as num from grupo_usuario where grupo like '".$row['codigo']."' and ativo = 1")->fetchArray()["num"];
            $total = $qtdeusers;
            $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "nome asc";
            $limit = 5;
            $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
            $offset = $offset-($offset%$limit); 
            $todosusers = $db->query("select usuario.nome from usuario join grupo_usuario on usuario.email = grupo_usuario.usuario where grupo_usuario.grupo like '".$row['codigo']."' and grupo_usuario.ativo = 1 order by usuario.". $orderby . " limit ".$limit. " offset ".$offset."");

            if($qtdeusers == null) {
                $qtdeusers = '0 membros';
            } else if($qtdeusers == 1) {
                $qtdeusers = '1 membro';
            } else {
                $qtdeusers = $qtdeusers . ' membros';
            }

            // verifica se o usuário faz parte do grupo, se sim vê se ele é adm
            $verificauser = $db->query("select ativo, adm from grupo_usuario where usuario like '".$_GET["login"]."' and grupo = ". $row["codigo"])->fetchArray();
            $botao;
            $editar = 'não';
            if(($verificauser['ativo'] == null && $verificauser['adm'] == null) || $verificauser['ativo'] == 0) {
                $botao = "Entrar no Grupo";
            }else if($verificauser['ativo'] == 1) {
                    $selo = $db->query("select tmp10.selo, tmp10.nome 
                        from grupo,
                        (
                            select case
                                    when (tmp7.porcentagem_comentario >= 30 and tmp8.porcentagem_interacao >= 75) and tmp8.nome = tmp7.user then 'ultra-fa' 
                                    when (tmp7.porcentagem_comentario >= 20 and tmp8.porcentagem_interacao >= 50) and tmp8.nome = tmp7.user  then 'super-fa'
                                    when (tmp7.porcentagem_comentario >= 10 and tmp8.porcentagem_interacao >= 25) and tmp8.nome = tmp7.user  then 'fa' 
                                    else 'vazio' 
                                    end as selo, tmp8.nome
                            from
                            (
                                select tmp4.user, (cast(tmp4.qtde as real)/tmp5.qtde) * 100 as porcentagem_comentario 
                                    from
                                        (
                                            select tmp2.user as user, count(*) as qtde
                                                from (

                                                    select distinct interacao.referencia as post,
                                                        usuario.nome as user
                                                    from interacao
                                                        join usuario on usuario.email = interacao.usuario
                                                    where interacao.referencia not null and interacao.tipo like 'COMENTARIO'

                                                    UNION

                                                    select distinct interacao.referencia as post, tmp11.user
                                                    from interacao,
                                                    (select case
                                                            when com2.referencia is null
                                                            and com2.referencia = tmp.coment
                                                            and tmp.coment not null then tmp.post
                                                            else com2.referencia
                                                        end as post,
                                                        com2.codigo,
                                                        usuario.nome as user
                                                    from interacao
                                                        join interacao as com2 on com2.referencia = interacao.codigo
                                                        join usuario on usuario.email = com2.usuario,
                                                        (
                                                            select interacao.referencia as post,
                                                                interacao.codigo as coment
                                                            from interacao
                                                            where interacao.referencia not null and interacao.tipo like 'COMENTARIO'
                                                        ) as tmp
                                                    where interacao.tipo like 'COMENTARIO'
                                                    group by 1,
                                                        2
                                                    having 1 not null) as tmp11
                                                    where interacao.codigo in (tmp11.post)
                                                ) as tmp2,
                                                (
                                                    select interacao.codigo as id
                                                    from interacao
                                                        join usuario on usuario.email = interacao.usuario
                                                        join grupo_usuario on grupo_usuario.usuario = usuario.email
                                                        join grupo on grupo.codigo = grupo_usuario.grupo,
                                                        (select
                                                                case 
                                                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                                                case 
                                                                    when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                                                    when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                                                    when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                                                    when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                                                    when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                                                    when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                                                    when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                                        ) as tempo
                                                    where interacao.tipo like 'POST' and grupo.nome like '".$row['nome']."' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final
                                                ) as tmp3
                                            where tmp2.post in (tmp3.id) group by 1
                                        ) as tmp4,

                                        (
                                            select count(*) as qtde 
                                            from (
                                                select interacao.codigo
                                                    from interacao
                                                        join grupo on grupo.codigo = interacao.grupo, 
                                                        (select
                                                            case 
                                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                                            case 
                                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                                        ) as tempo
                                                    where grupo.nome like '".$row['nome']."' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final and interacao.tipo like 'POST'
                                            )
                                        ) as tmp5
                            ) as tmp7,
                            (
                                select tmp.nome, (cast(tmp.qtde as real)/tmp2.post_total) * 100 as porcentagem_interacao
                                    from
                                        (
                                            select usuario.nome, count(*) as qtde
                                                from interacao
                                                    join usuario on usuario.email = interacao.usuario
                                                    join grupo_usuario on grupo_usuario.usuario = usuario.email
                                                    join grupo on grupo.codigo = grupo_usuario.grupo
                                            where grupo.nome like '".$row['nome']."' and interacao.tipo like 'CURTIR'
                                            and interacao.referencia in 
                                                (
                                                    select interacao.codigo
                                                    from interacao
                                                        join usuario on usuario.email = interacao.usuario
                                                        join grupo_usuario on grupo_usuario.usuario = usuario.email
                                                        join grupo on grupo.codigo = grupo_usuario.grupo,
                                                        (select
                                                            case 
                                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                                            case 
                                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                                        ) as tempo
                                                        where grupo.nome like '".$row['nome']."' and interacao.tipo like 'POST' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final 
                                                ) group by 1
                                        ) as tmp,

                                        (
                                            select count(*) as post_total 
                                            from (
                                                select distinct interacao.codigo
                                                    from interacao
                                                        join grupo on grupo.codigo = interacao.grupo,
                                                        (select
                                                            case 
                                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-1 day')
                                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-2 days')
                                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-3 days')
                                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-4 days')
                                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-5 days')
                                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-6 days')
                                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime') end as data_final, 
                                                            case 
                                                                when strftime('%w', 'now', 'localtime') = '0' then strftime('%Y%m%d','now', 'localtime', '-7 days')
                                                                when strftime('%w', 'now', 'localtime') = '1' then strftime('%Y%m%d','now', 'localtime', '-8 days')
                                                                when strftime('%w', 'now', 'localtime') = '2' then strftime('%Y%m%d','now', 'localtime', '-9 days')
                                                                when strftime('%w', 'now', 'localtime') = '3' then strftime('%Y%m%d','now', 'localtime', '-10 days')
                                                                when strftime('%w', 'now', 'localtime') = '4' then strftime('%Y%m%d','now', 'localtime', '-11 days')
                                                                when strftime('%w', 'now', 'localtime') = '5' then strftime('%Y%m%d','now', 'localtime', '-12 days')
                                                                when strftime('%w', 'now', 'localtime') = '6' then strftime('%Y%m%d','now', 'localtime', '-6 days') end as data_inicial
                                                        ) as tempo
                                                    where interacao.tipo like 'POST' and grupo.nome like '".$row['nome']."' and strftime('%Y%m%d', interacao.hora_post) between tempo.data_inicial and tempo.data_final 
                                            )
                                        ) as tmp2
                            ) as tmp8
                            order by 1
                        ) as tmp10
                    where grupo.nome like '".$row['nome']."' and tmp10.nome like '".$nomeuser."'
                    group by 2;
                ")->fetchArray()['selo'];
                if($verificauser['adm'] == 0) {
                    $botao = "Sair do Grupo";
                }else {
                    $botao = "Excluir o Grupo";
                    $editar = 'sim';

                }
            }

            if($selo == 'vazio' || $selo == '') {
                $selo = 'Você não possui selo nesse grupo';
            }else {
                $selo = 'Selo: '. str_replace("fa", "fã", $selo);
            }

            $botaoname = explode(' ',$botao);
            echo '<div class="container-box">';
            echo '<header class="header"></header>';
            echo '<main class="main">';
            echo '<section class="menu">';
            echo '</section>';
            echo "<section class='feed centro'>";
            echo "<h3>".$row["nome"]."</h3>";
            echo $qtdeusers;

            echo "<table border=1>";
            echo "<tr><td>Ordernar<a href='".url("orderby", "nome+asc", $_GET["login"])."'>&#x25BE;</a><a href='".url("orderby", "nome+desc", $_GET["login"])."'>&#x25B4;</a></td><tr>";
            while ($row = $todosusers->fetchArray()) {
                echo "<tr><td><a href=\"pagina_grupo.php?valorgp=".$row['nome']."&login=".$_GET["login"]."\">" .ucfirst(strtolower($row['nome'])) . "</a></td></tr>";
            }

            echo "</table>";
            for ($page = 0; $page < ceil($total/$limit); $page++) {
                echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit, $_GET["login"])."\">".($page+1)."</a>")." \n";
            }

            echo "<p>Descrição:".$row["descricao"] ."</p>";
            echo $selo;
            echo "<form action='pagina_grupo.php' method='post'>";
            echo '<button type="submit" class="button-filho" name="valor" value="'.$botaoname[0].'">'.$botao.'</button>';
            echo '<input class="hidden" name="user" value="'.$_GET['login'].'">';
            echo '<input class="hidden" name="valorgp" value="'.$row["codigo"].'">';
            echo '<input class="hidden" name="tipo" value="grupo">';
            echo "</form>";
            echo "<form id='formedit' action'pagina_grupo.php' method='get'>";
            if($editar == 'sim') {
                echo '<button type="button" onclick="mostrar(\''.$row["descricao"].'\', \''.$row["nome"].'\', \''.$row["codigo"].'\', \''.$_GET['login'].'\')" class="button-filho" name="editar" value="'.$botaoname[0].'">Editar dados do grupo</button>';
            }
            echo "</form>";
            echo "</section>";
            echo '<section class="event">';
            echo "</section>";
            echo "</main>";
            echo "</div>";
        }

    }else if(isset($_POST["valor"])) {

        if($_POST["valor"] == "Entrar") {

            // ve se existe o ativo 0 e se sim passa pra ativo 1, se não adiciona
            $ativo = $db->query("select ativo from grupo_usuario where usuario like '".$_POST["user"]."' and grupo = ".$_POST["valorgp"]."")->fetchArray()["ativo"];

            if($ativo == 0 && isset($ativo)) {
                $db->exec("update grupo_usuario set ativo = 1 where grupo = ".$_POST["valorgp"]." and usuario like '".$_POST["user"]."'");
            }else {
                $db->exec("insert into grupo_usuario (usuario, grupo) values ('" . $_POST["user"] . "', ".$_POST["valorgp"].")");
            }

        }else if($_POST["valor"] == "Sair") {

            $db->exec("update grupo_usuario set ativo = 0 where grupo = ".$_POST["valorgp"]." and usuario like '".$_POST["user"]."'");

        }else if($_POST["valor"] == "Excluir") {

            $db->exec("update grupo set ativo = 0 where codigo = ".$_POST["valorgp"]);
            $db->exec("update grupo_usuario set ativo = 0 where grupo = ".$_POST["valorgp"]);
            // !!!!!!!!!!!!!!!! Excluir interações que são relacionadas com o grupo

        }

        header('Location: /feed.php?email=' . $_POST["user"]);
        
    }else if(isset($_GET["nome"]) && isset($_GET["descricao"]) && isset($_GET['codigo'])) {
        echo 'aqui';
        $db->query("update grupo set nome ='".$_GET['nome']."', descricao = '".$_GET['descricao']."' where codigo = ".$_GET['codigo']);
        header('Location: /feed.php?email=' . $_GET["user"]);
    }else {

        echo "Erro no retorno da pesquisa tente novamente";
        echo "<script>setTimeout(function () { window.open(\"feed.php?email=".$_GET["login"]."\",\"_self\"); }, 4000);</script>";

    }

    $db->close();

?>

<script>
    function mostrar(descricao, nome, codigo, user) {
        let formedit = document.getElementById("formedit");
        formedit.innerHTML = "Nome: <input value='"+nome+"' name='nome'> <br> Descrição: <textarea name='descricao' maxlength='200'>"+descricao+"</textarea> <input value='"+codigo+"' class='hidden' name='codigo'><input value='"+user+"' class='hidden' name='user'><button>Editar</button>";
    }
</script>