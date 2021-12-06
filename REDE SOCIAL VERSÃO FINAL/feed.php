<html>
<body>
<head>
<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
</head>
  <?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");

if (isset($_GET['email']) && $_GET['email'] != null)
{

    $login = $db->query("select email from usuario where email like '" . $_GET['email'] . "'")->fetchArray() ["email"];
    if (isset($login))
    {
        $nome = $login;

        function urla($campo, $valor, $login, $vfinal = '')
        {
            $result = array();
            if (isset($_GET["orderbya"])) $result["orderbya"] = "orderbya=" . $_GET["orderbya"];
            if (isset($_GET["ordeby"])) $result["ordeby"] = "ordeby=" . $_GET["ordeby"];
            if (isset($_GET["ofset"])) $result["ofset"] = "ofset=" . $_GET["ofset"];
            if (isset($_GET["offseta"])) $result["offseta"] = "offseta=" . $_GET["offseta"];
            if ($vfinal != '') $result["vfinal"] = "vfinal=" . $vfinal;
            $result[$campo] = $campo . "=" . $valor;
            return ("feed.php?email=" . $login . "&" . strtr(implode("&", $result) , " ", "+"));
        }

        function url($campo, $valor, $login)
        {
            $result = array();
            if (isset($_GET["orderby"])) $result["orderby"] = "orderby=" . $_GET["orderby"];
            if (isset($_GET["offset"])) $result["offset"] = "offset=" . $_GET["offset"];
            if (isset($_GET["nome"])) $result["nome"] = "nome=" . $_GET["nome"];
            if (isset($_GET["palavra"])) $result["palavra"] = "palavra=" . $_GET["palavra"];
            if (isset($_GET["data"])) $result["data"] = "data=" . $_GET["data"];
            if (isset($_GET["grupo"])) $result["grupo"] = "grupo=" . $_GET["grupo"];

            $result[$campo] = $campo . "=" . $valor;
            return ("feed.php?email=" . $login . "&" . strtr(implode("&", $result) , " ", "+"));
        }

        $parameters = array();
        if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];
        $limit = 105;
        $qtdepost = $db->query("select count(*) as num from interacao where ativo = 1")
            ->fetchArray() ["num"];
        $total = $qtdepost;
        $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "data asc";

        $offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total - 1)) : 0;
        $offset = $offset - ($offset % $limit);

        $login = $_GET['email'];

        echo '<div class="container-box">';
        echo '<header class="header">';
        echo '<a href=select_usuario.php style = " position: absolute; margin-left:1200px; margin-top: 7" >&#128282</a>';
        echo '<a href=dados_usuario.php?email=' . $login . ' style = " position: absolute; margin-left:1300px; margin-top: 7" >Configurações</a>';

        echo '<center>';

        $value = "";
        if (isset($_GET["nome"])) $value = $_GET["nome"];
        if (isset($_GET["palavra"])) $value = $_GET["palavra"];
        if (isset($_GET["data"])) $value = $_GET["data"];
        if (isset($_GET["grupo"])) $value = $_GET["grupo"];

        echo "<input type=\"text\" style=\"margin-top: 7\" id=\"valor1\" name=\"valor1\" value=\"" . $value . "\" size=\"70\"> \n";

        $parameters = array();
        if (isset($_GET["orderby"])) $parameters[] = "orderby=" . $_GET["orderby"];
        if (isset($_GET["offset"])) $parameters[] = "offset=" . $_GET["offset"];

        $where = array();
        if (isset($_GET["nome"])) $where[] = "tipo = 'POST' and usuario like '%" . strtr($_GET["nome"], " ", "%") . "%'";
        if (isset($_GET["palavra"])) $where[] = "conteudo like '%" . strtr($_GET["palavra"], " ", "%") . "%'";
        if (isset($_GET["data"])) $where[] = "strftime('%d/%m/%Y', data) like '%" . strtr($_GET["data"], " ", "%") . "%'";
        if (isset($_GET["grupo"])) $where[] = "grupo='" . $_GET["grupo"] . "'";

        $where = (count($where) > 0) ? "where " . implode(" and ", $where) : "";

        if (isset($_GET["nome"]))
        {
            $total = $db->query("select count(usuario) as total from interacao join usuario on interacao.usuario = usuario.email " . $where)->fetchArray() ["total"];
        }

        if (isset($_GET["data"]))
        {
            $total = $db->query("select hora_post as data, count(*) as total from interacao " . $where)->fetchArray() ["total"];
        }

        if (isset($_GET["palavra"]))
        {
            $total = $db->query("select count(conteudo) as total from interacao " . $where)->fetchArray() ["total"];
        }
        if (isset($_GET["grupo"]))
        {
            $total = $db->query("select count(grupo) as total from interacao " . $where)->fetchArray() ["total"];
        }

        echo "<select id=\"campo\" name=\"campo\">\n";
        echo "<option value=\"nome\"" . ((isset($_GET["nome"])) ? " selected" : "") . ">Nome</option>\n";
        echo "<option value=\"palavra\"" . ((isset($_GET["palavra"])) ? " selected" : "") . ">Palavra</option>\n";
        echo "<option value=\"data\"" . ((isset($_GET["data"])) ? " selected" : "") . ">Data</option>\n";
        echo "<option value=\"grupo\"" . ((isset($_GET["grupo"])) ? " selected" : "") . ">Grupo</option>\n";

        echo "</select>";
        echo "<a href=\"\" id=\"valida\" onclick=\" value = document.getElementById('valor1').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parameters) , " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='feed.php?email=" . $login . "'+((result != '') ? '&' : '')+result;\">&#x1F50E;</a><br>\n";
        echo '</center>';

        echo '</header>';
        echo '<main class="main">';
        echo '<section class="menu">';
        if (isset($_POST["descricao"]))
        {
            $valor = strtoupper($_POST["grupo"]);
            $testenome = $db->query("select nome from grupo where nome = '$valor'")->fetchArray() ['nome'];
            if ($testenome == null || $testenome != $valor)
            {
                $db->exec("insert into grupo (nome, descricao) values ('" . $valor . "','" . $_POST["descricao"] . "')");
                $codigogrupag = $db->query("select codigo from grupo where nome = '$valor'")->fetchArray() ['codigo'];
                $db->exec("insert into grupo_usuario (usuario, grupo, adm) values ('" . $_POST["usuario"] . "', $codigogrupag, 1)");
                echo "Grupo criado com sucesso";
            }
            else
            {
                header('Location: /feed.php?email=' . $login . '&error=nome ja existente');
            }
        }

        if (isset($_POST['campo']) || isset($_GET['vfinal']))
        {
            $camponovo = isset($_POST['campo']) ? $_POST['campo'] : isset($_GET['vfinal']);

            $camponovo = $camponovo == '*' ? ' ' : $camponovo;
            if ($camponovo == ' ')
            {
                $newtotal = $db->query("select count(*) as total from grupo where ativo = 1")
                    ->fetchArray() ['total'];
            }
            else
            {
                $newtotal = $db->query("select count(*) as total from grupo where nome like '%" . $camponovo . "%' AND ativo = 1")->fetchArray() ['total'];
            }
            $ordeby = (isset($_GET["ordeby"])) ? $_GET["ordeby"] : "nome asc";
            $limite = 5;
            $ofset = (isset($_GET["ofset"])) ? max(0, min($_GET["ofset"], $newtotal - 1)) : 0;
            $ofset = $ofset - ($ofset % $limite);
            if ($camponovo == ' ')
            {
                $selectpesquisa = $db->query("select nome, codigo from grupo where ativo = 1 order by " . $ordeby . " limit " . $limite . " offset " . $ofset);
            }
            else
            {
                $selectpesquisa = $db->query("select nome, codigo from grupo where nome like '%" . $camponovo . "%' AND ativo = 1 order by " . $ordeby . " limit " . $limite . " offset " . $ofset);
            }
            $arraypesquisa = [];
            $cont = 1;
            while ($rowpesquisa = $selectpesquisa->fetchArray())
            {
                $arraypesquisa[$cont] = $rowpesquisa['nome'];
                $cont++;
                $arraypesquisa[$cont] = $rowpesquisa['codigo'];
                $cont++;
            }
            $arraypesquisa[0] = $camponovo;
        }

        if (isset($_GET['error']))
        {
            echo "<h5>" . $_GET['error'] . "</h5>";
        }

        echo "<h3>Criar Grupo</h3>";
        echo "<div id=\"formulario\">";
        echo "<form id='form' action='feed.php?email=" . $login . "' method='post'>";
        echo "<table><tr><td>Nome grupo: ";
        echo "<input type='text' id='grupo' name='grupo' maxlength='100' pattern='([a-zA-Z0-9]+ |[a-zA-Z0-9]+)+'>";
        echo "</td></tr><tr><td>Descrição:";
        echo "<textarea name='descricao' maxlength='200'></textarea>";
        echo "</td></tr><tr><td><input type='text' name='usuario' class='hidden' value='" . $login . "'>";
        echo "</td></tr><tr><td><button type='button' id='button' onclick='verificaPattern()' name='confirma'>Criar grupo</button>";
        echo "</td></tr></table></form>";

        echo "</div>";
        echo "<br><div><h3>Meus Grupos</h3></div>";

        $total = $db->query("select count(*) as total from grupo join grupo_usuario on grupo_usuario.grupo = grupo.codigo join usuario on usuario.email = grupo_usuario.usuario where usuario.email = '" . $login . "' and grupo_usuario.ativo = 1")->fetchArray() ['total'];
        $orderbya = (isset($_GET["orderbya"])) ? $_GET["orderbya"] : "nome asc";
        $limite = 5;
        $offseta = (isset($_GET["offseta"])) ? max(0, min($_GET["offseta"], $total - 1)) : 0;
        $offseta = $offseta - ($offseta % $limite);

        $meusgrupos = $db->query("select grupo.nome, grupo.codigo from grupo join grupo_usuario on grupo_usuario.grupo = grupo.codigo join usuario on usuario.email = grupo_usuario.usuario where usuario.email = '" . $login . "' and grupo_usuario.ativo = 1 order by grupo." . $orderbya . " limit " . $limite . " offset " . $offseta . "");

        echo "<table border=1>";
        echo "<tr><td>Ordenar<a href='" . urla("orderbya", "nome+asc", $login) . "'>&#x25BE;</a><a href='" . urla("orderbya", "nome+desc", $login) . "'>&#x25B4;</a></td><tr>";
        while ($row = $meusgrupos->fetchArray())
        {
            echo "<tr><td><a href=\"pagina_grupo.php?valorgp=" . $row['nome'] . "&login=" . $login . "\">" . ucfirst(strtolower($row['nome'])) . "</a></td></tr>";
        }

        echo "</table>";
        for ($page = 0;$page < ceil($total / $limite);$page++)
        {
            echo (($offseta == $page * $limite) ? ($page + 1) : "<a href=\"" . urla("offseta", $page * $limite, $login) . "\">" . ($page + 1) . "</a>") . " \n";
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
        if (isset($arraypesquisa) && $arraypesquisa != null)
        {
            $campo = $arraypesquisa[0] != '' ? $arraypesquisa[0] : '*';
            echo "<br><table border=1>";
            echo "<tr><td>Ordenar<a href='" . urla("ordeby", "nome+asc", $login, $campo) . "'>&#x25BE;</a><a href='" . urla("ordeby", "nome+desc", $login, $campo) . "'>&#x25B4;</a></td><tr>";
            for ($contp = 1;$contp < count($arraypesquisa);$contp = $contp + 2)
            {
                echo "<tr><td><a href=\"pagina_grupo.php?valorgp=" . $arraypesquisa[$contp] . "&login=" . $login . "\">" . $arraypesquisa[$contp] . "</a></td></tr>";
            }
            echo "</table>";
            for ($page = 0;$page < ceil($newtotal / $limite);$page++)
            {
                echo (($ofset == $page * $limite) ? ($page + 1) : "<a href=\"" . urla("ofset", $page * $limite, $login, $campo) . "\">" . ($page + 1) . "</a>") . " \n";
            }
        }

        // SABRINA
        function urlassunto($campo, $valor)
        {
            $result = array();
            if (isset($_GET["nome"])) $result["nome"] = "nome=" . $_GET["nome"];
            if (isset($_GET["sugestao"])) $result["sugestao"] = "sugestao=" . $_GET["sugestao"];
            if (isset($_GET["mes"])) $result["mes"] = "mes=" . $_GET["mes"];
            if (isset($_GET["assunto"])) $result["assunto"] = "assunto=" . $_GET["assunto"];
            if (isset($_GET["orderbyassunto"])) $result["orderbyassunto"] = "orderbyassunto=" . $_GET["orderbyassunto"];
            if (isset($_GET["offsetassunto"])) $result["offsetassunto"] = "offsetassunto=" . $_GET["offsetassunto"];
            $result[$campo] = $campo . "=" . $valor;
            return ("feed.php?email=" . $_GET["email"] . "&" . strtr(implode("&", $result) , " ", "+"));
        }

        $parametersassunto = array();
        if (isset($_GET["orderbyassunto"])) $parametersassunto[] = "orderbyassunto=" . $_GET["orderbyassunto"];
        if (isset($_GET["offsetassunto"])) $parametersassunto[] = "offsetassunto=" . $_GET["offsetassunto"];
        $limitassunto = 5;

        $qtdeassunto = $db->query("select qt as num
from
    (select nome, count(*) as qt, ano, mes
    from
        (select assunto.nome, interacao.conteudo,  strftime('%Y', interacao.hora_post) as ano,
case strftime('%m', interacao.hora_post)
when '01' then 'janeiro'
when '02' then 'fevereiro'
when '03' then 'marco'
when '04' then 'abril'
when '05' then 'maio'
when '06' then 'junho'
when '07' then 'julho'
when '08' then 'agosto'
when '09' then 'setembro'
when '10' then 'outubro'
when '11' then 'novembro'
when '12' then 'dezembro'
end as mes
            from interacao
              join assunto_interacao on assunto_interacao.interacao = interacao.codigo
join assunto on assunto_interacao.assunto = assunto.codigo
join cidade on cidade.codigo = interacao.cidade 
                   join uf on cidade.uf = uf.codigo 
                   join pais on uf.pais = pais.codigo 
                   where pais.nome = 'BRASIL' and hora_post  >= datetime('now', '-3 months', 'start of month') and hora_post  <= datetime('now', 'start of month'))
    group by 1, 4
    having qt in
(select distinct(qt)
    from
        (select nome, count(*) as qt, ano, mes
        from
            (select assunto.nome, interacao.conteudo,  strftime('%Y', interacao.hora_post) as ano,
case strftime('%m', interacao.hora_post)
when '01' then 'janeiro'
when '02' then 'fevereiro'
when '03' then 'marco'
when '04' then 'abril'
when '05' then 'maio'
when '06' then 'junho'
when '07' then 'julho'
when '08' then 'agosto'
when '09' then 'setembro'
when '10' then 'outubro'
when '11' then 'novembro'
when '12' then 'dezembro'
end as mes
                from interacao
                   join assunto_interacao on assunto_interacao.interacao = interacao.codigo
                   join assunto on assunto_interacao.assunto = assunto.codigo
                   join cidade on cidade.codigo = interacao.cidade 
                   join uf on cidade.uf = uf.codigo 
                   join pais on uf.pais = pais.codigo 
                   where pais.nome = 'BRASIL' and hora_post  >= date('now', '-3 months', 'start of month')
                   and hora_post  < date('now', 'start of month')
                )
        group by 1, 4)
    order by 1 desc
limit 5)) as tmp
group by 1, ano, mes order by mes, qt desc;")
            ->fetchArray() ["num"];
        $totalassunto = $qtdeassunto;

        //TOP ASSUNTOS!!!
        $orderbyassuntos = (isset($_GET["orderbyassunto"])) ? $_GET["orderbyassunto"] : "1 asc";
        $whereassuntos = array();

        $resultsT = $db->query("select tmp.nome, qt, ano, mes
from
    (select nome, count(*) as qt, ano, mes
    from
        (select assunto.nome, interacao.conteudo,  strftime('%Y', interacao.hora_post) as ano,
case strftime('%m', interacao.hora_post)
when '01' then 'janeiro'
when '02' then 'fevereiro'
when '03' then 'marco'
when '04' then 'abril'
when '05' then 'maio'
when '06' then 'junho'
when '07' then 'julho'
when '08' then 'agosto'
when '09' then 'setembro'
when '10' then 'outubro'
when '11' then 'novembro'
when '12' then 'dezembro'
end as mes
            from interacao
              join assunto_interacao on assunto_interacao.interacao = interacao.codigo
join assunto on assunto_interacao.assunto = assunto.codigo
join cidade on cidade.codigo = interacao.cidade 
                   join uf on cidade.uf = uf.codigo 
                   join pais on uf.pais = pais.codigo 
                   where pais.nome = 'BRASIL')
    group by 1, 4
    having qt in
(select distinct(qt)
    from
        (select nome, count(*) as qt, ano, mes
        from
            (select assunto.nome, interacao.conteudo,  strftime('%Y', interacao.hora_post) as ano,
case strftime('%m', interacao.hora_post)
when '01' then 'janeiro'
when '02' then 'fevereiro'
when '03' then 'marco'
when '04' then 'abril'
when '05' then 'maio'
when '06' then 'junho'
when '07' then 'julho'
when '08' then 'agosto'
when '09' then 'setembro'
when '10' then 'outubro'
when '11' then 'novembro'
when '12' then 'dezembro'
end as mes
                from interacao
                   join assunto_interacao on assunto_interacao.interacao = interacao.codigo
                   join assunto on assunto_interacao.assunto = assunto.codigo
                   join cidade on cidade.codigo = interacao.cidade 
                   join uf on cidade.uf = uf.codigo 
                   join pais on uf.pais = pais.codigo 
                   where pais.nome = 'BRASIL'
                )
        group by 1, 4)
    order by 1 desc
limit 5)) as tmp
group by 1, ano, mes order by " . $orderbyassuntos . ", qt desc;
");

        if (isset($_GET["mes"]))
        {
            $totalassunto = $db->query("select count(case strftime('%m', interacao.hora_post)
  when '01' then 'janeiro'
  when '02' then 'fevereiro'
  when '03' then 'marco'
  when '04' then 'abril'
  when '05' then 'maio'
  when '06' then 'junho'
  when '07' then 'julho'
  when '08' then 'agosto'
  when '09' then 'setembro'
  when '10' then 'outubro'
  when '11' then 'novembro'
  when '12' then 'dezembro'
  end as mes) as total
                  from interacao
                     join assunto_interacao on assunto_interacao.interacao = interacao.codigo
                     join assunto on assunto_interacao.assunto = assunto.codigo
                     join cidade on cidade.codigo = interacao.cidade 
                     join uf on cidade.uf = uf.codigo 
                     join pais on uf.pais = pais.codigo 
                     where pais.nome = 'BRASIL' " . $whereassuntos)->fetchArray() ["totalassunto"];
        }

        if (isset($_GET["assunto"]))
        {
            $totalassunto = $db->query("select count(case strftime('%m', interacao.hora_post)
  when '01' then 'janeiro'
  when '02' then 'fevereiro'
  when '03' then 'marco'
  when '04' then 'abril'
  when '05' then 'maio'
  when '06' then 'junho'
  when '07' then 'julho'
  when '08' then 'agosto'
  when '09' then 'setembro'
  when '10' then 'outubro'
  when '11' then 'novembro'
  when '12' then 'dezembro'
  end as mes) as total
                  from interacao
                     join assunto_interacao on assunto_interacao.interacao = interacao.codigo
                     join assunto on assunto_interacao.assunto = assunto.codigo
                     join cidade on cidade.codigo = interacao.cidade 
                     join uf on cidade.uf = uf.codigo 
                     join pais on uf.pais = pais.codigo 
                     where pais.nome = 'BRASIL' " . $whereassuntos)->fetchArray() ["totalassunto"];
        }

        echo '<h3>TOP ASSUNTOS<h3>';
        echo "<table border=\"1\">\n";
        echo "<tr>\n";
        echo "<td><b>Mês</b></td>\n";
        echo "<td><b>Assunto</b> <a href=\"" . urlassunto("orderbyassunto", "1+asc") . "\">&#x25BE;</a> <a href=\"" . urlassunto("orderbyassunto", "1+desc") . "\">&#x25B4;</a></td>\n";
        echo "</tr>\n";
        while ($rowT = $resultsT->fetchArray())
        {
            echo "<tr>\n";
            echo "<td>" . $rowT["mes"] . "</td>\n";
            echo "<td>" . $rowT["nome"] . "</td>\n";
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>';
        echo '<div>';
        $qtde = 300;
        $hrs = 24;
        $pais = 'BRASIL';
        $dias = 7;

        $result = $db->querySingle("select count(*) from (select count(*) from usuario join interacao on usuario.email = interacao.usuario join (select count(*) as qtde, inter1.codigo as codigo, usuario.email as email from interacao as inter2 join interacao as inter1 on inter1.codigo = inter2.referencia join cidade on inter1.cidade = cidade.codigo join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on inter1.usuario = usuario.email where (inter2.tipo = 'CURTIR') and (datetime(inter2.hora_post) between datetime(inter1.hora_post) and datetime(inter1.hora_post, '+" . $hrs . " hours')) and (datetime(inter1.hora_post) between datetime('now', 'localtime', '-" . $dias . " days') and datetime('now', 'localtime')) and (pais.nome like '" . $pais . "') group by 3, 2) as tmp on tmp.codigo = interacao.codigo where tmp.qtde > " . $qtde . " group by tmp.email)");

        echo $result . ' usuário(s) receberam ' . $qtde . ' curtidas ou mais após ' . $hrs . ' horas nos últimos ' . $dias . ' dias';
        echo '</div>';
        echo '<br>';

        echo '<a href=grafico.php style = " position: absolute; margin-top: 7" >Visualizar gráfico</a>';

        echo '</section>';
        //FEED
        echo '<section class="feed">';
        echo '<div id = postar>';
        $results1 = $db->query('select usuario.nome as nome, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais from usuario join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where email = ' . '"' . $login . '"' . '');
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
        $valor = "";
        $results22 = $db->query('select usuario.nome as nome, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais from usuario join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where email = ' . '"' . $login . '"' . '');
        while ($row22 = $results22->fetchArray())
        {
            $valor = $row22["cidadecod"];
        }
        echo '<input type="hidden" name ="cidadecod1" value = ' . $valor . '>';
        echo '<div>';
        echo 'Citar: ';
        echo '<select id="selectcitar" name="selectcitar">';
        $resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '" . $login . "'");
        while ($rowc = $resultsc->fetchArray())
        {
            echo "<option value=\"" . $rowc["codigo"] . "\">" . ucwords(strtolower($rowc["nome"])) . "</option>\n";

        }
        echo '</select>';
        echo '<input type="button" id = "mais" value="+" onclick="addcitar();">';
        echo "<input type=\"button\" id = \"del\" name = \"delcitar\" value=\"-\" onclick=\"tiracitar()\";>";
        echo '<input type="hidden" id = "arraycita" name ="arraycita">';
        echo '<div id="addcitar"></div>';
        echo '</div>';

        echo '<select id="selectassuntos" onchange="mostra();" name="0">';
        $results4 = $db->query("select nome, codigo from assunto");
        while ($row = $results4->fetchArray())
        {
            echo "<option value=\"" . $row["codigo"] . "\">" . strtolower($row["nome"]) . "</option>\n";
        }
        echo '<option value="outra">outra</option>';

        echo '</select>';

        echo '<input type="button" id = "mais" value="+" style="display: inline;" onclick="add();">';

        echo '<input type="button" id = "del" name = "delassuntos" style="display: inline;" value="-" onclick="tira1()";>';

        echo '<input type="hidden" id = "array" name ="array">';

        echo '<div id="add"></div>';
        echo '<textarea id="conteudo" name="conteudo" rows="4" cols="90" style="max-width:100%;" placeholder = "O que você está pensando?">';
        echo '</textarea>';

        echo '<div>';
        echo ' Postar no grupo: ';
        echo '<select id="selectgrupo" name="selectgrupo">';
        echo "<option value='0'>Nenhum</option>\n";

        $results5 = $db->query("select grupo.nome as nome, grupo.codigo as codigo from grupo_usuario join grupo on grupo_usuario.grupo = grupo.codigo where grupo_usuario.ativo = 1 and usuario = '" . $login . "'");
        while ($row5 = $results5->fetchArray())
        {
            echo "<option value=\"" . $row5["codigo"] . "\">" . ucwords(strtolower($row5["nome"])) . "</option>\n";
        }
        echo '</select>';
        echo '</div>';

        echo '<button name="postar" type="submit">Publicar</button>';
        echo '</form>';
        echo '<form name="formassunto" method="post" action="#">';
        echo '<input type="text" id="outra" name="outra" style="display: none;" required="">';
        echo '<input type="submit" id = "adicionar" name = "adicionar" value="Add"  style="display: none;"";>';
        echo '</form>';
        echo '</div>';
        // FIM
        

        //FEED
        $teste = $db->query("select codigo,  usuario, email, tipo, data,  cidade, uf, pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, ativo
from(
  

    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where usuario = '" . $login . "' and interacao.grupo IS NULL and interacao.ativo = 1

union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
        from interacao
        where interacao.usuario = '" . $login . "' and interacao.grupo IS NULL
        order by 1 desc) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in (select referencia
        from interacao
        where interacao.usuario = '" . $login . "' and interacao.grupo IS NULL
        order by 1 desc) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = '" . $login . "' and amizade.ativo = 1 and interacao.grupo IS NULL
union
    -- INTERACOES DOS AMIGOS
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in
    (select case when referencia is null then -1 else referencia end as referencia
        from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
        where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = '" . $login . "' and amizade.ativo = 1 and interacao.grupo IS NULL) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.grupo IS NULL
    group by interacao.codigo
    having (
    (select interacao.codigo
        from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
        where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and interacao.grupo IS NULL and usuario2 = '" . $login . "' and amizade.ativo = 0) = interacao.codigo) and interacao.grupo IS NULL
union
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = '" . $login . "'
    union 
    select interacao.codigo, usuario.nome as usuario, citacao_usuario.usuario_marcado as email, tipo, hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
from citacao_usuario join interacao on interacao.usuario = citacao_usuario.usuario_marcado join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
where interacao.ativo = 1 and citacao_usuario.ativo = 1 and citacao_usuario.usuario_marcado = '" . $login . "')" . $where . " order by " . $orderby . " limit " . $limit . " offset " . $offset);

        // FIM
        // AQUI EH ONDE ORGANIZA OS COMENTARIOS E POST
        $comments = array();
        while ($rowteste = $teste->fetchArray())
        {
            $rowteste['childs'] = array();
            $referencia = $rowteste['referencia'];
            $comments[$rowteste['codigo']] = $rowteste;

        }

        echo '<center>';
        echo "<tr><td>Ordenar<a href='" . url("orderby", "data+asc", $login) . "'>&#x25BE;</a><a href='" . url("orderby", "data+desc", $login) . "'>&#x25B4;</a></td><tr>";
        echo '</center>';

        foreach ($comments as $k => & $v)
        {

            if ($v['referencia'] !== - 1)
            {
                $comments[$v['referencia']]['childs'][] = & $v;
            }
        }
        unset($v);
        foreach ($comments as $k => $v)
        {
            if ($v['referencia'] !== - 1)
            {
                unset($comments[$k]);
            }
        }

        // CHAMANDO A FUNÇÃO
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
                        echo '<input type="hidden" name="level" value="' . $level . '">';

                        echo '<button type="submit" name="delete">&#10060</button>';
                        echo '<a href=update.php?email=' . $login . '&codigo=' . $info["codigo"] . ' style = "float: right; margin-right: 10px" color: #fff >Editar</a>';
                        echo '</form>';

                    }
                    echo '<br>';

                    echo '<div>';
                    $results8 = $db->query("select group_concat(usuario.nome, ', ') as nome from citacao_usuario join usuario on usuario.email = citacao_usuario.usuario_marcado where interacao = '" . $info["codigo"] . "'");
                    while ($row8 = $results8->fetchArray())
                    {
                        if ($row8["nome"] != "")
                        {
                            echo 'Citou ' . ucwords(strtolower($row8["nome"]));
                        }
                        else
                        {
                            echo '';
                        }
                        // echo $row6["grupo"];
                        
                    }
                    echo '</div>';

                    //
                    echo '<br>';
                    echo $info["tipo"] == 'CURTIR' ? ucwords(strtolower($info["usuario"])) . ' curtiu' . '<br>' : ucwords(strtolower($info["usuario"])) . ' compartilhou' . '<br>';

                    echo '<div id = data>';
                    echo date("d/m/Y H:i:s", strtotime($info["data"]));
                    echo '<br>';
                    echo ucwords(strtolower($info["cidade"])) . ", ";;
                    echo ucwords(strtolower($info["uf"])) . ", ";
                    echo ucwords(strtolower($info["pais"]));

                    $results5 = $db->query("select group_concat(assunto.nome, ', ') as assunto from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = " . $info["codigo"]);
                    echo $info["grupo"];
                    // MOSTRA OS ASSUNTOS DA INTERACAO
                    while ($row5 = $results5->fetchArray())
                    {
                        echo '<div class = assuntos2>';
                        echo $row5["assunto"];
                        echo '</div>';
                    }
                    echo '</div>';

                    // DENTRO DO FORM É FEITO OS COMENTARIOS
                    echo '<form name="formreacoes" method="post" action="#">';
                    echo '<div>';

                    $results23 = $db->query('select usuario.nome as nome, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais from usuario join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where email = ' . '"' . $login . '"' . '');
                    while ($row23 = $results23->fetchArray())
                    {
                        echo '<input type="hidden" name ="cidadecod" value = ' . $row23['cidadecod'] . '>';
                    }
                    echo '</div>';

                    echo '<input type="hidden" name="codigocoment" value="' . $info["codigo"] . '">';

                    echo '<div>';
                    echo 'Citar: ';
                    echo '<select id="selectcitar' . $info["codigo"] . '" name="' . $info["codigo"] . '">';
                    $resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '" . $login . "'");
                    while ($rowc = $resultsc->fetchArray())
                    {
                        echo "<option value=\"" . $rowc["codigo"] . "\">" . ucwords(strtolower($rowc["nome"])) . "</option>\n";
                    }
                    echo '</select>';
                    echo "<input type=\"button\" id = \"mais\" name = \"citarcoment\" value=\"+\" onclick=\"addcitar1('" . $info["codigo"] . "')\";>";
                    echo "<input type=\"button\" id = \"del\" name = \"delcitarcoment\" value=\"-\" onclick=\"tiracitar1('" . $info["codigo"] . "')\";>";
                    echo '<input type="hidden" id = "arraycita1" name ="arraycita1">';
                    echo '<div id="addcitarc' . $info["codigo"] . '"></div>';
                    echo '</div>';

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

                    echo '<button name = "comentar"type="submit">&#128172</button>';
                    // echo '</form>';
                    

                    // FORM DE CURTIR
                    echo '<button type="submit" name="curtir">&#128077</button>';
                    echo '<input type="hidden" name="codigocoment2" value="' . $info["codigo"] . '">';
                    echo '<input type="hidden" id="arrayt" name ="arrayt">';

                    // COMPARTILHAR
                    echo '<input type="hidden" id="arrayt" name ="arrayt">';
                    echo '<button type="submit" name="compartilhar">&#128257</button>';
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
                        echo '<input type="hidden" name="level" value="' . $level . '">';
                        echo '<button type="submit" name="delete">&#10060</button>';
                        echo '<a href=update.php?email=' . $login . '&codigo=' . $info["codigo"] . ' style = "float: right; margin-right: 40px">Editar</a>';
                        echo '</form>';
                        echo '<br>';

                        echo '<div>';

                        $results6 = $db->query("select grupo.nome as grupo from interacao join grupo on grupo.codigo = interacao.grupo where interacao.codigo = '" . $info["codigo"] . "'");
                        while ($row6 = $results6->fetchArray())
                        {
                            echo 'Postou no grupo ' . $row6["grupo"];
                        }
                        echo '</div>';

                    }

                    echo '<br>';

                    echo '<div>';
                    $results8 = $db->query("select group_concat(usuario.nome, ', ') as nome from citacao_usuario join usuario on usuario.email = citacao_usuario.usuario_marcado where interacao = '" . $info["codigo"] . "'");
                    while ($row8 = $results8->fetchArray())
                    {
                        if ($row8["nome"] != "")
                        {
                            echo 'Citou ' . ucwords(strtolower($row8["nome"]));
                        }
                        else
                        {
                            echo '';
                        }

                    }
                    echo '</div>';

                    echo '<div id = nome>';
                    echo ucwords(strtolower($info["usuario"]));
                    echo '<div id = data>';
                    echo date("d/m/Y H:i:s", strtotime($info["data"]));
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

                    // COMENTAR
                    echo '<form name="formreacoes" method="post" action="#">';
                    echo '<input type="hidden" name="codgrupo" value="' . $info["grupo"] . '">';

                    echo '<input type="hidden" name="codigocoment" value="' . $info["codigo"] . '">';
                    $results23 = $db->query('select usuario.nome as nome, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais from usuario join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where email = ' . '"' . $login . '"' . '');
                    while ($row23 = $results23->fetchArray())
                    {
                        echo '<input type="hidden" name ="cidadecod" value = ' . $row23['cidadecod'] . '>';
                    }

                    echo '<div>';
                    echo 'Citar: ';
                    echo '<select id="selectcitar' . $info["codigo"] . '" name="' . $info["codigo"] . '">';
                    $resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '" . $login . "'");
                    while ($rowc = $resultsc->fetchArray())
                    {
                        echo "<option value=\"" . $rowc["codigo"] . "\">" . ucwords(strtolower($rowc["nome"])) . "</option>\n";
                    }
                    echo '</select>';
                    echo "<input type=\"button\" id = \"mais\" name = \"citarcoment\" value=\"+\" onclick=\"addcitar1('" . $info["codigo"] . "')\";>";
                    echo "<input type=\"button\" id = \"del\" name = \"delcitarcoment\" value=\"-\" onclick=\"tiracitar1('" . $info["codigo"] . "')\";>";
                    echo '<input type="hidden" id = "arraycita1" name ="arraycita1">';
                    echo '<div id="addcitarc' . $info["codigo"] . '"></div>';
                    echo '</div>';

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
                    echo '<button name="comentar" type="submit" >&#128172</button>';

                    // CURTIR
                    echo '<button type="submit" name="curtir">&#128077</button>';
                    echo '<input type="hidden" name="codigocoment2" value="' . $info["codigo"] . '">';
                    echo '<input type="hidden" id="arrayt" name ="arrayt">';
                    // echo '</form>';
                    

                    // COMPARTILHAR
                    echo '<div id = compartilhar>';
                    echo '<input type="hidden" id="arrayt" name ="arrayt">';
                    echo '<button type="submit" name="compartilhar">&#128257</button>';
                    echo '<input type="hidden" name="codigocoment3" value="' . $info["codigo"] . '">';
                    echo '</div>';
                    echo '</form>';

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
        display_comments($comments, 1, $db);
        // display_comments($comments, 1, $db);
        echo '<center>';
        for ($page = 0;$page < ceil($total / $limit);$page++)
        {
            echo (($offset == $page * $limit) ? ($page + 1) : "<a href=\"" . url("offset", $page * $limit, $login) . "\">" . ($page + 1) . "</a>") . " \n";
        }
        echo '</center>';
        echo '<br>';
        echo '<br>';

        echo '</section>';

        $qtdeamigo = $db->query('select distinct count(*) as num
   from amizade 
   where usuario1  = ' . '"' . $login . '"' . '')->fetchArray() ["num"];
        $total2 = $qtdeamigo;

        $orderbyassuntos = (isset($_GET["orderbyassunto"])) ? $_GET["orderbyassunto"] : "email asc";

        $offsetassunto = (isset($_GET["offsetassunto"])) ? max(0, min($_GET["offsetassunto"], $total2 - 1)) : 0;
        $offsetassunto = $offsetassunto - ($offsetassunto % $limitassunto);

        $whereassuntos = array();
        if (isset($_GET["nome"])) $whereassuntos[] = "usuario like '%" . strtr($_GET["nome"], " ", "%") . "%'";
        $whereassuntos = (count($whereassuntos) > 0) ? "where " . implode(" and ", $whereassuntos) : "";

        $resultsF = $db->query('select distinct nome as amigo, a.usuario2 as user2, a.usuario1 as user1, a.ativo as ativo
from amizade as a
left join amizade as b on a.usuario2 = b.usuario2
left join usuario as p on a.usuario2 = p.email
where a.usuario1  = ' . '"' . $login . '"' . '  
' . $whereassuntos . ' order by ' . $orderbyassuntos . ' limit ' . $limitassunto . ' offset ' . $offsetassunto);

        echo '<div>';
        echo '<section class="event">';
        echo '<center>';
        echo '<h3>Lista de amizades</h3>';
        echo '<h6>Clique em um amigo se deseja excluí-lo da sua lista de amizades.</h6>';

        echo '</center>';
        $valueassunto = "";
        if (isset($_GET["nome"])) $valueassunto = $_GET["nome"];
        echo "<center>";
        echo "<h3>Procurar</h3>";
        echo "<input type=\"text\" style=\"margin-top: 7\" id=\"valor1\" name=\"valor1\" value=\"" . $valueassunto . "\" size=\"20\"> \n";

        $parametersassunto = array();
        if (isset($_GET["orderbyassunto"])) $parametersassunto[] = "orderbyassunto=" . $_GET["orderbyassunto"];
        if (isset($_GET["offsetassunto"])) $parametersassunto[] = "offsetassunto=" . $_GET["offsetassunto"];

        if (isset($_GET["nome"]))
        {
            $total2 = $db->query("select count(*) as total from usuario as a left join amizade as b on a.usuario2 = b.usuario2 left join usuario as p on a.usuario2 = p.email " . $whereassuntos)->fetchArray() ["total2"];
        }
        echo "<select id=\"campo\" name=\"campo\">\n";
        echo "<option value=\"nome\"" . ((isset($_GET["nome"])) ? " selected" : "") . ">Nome</option>\n";
        echo "</select>";

        echo "<a href=\"\" id=\"valida\" onclick=\" value = document.getElementById('valor1').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parametersassunto) , " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='feed.php?email=" . $login . "'+((result != '') ? '&' : '')+result;\"> &#x1F50E;</a><br>\n";
        echo "</center>";

        echo "<br>";

        // AMIZADES DO USUÁRIO
        echo '<center>';
        echo "<table id='amigos'>\n";
        /*echo "<td><b>Amigos</b> <a href=\"".url("orderby", "email+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "email+desc")."\">&#x25B4;</a></td>\n";*/
        echo "<td><b>Seus amigos</b> <a href=\"" . urlassunto("orderbyassunto", "nome+asc") . "\">&#x25BE;</a> <a href=\"" . urlassunto("orderbyassunto", "nome+desc") . "\">&#x25B4;</a></td>\n";
        echo "</tr>\n";
        echo '</center>';
        //echo '<br>';
        while ($rowF = $resultsF->fetchArray())
        {

            echo '<tr>';
            echo '<center>';
            echo '<td>' . ($rowF["ativo"] == 0 ? "" : "<a href=\"delete_amizade.php?usuario1=" . $login . "&usuario2=" . $rowF["user2"] . "\" onclick=\"return(confirm('Excluir " . ucwords(strtolower($rowF["amigo"])) . " da sua lista de amizades?'));\">" . " &#128100 " . ucwords(strtolower($rowF["amigo"])) . "</a>") . '</td>';
            echo '</center>';
            echo '</tr>';

        }
        echo '</table>';
        for ($page = 0;$page < ceil($totalassunto / $limitassunto);$page++)
        {
            echo (($offsetassunto == $page * $limitassunto) ? ($page + 1) : "<a href=\"" . urlassunto("offsetassunto", $page * $limitassunto) . "\">" . ($page + 1) . "</a>") . " \n";
        }

        echo '</section>';

        $qtdesugestao = $db->query(' select distinct COUNT(usuario.nome) as num
from
    (select usuario, count(nome) as qt, nome
    from
        (select usuario, assunto.nome, conteudo, hora_post
            from interacao
              join assunto_interacao on assunto_interacao.interacao = interacao.codigo
           join assunto on assunto_interacao.assunto = assunto.codigo)
    where usuario not in
    (select usuario2
        from amizade
            join usuario on usuario.email = usuario1
        where usuario1 = ' . '"' . $login . '"' . ') and usuario != ' . '"' . $login . '"' . '
    group by 1, 3
    having qt in 
(select max(qt)
        from(
select usuario, count(nome) as qt, nome
            from
                (                    select usuario, assunto.nome, conteudo
                    from interacao
                        join assunto_interacao on assunto_interacao.interacao = interacao.codigo
           join assunto on assunto_interacao.assunto = assunto.codigo)
            group by 1, 3
            order by 1, qt desc)
        group by usuario, nome
        order by 1 desc
        limit 10) and nome in
(select nome
        from
            (select usuario, count(nome) as qt, nome
            from
                (                            select usuario, assunto.nome, conteudo
                    from interacao
                        join assunto_interacao on assunto_interacao.interacao = interacao.codigo
           join assunto on assunto_interacao.assunto = assunto.codigo
        where usuario = ' . '"' . $login . '"' . ')
            group by 1, 3
            order by 1, qt desc) limit 5)
    order by 1, qt desc)
    join usuario on usuario = usuario.email;')->fetchArray() ["num"];

        $total2 = $qtdesugestao;

        $orderbyassuntos = (isset($_GET["orderbyassunto"])) ? $_GET["orderbyassunto"] : "email asc";

        $offsetassunto = (isset($_GET["offsetassunto"])) ? max(0, min($_GET["offsetassunto"], $total2 - 1)) : 0;
        $offsetassunto = $offsetassunto - ($offsetassunto % $limitassunto);

        $whereassuntos = array();
        if (isset($_GET["sugestao"])) $whereassuntos[] = "usuario like '%" . strtr($_GET["sugestao"], " ", "%") . "%'";
        $whereassuntos = (count($whereassuntos) > 0) ? "where " . implode(" and ", $whereassuntos) : "";

        echo '<section class="sugestoes">';

        $valueassunto = "";
        if (isset($_GET["sugestao"])) $value = $_GET["sugestao"];
        echo "<center>";
        echo "<h3>Procurar sugestões</h3>";
        echo "<input type=\"text\" style=\"margin-top: 7\" id=\"valor1\" name=\"valor1\" value=\"" . $valueassunto . "\" size=\"20\"> \n";

        if (isset($_GET["sugestao"]))
        {
            $total2 = $db->query("select count(*) as total from usuario  " . $whereassuntos)->fetchArray() ["total2"];
        }

        echo "<select id=\"campo\" name=\"campo\">\n";
        echo "<option value=\"nome\"" . ((isset($_GET["sugestao"])) ? " selected" : "") . ">Nome</option>\n";
        echo "</select>";

        $parametersassunto = array();
        if (isset($_GET["orderbyassunto"])) $parametersassunto[] = "orderbyassunto=" . $_GET["orderbyassunto"];
        if (isset($_GET["offsetassunto"])) $parametersassunto[] = "offsetassunto=" . $_GET["offsetassunto"];

        echo "<a href=\"\" id=\"valida\" onclick=\" value = document.getElementById('valor1').value.trim().replace(/ +/g, '+'); result = '" . strtr(implode("&", $parametersassunto) , " ", "+") . "'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='feed.php?email=" . $login . "'+((result != '') ? '&' : '')+result;\"> &#x1F50E;</a><br>\n";
        echo "</center>";

        echo "<br>";

        $resultsS = $db->query('select distinct usuario.nome as sugestao, email
from
    (select usuario, count(nome) as qt, nome
    from
        (select usuario, assunto.nome, conteudo, hora_post
            from interacao
              join assunto_interacao on assunto_interacao.interacao = interacao.codigo
           join assunto on assunto_interacao.assunto = assunto.codigo)
    where usuario not in
    (select usuario2
        from amizade
            join usuario on usuario.email = usuario1
        where usuario1 = ' . '"' . $login . '"' . ') and usuario != ' . '"' . $login . '"' . '
    group by 1, 3
    having qt in 
(select max(qt)
        from(
select usuario, count(nome) as qt, nome
            from
                (                    select usuario, assunto.nome, conteudo
                    from interacao
                        join assunto_interacao on assunto_interacao.interacao = interacao.codigo
           join assunto on assunto_interacao.assunto = assunto.codigo)
            group by 1, 3
            order by 1, qt desc)
        group by usuario, nome
        order by 1 desc
        limit 10) and nome in
(select nome
        from
            (select usuario, count(nome) as qt, nome
            from
                (                            select usuario, assunto.nome, conteudo
                    from interacao
                        join assunto_interacao on assunto_interacao.interacao = interacao.codigo
           join assunto on assunto_interacao.assunto = assunto.codigo
        where usuario = ' . '"' . $login . '"' . ')
            group by 1, 3
            order by 1, qt desc) limit 5)
    order by 1, qt desc)
    join usuario on usuario = usuario.email;' . $whereassuntos . ' order by ' . $orderbyassuntos . ' limit ' . $limitassunto . ' offset ' . $offsetassunto);

        echo '<table id="sugestoes">';
        echo "<td><b>Sugestões de amizade</b> <a href=\"" . urlassunto("orderbyassunto", "1+asc") . "\">&#x25BE;</a> <a href=\"" . urlassunto("orderbyassunto", "1+desc") . "\">&#x25B4;</a></td>\n";

        echo "</tr>\n";
        while ($rowS = $resultsS->fetchArray())
        {
            echo '<center>';
            echo '<tr>';
            echo '<td>' . "<a href=\"adicionarAmigo.php?usuario1=" . $login . "&usuario2=" . $rowS["email"] . "\" onclick=\"return(confirm('Adicionar " . ucwords(strtolower($rowS["sugestao"])) . " na sua lista de amizades?'));\">" . " &#128100 " . ucwords(strtolower($rowS["sugestao"])) . "</a>" . '</td>';
            echo '<tr>';
            echo '</center>';
        }
        echo '</table>';

        for ($page = 0;$page < ceil($total2 / $limitassunto);$page++)
        {
            echo (($offsetassunto == $page * $limitassunto) ? ($page + 1) : "<a href=\"" . urlassunto("offsetassunto", $page * $limitassunto) . "\">" . ($page + 1) . "</a>") . " \n";
        }
        echo '</section>';

        echo '</main>';
        echo '</div>';

        $total = $db->query("select count(*) as total from interacao")
            ->fetchArray() ["total"];
        if (isset($_POST['postar']))
        {
            // echo $_POST["selectgrupo"];
            $x = $_POST['array'];
            $valores = explode(",", $x);
            $b = $_POST['arraycita'];
            $citacao = explode(",", $b);
            echo $_POST["cidadecod1"];
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
                if ($_POST["selectgrupo"] !== '0')
                {
                    $db->exec("insert into interacao (codigo, usuario, tipo, cidade, grupo, conteudo) values ($total, '" . $login . "', 'POST',  '" . $_POST["cidadecod1"] . "', " . $_POST["selectgrupo"] . ", '" . $post_content . "')");
                    if (!empty($_POST['array']))
                    {
                        for ($i = 0;$i < count($valores);$i++)
                        {
                            $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                        }
                    }

                    if (!empty($_POST['arraycita']))
                    {
                        for ($i = 1;$i < count($citacao);$i++)
                        {
                            $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('" . $citacao[$i] . "', $total)");
                        }
                    }
                    echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                }
                else
                {
                    $db->exec("insert into interacao (codigo, usuario, tipo, cidade, conteudo) values ($total, '" . $login . "', 'POST', '" . $_POST["cidadecod1"] . "', '" . $post_content . "')");
                    if (!empty($_POST['array']))
                    {
                        for ($i = 0;$i < count($valores);$i++)
                        {
                            $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                        }
                    }

                    if (!empty($_POST['arraycita']))
                    {
                        for ($i = 0;$i < count($citacao);$i++)
                        {
                            $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('" . $citacao[$i] . "', $total)");
                        }
                    }
                    echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
                }
            }
        }
        if (isset($_POST['comentar']))
        {
            $a = $_POST['arrayt'];
            $b = $_POST['arraycita1'];
            $citacao = explode(",", $b);

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
                if (isset($_POST['codgrupo']))
                {
                    $db->exec("insert into interacao(codigo, usuario, tipo, cidade, grupo, conteudo, referencia) values ($total, '" . $login . "', 'COMENTARIO', '" . $_POST["cidadecod"] . "', '" . $_POST["codgrupo"] . "', '" . $comment_content . "', " . $_POST['codigocoment'] . ")");
                    if (!empty($_POST['arrayt']))
                    {
                        for ($i = 0;$i < count($valores);$i++)
                        {
                            $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                        }
                    }
                    if (!empty($_POST['arraycita1']))
                    {
                        for ($i = 0;$i < count($citacao);$i++)
                        {
                            $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('" . $citacao[$i] . "', $total)");
                        }
                    }
                }
                $db->exec("insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values ($total, '" . $login . "', 'COMENTARIO', '" . $_POST["cidadecod"] . "', '" . $comment_content . "', " . $_POST['codigocoment'] . ")");
                if (!empty($_POST['arrayt']))
                {
                    for ($i = 0;$i < count($valores);$i++)
                    {
                        $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                    }
                }
                if (!empty($_POST['arraycita1']))
                {
                    for ($i = 0;$i < count($citacao);$i++)
                    {
                        $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('" . $citacao[$i] . "', $total)");
                    }
                }

            }
            echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
        }
        if (isset($_POST['curtir']))
        {
            $total = $total + 1;
            $b = $_POST['arraycita1'];
            $citacao = explode(",", $b);
            $x = $_POST['arrayt'];
            $valores = explode(",", $x);
            $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '" . $login . "', 'CURTIR', '" . $_POST["cidadecod"] . "', " . $_POST['codigocoment2'] . ")");
            if (!empty($_POST['arrayt']))
            {
                for ($i = 0;$i < count($valores);$i++)
                {
                    $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                }
            }
            if (!empty($_POST['arraycita1']))
            {
                for ($i = 0;$i < count($citacao);$i++)
                {
                    $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('" . $citacao[$i] . "', $total)");
                }
            }
            echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
        }
        if (isset($_POST['compartilhar']))
        {
            $total++;
            $b = $_POST['arraycita1'];
            $citacao = explode(",", $b);
            $x = $_POST['arrayt'];
            $valores = explode(",", $x);
            $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '" . $login . "', 'COMPARTILHAMENTO', '" . $_POST["cidadecod"] . "', " . $_POST['codigocoment3'] . ")");
            if (!empty($_POST['arrayt']))
            {
                for ($i = 0;$i < count($valores);$i++)
                {
                    $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
                }
            }
            if (!empty($_POST['arraycita1']))
            {
                for ($i = 0;$i < count($citacao);$i++)
                {
                    $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('" . $citacao[$i] . "', $total)");
                }
            }
            echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
        }
        if (isset($_POST['delete']))
        {
            // echo $_POST["level"];
            $teste = [];
            $delete = $db->query("select codigo, tipo, referencia from interacao where ativo = 1 and referencia = " . $_POST["codigo"]);
            while ($row = $delete->fetchArray())
            {
                $teste = $row["codigo"];
                $delete2 = $db->query("select codigo, tipo, referencia from interacao where ativo = 1 and referencia = " . $row["referencia"]);
                while ($row2 = $delete2->fetchArray())
                {
                    $db->exec("update interacao set ativo = 0 where codigo = " . $row2["codigo"]);
                    $db->exec("update interacao set ativo = 0 where referencia = " . $row2["codigo"]);
                    $db->exec("update assunto_interacao set ativo = 0 where interacao = " . $row2["codigo"]);
                    $db->exec("update citacao_usuario set ativo = 0 where interacao = " . $row2["codigo"]);

                }
            }
            $db->exec("update interacao set ativo = 0 where codigo = " . $_POST["codigo"]);
            $db->exec("update interacao set ativo = 0 where referencia = " . $_POST["codigo"]);
            $db->exec("update assunto_interacao set ativo = 0 where interacao = " . $_POST["codigo"]);
            $db->exec("update citacao_usuario set ativo = 0 where interacao = " . $row2["codigo"]);

            echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";

        }

        if (isset($_POST['adicionar']))
        {
            $total2 = $db->query("select count(codigo) as total2 from assunto")
                ->fetchArray() ["total2"];
            $total2++;
            $db->exec("insert into assunto(codigo, nome) values ($total2, '" . $_POST['outra'] . "')");
            echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";

        }
    }
    else
    {
        echo 'erro ao entrar no feed, faça login novamente';
    }
}
else
{
    echo 'erro ao entrar no feed, faça login novamente';
}
$db->close();
?>

</body>
<script type="text/javascript" src="funcoes.js"></script>

</html>
