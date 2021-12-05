<html>

<body>
  <style>
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
      /* grid-template-columns: auto 100px; */
      grid-template-rows: 40px 1fr;
      grid-template-areas:
        'header header'
        'main aside'
        'footer footer'
      ;
    }
/* button{
  float: left;
} */
    .header {
      grid-area: header;
      background: linear-gradient(270deg, #5D54A4, #6A679E);
    }

    .main {
      
      grid-area: main;
      display: grid;
      grid-template-columns: 260px minmax(100px, 1fr) 280px;
      grid-template-rows: auto;
      grid-template-areas: 'menu feed event';
      grid-gap: 10px;
      padding: 10px 70px;
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
    }
.post>button {
  float: left;
}

.comentario>button {
  float: left;
}


    .post {
      flex-wrap: wrap;
      padding-top: 80px;
      padding-right: 80px;

      padding-left: 80px;

      font-size: 16px;
      font-family: Calibri;
      border-left: solid;
    border-color: #5D54A4;

      margin-bottom: 30px;
      /* border-width: 6px; */


    }
form>button{
  float: left;
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
    .reactions>button {
      /* margin-top: 30px; */
      float: left;
      
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
  </style>
  <?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");
// $nome = $_POST['nome'];
// $email = $_POST['email'];

// echo strtoupper($email);

   function url($campo, $valor, $login) {
            $result = array();
            if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
            if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
            if (isset($_GET["nome"])) $result["nome"] = "nome=".$_GET["nome"];
	          if (isset($_GET["palavra"])) $result["palavra"] = "palavra=".$_GET["palavra"];
	          if (isset($_GET["data"])) $result["data"] = "data=".$_GET["data"];
            if (isset($_GET["grupo"])) $result["grupo"] = "grupo=".$_GET["grupo"];

            $result[$campo] = $campo."=".$valor;
            return("feed.php?email=".$login."&".strtr(implode("&", $result), " ", "+"));
        }

        $parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
$limit = 5;
   $qtdepost = $db->query("select count(*) as num from interacao where ativo = 1")->fetchArray()["num"];
            $total = $qtdepost;
$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "data asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);

            

$login = $_GET['email'];
$nome = $login;
//echo $nome;
//  if(isset($login)){

echo '<div class="container-box">';
echo '<header class="header">';
echo '<center>';



$value = "";
if (isset($_GET["nome"])) $value = $_GET["nome"];
if (isset($_GET["palavra"])) $value = $_GET["palavra"];
if (isset($_GET["data"])) $value = $_GET["data"];
if (isset($_GET["grupo"])) $value = $_GET["grupo"];

echo "<input type=\"text\" style=\"margin-top: 7\" id=\"valor1\" name=\"valor1\" value=\"".$value."\" size=\"70\"> \n";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];

$where = array();
if (isset($_GET["nome"])) $where[] = "usuario like '%".strtr($_GET["nome"], " ", "%")."%'";
if (isset($_GET["palavra"])) $where[] = "conteudo like '%".strtr($_GET["palavra"], " ", "%")."%'";
if (isset($_GET["data"])) $where[] = "strftime('%d/%m/%Y', data) like '%".strtr($_GET["data"], " ", "%")."%'";
if (isset($_GET["grupo"])) $where[] = "grupo='".$_GET["grupo"]."'";

$where = (count($where) > 0) ? "where ".implode(" and ", $where) : "";


if (isset($_GET["nome"])) {
	$total = $db->query("select count(usuario) as total from interacao join usuario on interacao.usuario = usuario.email ".$where)->fetchArray()["total"];
}


if (isset($_GET["data"])) {
	$total = $db->query("select hora_post as data, count(*) as total from interacao ".$where)->fetchArray()["total"];
}

if (isset($_GET["palavra"])) {
	$total = $db->query("select count(conteudo) as total from interacao ".$where)->fetchArray()["total"];
}
if (isset($_GET["grupo"])) {
	$total = $db->query("select count(grupo) as total from interacao ".$where)->fetchArray()["total"];
}

echo "<select id=\"campo\" name=\"campo\">\n";
echo "<option value=\"nome\"".((isset($_GET["nome"])) ? " selected" : "").">Nome</option>\n";
echo "<option value=\"palavra\"".((isset($_GET["palavra"])) ? " selected" : "").">Palavra</option>\n";
echo "<option value=\"data\"".((isset($_GET["data"])) ? " selected" : "").">Data</option>\n";
echo "<option value=\"grupo\"".((isset($_GET["grupo"])) ? " selected" : "").">Grupo</option>\n";

echo "</select>";
echo "<a href=\"\" id=\"valida\" onclick=\" value = document.getElementById('valor1').value.trim().replace(/ +/g, '+'); result = '".strtr(implode("&", $parameters), " ", "+")."'; result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result; this.href ='feed.php?email=".$login."'+((result != '') ? '&' : '')+result;\">&#x1F50E;</a><br>\n";
echo '</center>';

echo '</header>';
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
            echo '<br>';

echo "<div><h3>Meus Grupos</h3></div>";
$meusgrupos = $db->query("select grupo.nome, grupo.codigo from grupo join grupo_usuario on grupo_usuario.grupo = grupo.codigo join usuario on usuario.email = grupo_usuario.usuario where usuario.email = '" . $login . "' and grupo_usuario.ativo = 1");
while ($row = $meusgrupos->fetchArray()) {
    echo $row['nome'] . ' <a href="feed.php?email=' . $login . '&excluir=' . $row['codigo'] . '_grupo">Sair</a> <br>';
}
  // echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";

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
$results22 = $db->query('select cidade as cidadecod from interacao where usuario = ' . '"' . $login . '"' . '');
while ($row22 = $results22->fetchArray())
{
echo '<input type="hidden" name ="cidadecod" value = '.$row22['cidadecod'].'>';
}
echo '<div>';
echo 'Citar: ';
echo '<select id="selectcitar" name="selectcitar">';
$resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '".$login."'");
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


echo '<div>';
echo ' Postar no grupo: ';
echo '<select id="selectgrupo" name="selectgrupo">';
    echo "<option value='0'>Nenhum</option>\n";

$results5 = $db->query("select grupo.nome as nome, grupo.codigo as codigo from grupo_usuario join grupo on grupo_usuario.grupo = grupo.codigo where grupo_usuario.ativo = 1 and usuario = '".$login."'");
while ($row5 = $results5->fetchArray())
{
    echo "<option value=\"" . $row5["codigo"] . "\">" . ucwords(strtolower($row5["nome"])) . "</option>\n";
}
echo '</select>';
echo '</div>';

echo '<button name="postar" type="submit">Publicar</button>';
echo '</form>';
echo '</div>';
// FIM


//FEED
$teste = $db->query("select codigo, usuario,  email, tipo, data, cidade, cidadecod, uf, pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, ativo from (select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where usuario = '".$login."' and interacao.grupo IS NULL and interacao.ativo = 1

union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where interacao.codigo in (select referencia
        from interacao
        order by 1 desc) and usuario2 = '".$login."'
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email join amizade on amizade.usuario1 = interacao.usuario
    where referencia in (select codigo
    from interacao
    order by 1 desc) and usuario1 = '".$login."' 
union
    -- INTERACOES DOS AMIGOS
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join amizade on interacao.usuario = amizade.usuario1 join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and interacao.usuario = amizade.usuario1 and usuario2 = '".$login."' and amizade.ativo = 1
union
    -- INTERACOES GRUPO
    select interacao.codigo, usuario.nome as usuario, grupo_usuario.usuario as email, tipo, hora_post as data, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais, interacao.grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from grupo_usuario join interacao on interacao.grupo = grupo_usuario.grupo join grupo on interacao.grupo = grupo.codigo join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.ativo = 1 and grupo_usuario.ativo = 1 and grupo_usuario.usuario = '".$login."'
union
    select interacao.codigo, usuario.nome as usuario, usuario.email as email, tipo, hora_post as data, cidade.nome as cidade, cidade.codigo as cidadecod, uf.nome as uf, pais.nome as pais, grupo, conteudo, assunto, case when referencia is null then -1 else referencia end as referencia, interacao.ativo
    from interacao join cidade on cidade.codigo = interacao.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on interacao.usuario = usuario.email
    where interacao.codigo in (select referencia
    from amizade join interacao on interacao.usuario = amizade.usuario1
    where usuario1 = '".$login."'))".$where." order by ".$orderby." limit ".$limit." offset ".$offset);
// print_r($rowteste1);

// group by a.codigo, a.referencia order by data desc;

// select codigo, usuario as email, tipo, hora_post as data, cidade, grupo, conteudo, assunto, referencia, ativo from interacao where usuario = "VINI@VINI.COM";

// $number_of_rows = 0;//for now

// while($row = $teste->fetchArray()) {
//     $number_of_rows += 1;
// }
// // $rowsteste1 = sqlite_num_rows($teste);
// if($number_of_rows <= 0){
//       $teste = $db->query("select a.codigo, usuario.email as email, a.conteudo, usuario_marcado as citado, a.hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, usuario.nome as usuario, a.tipo as tipo, case when a.referencia is null then -1 else a.referencia end as referencia from interacao a join usuario on a.usuario = usuario.email left join interacao b on b.codigo = a.referencia join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo left join grupo_usuario on a.grupo = grupo_usuario.grupo left join grupo on grupo_usuario.grupo = grupo.codigo left join citacao_usuario on a.codigo = citacao_usuario.interacao where a.ativo = 1 and grupo_usuario.ativo IS NULL group by a.codigo, a.referencia order by data desc;");
//       // ECHO'ASDASDASD';

// }
// while ($rowteste1 = $teste->fetchArray()){
  // $rowteste1 = $teste->fetchArray();
  // if(!isset($rowteste1["grupo"])){
    // $teste = $db->query("select a.codigo, usuario.email as email, a.conteudo, a.hora_post as data, cidade.nome as cidade, uf.nome as uf, pais.nome as pais, usuario.nome as usuario, a.tipo as tipo, case when a.referencia is null then -1 else a.referencia end as referencia from interacao a join usuario on a.usuario = usuario.email left join interacao b on b.codigo = a.referencia join cidade on cidade.codigo = usuario.cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo left join grupo_usuario on a.grupo = grupo_usuario.grupo left join grupo on grupo_usuario.grupo = grupo.codigo where a.ativo = 1 and grupo_usuario.ativo IS NULL group by a.codigo, a.referencia order by data desc;");
// }
// }
// FIM
// AQUI EH ONDE ORGANIZA OS COMENTARIOS E POST
$comments = array();
while ($rowteste = $teste->fetchArray())
{
  $rowteste['childs'] = array();
  $referencia = $rowteste['referencia'];
  $comments[$rowteste['codigo']] = $rowteste;
  // print_r($comments);
  // print_r($rowteste);
  
  
}



echo '<center>';
echo "<tr><td>Ordernar<a href='".url("orderby", "data+asc", $login)."'>&#x25BE;</a><a href='".url("orderby", "data+desc", $login)."'>&#x25B4;</a></td><tr>";
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
                echo '<button type="submit" name="delete">&#10060</button>';
                echo '<a href=update_dados.php?email='.$login.'&codigo='.$info["codigo"].'>Editar;</a>';
                echo '</form>';

            }

             echo '<div>';
              $results8 = $db->query("select group_concat(usuario.nome, ', ') as nome from citacao_usuario join usuario on usuario.email = citacao_usuario.usuario_marcado where interacao = '".$info["codigo"]."'");
              while ($row8 = $results8->fetchArray())
              {
                if($row8["nome"] != ""){
                echo 'Citou '.ucwords(strtolower($row8["nome"]));
                }
                else{
                  echo '';
                }
                // echo $row6["grupo"];
              }
                          echo '</div>';

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

$results23 = $db->query('select cidade as cidadecod from interacao where usuario = ' . '"' . $login . '"' . '');
while ($row23 = $results23->fetchArray())
{
echo '<input type="hidden" name ="cidadecod" value = '.$row23['cidadecod'].'>';
}


            echo '<input type="hidden" name="codigocoment" value="' . $info["codigo"] . '">';

echo '<div>';
echo 'Citar: ';
echo '<select id="selectcitar'. $info["codigo"] . '" name="' . $info["codigo"] . '">';
$resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '".$login."'");
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
            // echo '<form name="formcurtir" method="post" action="#">';
            // echo '<div id = reactions>';
            echo '<button type="submit" name="curtir">&#128077</button>';
            echo '<input type="hidden" name="codigocoment2" value="' . $info["codigo"] . '">';
            echo '<input type="hidden" id="arrayt" name ="arrayt">';
            // echo '</form>';
            // COMPARTILHAR
            // echo '<form name="formccompartilhar" method="post" action="#">';
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
                echo '<input type="hidden" name="referencia" value="' . $info["referencia"] . '">';
                echo '<button type="submit" name="delete">&#10060</button>';
                echo '<a href=update_dados.php?email='.$login.'&codigo='.$info["codigo"].' style = "float: right; margin-right: 40px">Editar</a>';
                echo '</form>';
            //  if($info["grupocodigo"] === $row6["grupo"]){
                // $results7 = $db->query("select grupo from grupo_usuario where grupo_usuario.usuario = '".$login."'");
                // while ($row7 = $results7->fetchArray()){
               
                  // if($info["grupocodigo"] === $row7["grupo"]){
                    echo '<br>';
                          echo '<div>';

              $results6 = $db->query("select grupo.nome as grupo from interacao join grupo on grupo.codigo = interacao.grupo where interacao.codigo = '".$info["codigo"]."'");
              while ($row6 = $results6->fetchArray())
              {
                echo 'Postou no grupo '.$row6["grupo"];
              }
            echo '</div>';
              // }
              // }
              
            }
            
            
            echo '<div>';
              $results8 = $db->query("select group_concat(usuario.nome, ', ') as nome from citacao_usuario join usuario on usuario.email = citacao_usuario.usuario_marcado where interacao = '".$info["codigo"]."'");
              while ($row8 = $results8->fetchArray())
              {
                if($row8["nome"] != ""){
                echo 'Citou '.ucwords(strtolower($row8["nome"]));
                }
                else{
                  echo '';
                }
                // echo $row6["grupo"];
              }
                          echo '</div>';

            
            
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
$results23 = $db->query('select cidade as cidadecod from interacao where usuario = ' . '"' . $login . '"' . '');
while ($row23 = $results23->fetchArray())
{
echo '<input type="hidden" name ="cidadecod" value = '.$row23['cidadecod'].'>';
}

echo '<div>';
echo 'Citar: ';
echo '<select id="selectcitar'. $info["codigo"] . '" name="' . $info["codigo"] . '">';
$resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '".$login."'");
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
            // echo '</form>';
            // CURTIR
            // echo '<div class = reactions2>';
            // echo '<form name="formcurtir" method="post" action="#">';
            echo '<button type="submit" name="curtir">&#128077</button>';
            echo '<input type="hidden" name="codigocoment2" value="' . $info["codigo"] . '">';
            echo '<input type="hidden" id="arrayt" name ="arrayt">';
            // echo '</form>';
            

            // COMPARTILHAR
            //  echo '<form name="formccompartilhar" method="post" action="#">';
            echo '<div id = compartilhar>';
            echo '<input type="hidden" id="arrayt" name ="arrayt">';
            echo '<button type="submit" name="compartilhar">&#128257</button>';
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
echo '<center>';
for ($page = 0; $page < ceil($total/$limit); $page++) {
                echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit, $login)."\">".($page+1)."</a>")." \n";
            }
            echo '</center>';
            echo '<br>';
                        echo '<br>';


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
  // echo $_POST["selectgrupo"];
    $x = $_POST['array'];
    $valores = explode(",", $x);
    $b = $_POST['arraycita'];
        $citacao = explode(",", $b);
    echo $_POST['cidadecod'];
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
    if($_POST["selectgrupo"] !== '0'){
      $db->exec("insert into interacao (codigo, usuario, tipo, cidade, grupo, conteudo) values ($total, '" . $login . "', 'POST',  ".$_POST["cidadecod"].", ".$_POST["selectgrupo"].", '".$post_content."')");
          if (!empty($_POST['array']))
        {
            for ($i = 0;$i < count($valores);$i++)
            {
                // echo $valores[$i];
                $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
            }
        }

         if (!empty($_POST['arraycita']))
        {
            for ($i = 0;$i < count($citacao);$i++)
            {
                // echo $valores[$i];
                $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('".$citacao[$i]."', $total)");
            }
        }
        echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
    }else{
    $db->exec("insert into interacao (codigo, usuario, tipo, cidade, conteudo) values ($total, '" . $login . "', 'POST', ".$_POST["cidadecod"].", '" . $post_content . "')");
        if (!empty($_POST['array']))
        {
            for ($i = 0;$i < count($valores);$i++)
            {
                // echo $valores[$i];
                $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
            }
        }

         if (!empty($_POST['arraycita']))
        {
            for ($i = 0;$i < count($citacao);$i++)
            {
                // echo $valores[$i];
                $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('".$citacao[$i]."', $total)");
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
        $db->exec("insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values ($total, '" . $login . "', 'COMENTARIO', ".$_POST["cidadecod"].", '" . $comment_content . "', " . $_POST['codigocoment'] . ")");
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
                // echo $valores[$i];
                $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('".$citacao[$i]."', $total)");
            }
        }
        echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
    }
}
if (isset($_POST['curtir']))
{
    echo 'asdad';
    $total = $total + 1;
    $b = $_POST['arraycita1'];
        $citacao = explode(",", $b);

    $x = $_POST['arrayt'];
    $valores = explode(",", $x);
    $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '" . $login . "', 'CURTIR', ".$_POST["cidadecod"].", " . $_POST['codigocoment2'] . ")");
    if (!empty($_POST['arrayt']))
    {
        for ($i = 0;$i < count($valores);$i++)
        {
            // echo $valores[$i];
            $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
        }
    }
       if (!empty($_POST['arraycita1']))
        {
            for ($i = 0;$i < count($citacao);$i++)
            {
                // echo $valores[$i];
                $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('".$citacao[$i]."', $total)");
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
    // $comment_content  = $_POST['conteudocomentario'];
    $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '" . $login . "', 'COMPARTILHAMENTO', ".$_POST["cidadecod"].", " . $_POST['codigocoment3'] . ")");
    if (!empty($_POST['arrayt']))
    {
        for ($i = 0;$i < count($valores);$i++)
        {
            // echo $valores[$i];
            $db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
        }
    }
       if (!empty($_POST['arraycita1']))
        {
            for ($i = 0;$i < count($citacao);$i++)
            {
                // echo $valores[$i];
                $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('".$citacao[$i]."', $total)");
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
          $db->exec("update citacao_usuario set ativo = 0 where interacao = " . $row2["codigo"]);

        }
      }
      $db->exec("update interacao set ativo = 0 where codigo = " . $_POST["codigo"]);
        $db->exec("update interacao set ativo = 0 where referencia = " . $_POST["codigo"]);
        $db->exec("update assunto_interacao set ativo = 0 where interacao = " . $_POST["codigo"]);
        $db->exec("update citacao_usuario set ativo = 0 where interacao = " . $_POST["codigo"]);

    
    // $db->exec("delete from citacao_usuario where interacao = ".$_POST["codigo"]);
    echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";

}

?>

</body>
<script>
 		let options1 = []
  	let options = []
      	let guardar = []

        	// let options1c = []
          let optionsc1 = []
          let optionsc = []

      	let guardarc = []


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

function addcitar(){
		let select1 = document.querySelector("#selectcitar");
  let select = document.getElementById("selectcitar").value;
  // let option = select1.optionsc[select1.selectedIndex].value;
  let add = document.getElementById("addcitar")

  	if(optionsc.indexOf(select) !== -1) {
			alert("Pessoa já inserida");
			return;
		}else{
      
      optionsc.push(select);
      console.log(select1[0].text)
      add.innerHTML +=  " - "+[select1[select1.selectedIndex].text] + " - ";
      document.getElementById("arraycita").setAttribute('value', optionsc );
    }
  }
  
  function addcitar1(num){
    let select = document.getElementById("selectcitar"+num).value
    let select1 = document.querySelector("#selectcitar"+num)
    // let mais = document.querySelectorAll("#mais")[num];
    let add = document.getElementById("addcitarc"+num);
    let b= document.querySelectorAll("#arraycita1").length;
    let c = document.querySelectorAll("#arraycita1");
    let option = select1.options[select1.selectedIndex].value;

    // let guardarc
    
    
    console.log(guardarc)
        console.log(select1.name)

        // console.log(option)
        // console.log(select)
        
        if(guardarc !== select1.name){
          let add2 = document.getElementById("addcitarc"+select1.name);
          add2.innerHTML = "";
          optionsc1 = []
        }
        
        guardarc=select1.name;
      
      if(optionsc1.indexOf(select) !== -1) {
        alert("Assunto já inserido");
      return;
    }else{
      
      // console.log(add)
      optionsc1.push(select);
      // console.log(optionsc1)
      for (i = 0; i <b; i++){
        c[i].setAttribute('value', optionsc1 )
        // console.log(c[i])
      }
      
      // console.log(optionsc1[0])
       add.innerHTML +=  " - "+[select1[select1.selectedIndex].text] + " - ";
    }
  // select1.options[select1.selectedIndex].text
}

  

  	function tiracitar(that){
  let select1 = document.querySelector("#selectcitar")
  let select = document.getElementById("selectcitar").value
  let add = document.getElementById("addcitar")

  add.innerHTML = "";
  optionsc=[]
  document.getElementById("arraycita").setAttribute('value', optionsc );

	};

    	function tiracitar1(that){
            let c = document.querySelectorAll("#arraycita1");
  let b= document.querySelectorAll("#arraycita1").length;

  let select1 = document.querySelector("#selectcitar"+that)
  let select = document.getElementById("selectcitar"+that).value
  let add = document.getElementById("addcitarc"+that)

  add.innerHTML = "";
  optionsc1=[]
   for (i = 0; i <b; i++){
    c[i].setAttribute('value', optionsc1 )
  }
  // document.querySelectorAll("arraycita1").setAttribute('value', optionsc1 );

	};



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
  document.getElementById("array").setAttribute('value', options );

	};
</script>

</html>