<html>

<body>
  <style>
     @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');
    html,
    body {
      background: #e9ebee;
      height: 100%;
      margin: 0;
    }

    a:link {
      text-decoration: none;
    }

    a:visited {
      text-decoration: none;
    }

    a:hover {
      text-decoration: none;
    }

    a:active {
      text-decoration: none;
    }

    * {
      font-family: Raleway, sans-serif;
    }

    .container-box {
      width: 100%;
      height: 100%;
      display: grid;
      grid-template-columns: auto 200px;
      grid-template-rows: 40px 1fr;
      grid-template-areas:
        'header header'
        'main aside'
        'footer footer'
      ;
    }
button{
  float: left;
}
    .header {
      grid-area: header;
      background: linear-gradient(270deg, #5D54A4, #6A679E);
    }

    .main {
      grid-area: main;
      display: grid;
      grid-template-columns: 150px minmax(100px, 1fr) 200px;
      grid-template-rows: auto;
      grid-template-areas: 'menu feed event sugestoes';
      grid-gap: 10px;
      padding: 10px 40px;
    }

    .aside {
      grid-area: aside;
      border-left: 2px solid #ccc;
    }

    .menu {
      grid-area: menu;
      background: #fff;
    }

    .feed {
      grid-area: feed;
      background: #fff;
    }

    .event {
      grid-area: event;
      background: #fff;
      padding-top: 0.25%;
      height: max-content;
    }
    .sugestoes {

      grid-area: sugestoes;
      background: #fff;
      height: max-content;
    }


/*
    .coluna {
      float: left;
  width: 33.33%;
    }*/

   /* .coluna section {
  text-align: center;
	background-color: white;
	width: 90%;
	padding: 15px;
	margin-bottom: 5px;
	opacity: 0.8;
	display: inline-block;
	text-align: left;
  vertical-align: top;
    }*/
    .post {
      flex-wrap: wrap;
      padding-top: 80px;
      padding-right: 80px;

      padding-left: 80px;

      font-size: 16px;
      font-family: Calibri;
      /* border-left: solid;
    border-color: #5D54A4; */

      margin-bottom: 30px;
      /* border-width: 6px; */


    }

    .comentarios {
      flex-wrap: wrap;
      padding-top: 20px;
      padding-right: 20px;

      padding-left: 20px;
      padding-bottom: 20px;

      /* padding-bottom: 20px; */
      font-size: 14px;
      font-family: Calibri;
      /* border: solid;
    border-color: #000; */
      /* border-radius: px; */
      background-color: #ECEAFC;
      margin-bottom: 5px;
      margin-top: 5px;
      /* margin-left: 10px; */
      /* margin-right: 10px; */


      /* border-width: 3px;  */


    }

    #comentarios2 {
      padding: 50px;
      padding-top: 20px;
      padding-bottom: 20px;
      font-size: 14px;
      font-family: Calibri;
      /* border: solid;
    border-color: #000; */
      /* border-radius: px; */
      background-color: #dbd7fc;
      margin-bottom: 10px;
      /* border-width: 3px;  */


    }

    #postar {
      padding: 80px;
      font-size: 16px;
      font-family: Calibri;
      border-left: solid;
      border-color: #5D54A4;
      margin-bottom: 30px;
      border-width: 6px;


    }

    #nome {
      font-weight: bold;
      padding: 20px;
      font-size: 18px;

    }

    #data {
      font-size: 12px;
      font-weight: normal;
    }

    .reactions {
      padding-top: 20px;
      padding-right: 20px;

      padding-left: 20px;
      padding-bottom: 20px;

      /* margin-bottom: 10px; */
      /* margin-top: 10px; */
      margin-left: 10px;
      margin-right: 10px;
      background-color: #5D54A4;
      color: #fff
    }

    .reactions2 {
      /* margin-top: 30px; */
      background-color: #5D54A4;
      color: #fff
    }

    #coment {
      margin-top: 30px;
    }

    .conteudo {
      padding: 10px;
      /* border: solid; */
      /* border-color: #000;  */
      /* border-radius: 17px;  */
      /* border-width:1px;  */

    }

    #assuntos {
      color: #5D54A4;
    }

    .assuntos2 {
      color: #fff;
    }

    #add {
      color: #5D54A4;
    }

    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      /* Stay in place */
      z-index: 1;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      /* Full width */
      height: 100%;
      /* Full height */
      overflow: auto;
      /* Enable scroll if needed */
      background-color: rgb(0, 0, 0);
      /* Fallback color */
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      /* 15% from the top and centered */
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      /* Could be more or less, depending on screen size */
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
    #amigos {
  border-collapse: collapse;
  width: 95%;
    }
  </style>
  <?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");
// $nome = $_POST['nome'];
// $email = $_POST['email'];

// echo strtoupper($email);

$login = $_GET['email'];
$nome = $login;
//echo $nome;
//  if(isset($login)){

echo '<div class="container-box">';
echo '<header class="header"></header>';
echo '<main class="main">';
echo '<section class="menu">';
if (isset($_POST["descricao"])) {
    $var;
    foreach ($_POST as $indice => $item) {
        if ($indice == "pagina") {
            $var = "pagina";
            $valor = $_POST[$indice];
            break;
        } else if ($indice == "grupo") {
            $valor = $_POST[$indice];
            $var = "grupo";
            break;
        }
    }
    $testenome = $db->query("select nome from $var where nome = '$valor'")->fetchArray()['nome'];
    if ($testenome == null || $testenome != $valor) {
        $db->exec("insert into $var (nome, descricao) values ('" . $valor . "','" . $_POST["descricao"] . "')");
        $codigogrupag = $db->query("select codigo from $var where nome = '$valor'")->fetchArray()['codigo'];
        // VALIDAR SE ESTÁ ERRADO OU NÃO
        $db->exec("insert into " . $var . "_usuario (usuario, $var, adm) values ('" . $_POST["usuario"] . "', $codigogrupag, 1)");
        // PROBLEMA COM A CHAVE ESTRANGEIRA (não aceita usuarios naõ existentes)
        echo " $var criado com sucesso";
    } else {
        header('Location: /feed.php?email=' . $login . '&error=nome ja existente');
    }
}
if (isset($_GET['excluir'])) {
    $arrayexcluir = explode('_', $_GET['excluir']);
    $codigoitem = $arrayexcluir[0];
    $item = $arrayexcluir[1];
    $db->exec("update " . $item . "_usuario set ativo = 0 where $item = $codigoitem and usuario = '$login'");
}
if (isset($_POST['campo']) && isset($_POST['pesquisa'])) {
    $selectpesquisa = $db->query("select nome, codigo from " . $_POST['pesquisa'] . " where nome like '%" . $_POST['campo'] . "%'");
    $arraypesquisa = [];
    $cont = 0;
    while ($rowpesquisa = $selectpesquisa->fetchArray()) {
        $arraypesquisa[$cont] = $rowpesquisa['nome'];
        $cont++;
        $arraypesquisa[$cont] = $rowpesquisa['codigo'];
        $cont++;
    }
}
if (isset($_GET['error'])) {
    echo "<h5>" . $_GET['error'] . "</h5>";
}
echo "<h3>Criar Grupo ou Página</h3>";
echo "<button onclick=\"paginaGrupo('grupo', '" . $login . "')\">Grupo</button>";
echo "<button onclick=\"paginaGrupo('pagina', '" . $login . "')\">Pagina</button>";
echo "<div id=\"formulario\"></div>";
echo "<div><h3>Meus Grupos</h3></div>";
$meusgrupos = $db->query("select grupo.nome, grupo.codigo from grupo join grupo_usuario on grupo_usuario.grupo = grupo.codigo join usuario on usuario.email = grupo_usuario.usuario where usuario.email = '" . $login . "' and grupo_usuario.ativo = 1");
while ($row = $meusgrupos->fetchArray()) {
    echo $row['nome'] . ' <a href="feed.php?email=' . $login . '&excluir=' . $row['codigo'] . '_grupo">Sair</a> <br>';
}
echo "<div><h3>Minhas páginas</h3></div>";
$minhaspaginas = $db->query("select pagina.nome, pagina.codigo from pagina join pagina_usuario on pagina_usuario.pagina = pagina.codigo join usuario on usuario.email = pagina_usuario.usuario where usuario.email = '" . $login . "' and pagina_usuario.ativo = 1");
while ($row2 = $minhaspaginas->fetchArray()) {
    echo 'teste';
    echo $row2['nome'] . ' <a href="feed.php?email=' . $login . '&excluir=' . $row2['codigo'] . '_pagina">Sair</a> <br>';
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
if (isset($arraypesquisa) && $arraypesquisa != null) {
    echo "<table>";
    for ($contp = 0; $contp < count($arraypesquisa); $contp = $contp + 2) {
        echo "<tr><td>" . $arraypesquisa[$contp] . "</td><td>Entrar/Sair</td></tr>";
    }
    echo "</table>";
}


function url($campo, $valor) {
  $result = array();
  if (isset($_GET["nome"])) $result["nome"] = "nome=".$_GET["nome"];
  if (isset($_GET["sugestao"])) $result["sugestao"] = "sugestao=".$_GET["sugestao"];
  if (isset($_GET["mes"])) $result["mes"] = "mes=".$_GET["mes"];
  if (isset($_GET["assunto"])) $result["assunto"] = "assunto=".$_GET["assunto"];
  if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
  if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
  $result[$campo] = $campo."=".$valor;
  return("feed.php?email=".$_GET["email"]."&".strtr(implode("&", $result), " ", "+"));
}

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
$limit = 5;

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
group by 1, ano, mes order by mes, qt desc;")->fetchArray()["num"];
$total = $qtdeassunto;


//TOP ASSUNTOS!!!
$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "codigo asc";
$where = array();

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
group by 1, ano, mes order by mes, qt desc;
");

if (isset($_GET["mes"])) {
	$total = $db->query("select count(case strftime('%m', interacao.hora_post)
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
                     where pais.nome = 'BRASIL' ".$where)->fetchArray()["total"];
}

if (isset($_GET["assunto"])) {
	$total = $db->query("select count(case strftime('%m', interacao.hora_post)
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
                     where pais.nome = 'BRASIL' ".$where)->fetchArray()["total"];
}

echo '<h3>TOP ASSUNTOS<h3>';
echo "<table border=\"1\">\n";
echo "<tr>\n";
echo "<td><b>Mês</b> <a href=\"".url("orderby", "mes+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "mes+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Assunto</b> <a href=\"".url("orderby", "assunto+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "assunto+desc")."\">&#x25B4;</a></td>\n";
echo "<td></td>\n";
echo "</tr>\n";
while($rowT = $resultsT->fetchArray()) {
  echo "<tr>\n";
  echo "<td>".$rowT["mes"]."</td>\n";
  echo "<td>".$rowT["nome"]."</td>\n";
  echo '</tr>';
}
echo '</table>';










echo '</section>';
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







   $qtdeamigo = $db->query('select distinct count(*) as num
   from amizade 
   where usuario1  = ' . '"' . $login . '"' . '' )->fetchArray()["num"];
            $total = $qtdeamigo;

            $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "email asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);

$where = array();
if (isset($_GET["nome"])) $where[] = "usuario like '%".strtr($_GET["nome"], " ", "%")."%'";
$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";


$resultsF = $db->query('select distinct nome as amigo, a.usuario2 as user2, a.usuario1 as user1, a.ativo as ativo
from amizade as a
left join amizade as b on a.usuario2 = b.usuario2
left join usuario as p on a.usuario2 = p.email
where a.usuario1  = ' . '"' . $login . '"' . '  
' . $where . ' order by ' . $orderby . ' limit ' . $limit . ' offset ' . $offset);


echo '<div>';
echo '<section class="event">';
echo '<center>';
echo '<h3>Lista de amizades</h3>';
echo '<h6>Clique em um amigo se deseja excluí-lo da sua lista de amizades.</h6>';

echo '</center>';
$value = "";
if (isset($_GET["nome"])) $value = $_GET["nome"];
echo "<center>";
echo "<h3>Procurar</h3>";
echo "<input type=\"text\" style=\"margin-top: 7\" id=\"valor1\" name=\"valor1\" value=\"".$value."\" size=\"20\"> \n";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];

if (isset($_GET["nome"])) {
	$total = $db->query("select count(*) as total from usuario as a left join amizade as b on a.usuario2 = b.usuario2 left join usuario as p on a.usuario2 = p.email ".$where)->fetchArray()["total"];
}
echo "<select id=\"campo\" name=\"campo\">\n";
echo "<option value=\"nome\"".((isset($_GET["nome"])) ? " selected" : "").">Nome</option>\n";
echo "</select>";

echo "<a href=\"\" id=\"valida\" onclick=\" value = document.getElementById('valor1').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='feed.php?email=".$login."'+((result != '') ? '&' : '')+result;\"> &#x1F50E;</a><br>\n";
echo "</center>";

echo "<br>";

// AMIZADES DO USUÁRIO

echo '<center>';
echo "<table id='amigos'>\n";
/*echo "<td><b>Amigos</b> <a href=\"".url("orderby", "email+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "email+desc")."\">&#x25B4;</a></td>\n";*/
echo "<td><b>Seus amigos</b> <a href=\"".url("orderby", "nome+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "nome+desc")."\">&#x25B4;</a></td>\n";
echo "</tr>\n";
echo '</center>';
//echo '<br>';
while ($rowF = $resultsF->fetchArray()) {

    echo '<tr>';
    echo '<center>';
    echo '<td>'.($rowF["ativo"] == 0 ? "" : "<a href=\"delete_amizade.php?usuario1=" . $login . "&usuario2=" . $rowF["user2"] . "\" onclick=\"return(confirm('Excluir " . ucwords(strtolower($rowF["amigo"])) . " da sua lista de amizades?'));\">" . " &#128100 " . ucwords(strtolower($rowF["amigo"])) . "</a>").'</td>';
    echo '</center>';
    echo '</tr>';

}
echo '</table>';
for ($page = 0; $page < ceil($total/$limit); $page++) {
	echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit)."\">".($page+1)."</a>")." \n";
}


echo '</section>';







//SUGESTOES DE AMIZADE


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
    join usuario on usuario = usuario.email;')->fetchArray()["num"];

            $total = $qtdesugestao;

            $orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "email asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);

$where = array();
if (isset($_GET["sugestao"])) $where[] = "usuario like '%".strtr($_GET["sugestao"], " ", "%")."%'";
$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";


echo '<section class="sugestoes">';

$value = "";
if (isset($_GET["sugestao"])) $value = $_GET["sugestao"];
echo "<center>";
echo "<h3>Procurar sugestões</h3>";
echo "<input type=\"text\" style=\"margin-top: 7\" id=\"valor1\" name=\"valor1\" value=\"".$value."\" size=\"20\"> \n";

if (isset($_GET["sugestao"])) {
	$total = $db->query("select count(*) as total from usuario  ".$where)->fetchArray()["total"];
}

echo "<select id=\"campo\" name=\"campo\">\n";
echo "<option value=\"nome\"".((isset($_GET["sugestao"])) ? " selected" : "").">Nome</option>\n";
echo "</select>";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];

echo "<a href=\"\" id=\"valida\" onclick=\" value = document.getElementById('valor1').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='feed.php?email=".$login."'+((result != '') ? '&' : '')+result;\"> &#x1F50E;</a><br>\n";
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
    join usuario on usuario = usuario.email;' . $where . ' order by ' . $orderby . ' limit ' . $limit . ' offset ' . $offset);

    echo '<table id="sugestoes">';
    echo "<td><b>Sugestões de amizade</b> <a href=\"".url("orderby", "sugestao+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "sugestao+desc")."\">&#x25B4;</a></td>\n";
    echo "</tr>\n";
while ($rowS = $resultsS->fetchArray()) {
  echo '<center>';
  echo '<tr>';
  echo '<td>'."<a href=\"adicionarAmigo.php?usuario1=" . $login . "&usuario2=" . $rowS["email"] . "\" onclick=\"return(confirm('Adicionar " . ucwords(strtolower($rowS["sugestao"])) . " na sua lista de amizades?'));\">" . " &#128100 " . ucwords(strtolower($rowS["sugestao"])) . "</a>".'</td>';
  echo '<tr>';
  echo '</center>';
}
echo '</table>';


for ($page = 0; $page < ceil($total/$limit); $page++) {
	echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit)."\">".($page+1)."</a>")." \n";
}
echo'</section>';
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

?>

</body>
<script>
 		let options1 = []
  	let options = []
      	let guardar = []


function add(){
		let select1 = document.querySelector("#selectassuntos");
  let select = document.getElementById("selectassuntos").value;
  let option = select1.options[select1.selectedIndex].value;
  let add = document.getElementById("add")

  	if(options.indexOf(option) !== -1) {
			alert("Assunto já inserido");
			return;
		}else{
    
  options.push(select);
  add.innerHTML +=  " - "+select1[options[options.length-1]-1].text + " - ";
  document.getElementById("array").setAttribute('value', options );
    }
}



function add1(num){
  let select = document.getElementById("selectassuntos"+num).value
  let select1 = document.querySelector("#selectassuntos"+num)
  let mais = document.querySelectorAll("#mais")[num];
  let add = document.getElementById("add"+num);
  let b= document.querySelectorAll("#arrayt").length;
  let c = document.querySelectorAll("#arrayt");
  let option = select1.options[select1.selectedIndex].value;

  
  
  if(guardar !== select1.name){
    let add2 = document.getElementById("add"+guardar);
    add2.innerHTML =  "";
    options1 = []
  }

  guardar=select1.name;

		if(options1.indexOf(option) !== -1) {
			alert("Assunto já inserido");
			return;
		}else{
    
  // console.log(add)
  // console.log(guardar)
  options1.push(option);
  for (i = 0; i <b; i++){
     c[i].setAttribute('value', options1 )
      // console.log(c[i])
  }

  add.innerHTML +=  " - "+select1[options1[options1.length-1]-1].text + " - ";
}
  // select1.options[select1.selectedIndex].text
}


	function tira(that){
    let c = document.querySelectorAll("#arrayt");
    let select = document.getElementById("selectassuntos"+that).value
    let select1 = document.querySelector("#selectassuntos"+that)
    let option = select1.options[select1.selectedIndex].value;
    let b= document.querySelectorAll("#arrayt").length;
    let add = document.getElementById("add"+that);
  console.log(option)
  options1=[]
  add.removeChild(add.lastChild)
  console.log(options1)
  for (i = 0; i <b; i++){
    c[i].setAttribute('value', options1 )
  }
	};


  	function tira1(that){
  let select1 = document.querySelector("#selectassuntos")
  let select = document.getElementById("selectassuntos").value
  let add = document.getElementById("add")

  options=[]
  add.innerHTML = "";

	};
</script>

</html>