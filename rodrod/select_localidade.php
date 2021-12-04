<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção de Localidades</title>
    <style>
	table {
		length-width: 100%;
	}
	</style>
</head>
<body>
<?php
function url($campo, $valor) {
	$result = array();
	if (isset($_GET["pais"])) $result["pais"] = "pais like ".$_GET["pais"];
	if (isset($_GET["uf"])) $result["uf"] = "uf like ".$_GET["uf"];
	if (isset($_GET["cidade_nome"])) $result["cidade_nome"] = "cidade_nome like ".$_GET["cidade_nome"];
	if (isset($_GET["cidade_codigo"])) $result["cidade_codigo"] = "cidade_codigo=".$_GET["cidade_codigo"];
	if (isset($_GET["orderby"])) $result["orderby"] = "orderby=".$_GET["orderby"];
	if (isset($_GET["offset"])) $result["offset"] = "offset=".$_GET["offset"];
	$result[$campo] = $campo."=".$valor;
	return("select_localidade.php?".strtr(implode("&", $result), " ", "+"));
}

$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");

$limit = 5;

echo "<h1>Manutenção de Localidades</h1>\n";

echo "<select id=\"campo\" name=\"campo\">\n";
echo "<option value=\"pais\"".((isset($_GET["pais"])) ? " selected" : "").">País</option>\n";
echo "<option value=\"uf\"".((isset($_GET["uf"])) ? " selected" : "").">Unidade Federativa</option>\n";
echo "<option value=\"cidade_nome\"".((isset($_GET["cidade_nome"])) ? " selected" : "").">Cidade - Nome</option>\n";
echo "<option value=\"cidade_codigo\"".((isset($_GET["cidade_codigo"])) ? " selected" : "").">Cidade - Código</option>\n";
echo "</select>\n";

$value = "";
if (isset($_GET["pais"])) $value = $_GET["pais"];
if (isset($_GET["uf"])) $value = $_GET["uf"];
if (isset($_GET["cidade_nome"])) $value = $_GET["cidade_nome"];
if (isset($_GET["cidade_codigo"])) $value = $_GET["cidade_codigo"];

echo "<input type=\"text\" id=\"valor\" name=\"valor\" value=\"".$value."\" size=\"20\"> \n";

$parameters = array();
if (isset($_GET["orderby"])) $parameters[] = "orderby=".$_GET["orderby"];
if (isset($_GET["offset"])) $parameters[] = "offset=".$_GET["offset"];
echo "<a id=\"pesquisa\" href=\"\" onclick=\"pesquisa();\">&#x1F50E;</a><br>\n";
echo "<br>\n";

echo "<table border=\"1\">\n";
echo "<tr>\n";
echo "<td><a title='Adicionar uma nova localidade' href=\"insert_localidade.php\">&#x1F4C4;</a></td>\n";
echo "<td><b>País</b> <a href=\"".url("orderby", "pais+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "pais+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Unidade Federativa</b> <a href=\"".url("orderby", "uf+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "uf+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Cidade - Nome</b> <a href=\"".url("orderby", "cidade_nome+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "cidade_nome+desc")."\">&#x25B4;</a></td>\n";
echo "<td><b>Cidade - Código</b> <a href=\"".url("orderby", "cidade_codigo+asc")."\">&#x25BE;</a> <a href=\"".url("orderby", "cidade_codigo+desc")."\">&#x25B4;</a></td>\n";
echo "<td><p></p></td>\n";
echo "</tr>\n";

$where = array();
if (isset($_GET["pais"])) $where[] = "pais.nome like '".$_GET["pais"]."'";
if (isset($_GET["uf"])) $where[] = "uf.nome like '".$_GET["uf"]."'";
if (isset($_GET["cidade_nome"])) $where[] = "cidade.nome like '".$_GET["cidade_nome"]."'";
if (isset($_GET["cidade_codigo"])) $where[] = "cidade.codigo = ".$_GET["cidade_codigo"];

$where = (count($where) > 0) ? " and ".implode(" and ", $where) : "";

$total = $db->query("select count(distinct cidade.codigo) as total from cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where cidade.ativo = 1".$where)->fetchArray()["total"];

$orderby = (isset($_GET["orderby"])) ? $_GET["orderby"] : "pais asc";

$offset = (isset($_GET["offset"])) ? max(0, min($_GET["offset"], $total-1)) : 0;
$offset = $offset-($offset%$limit);

$results = $db->query("select pais.nome as pais, uf.nome as uf, cidade.nome as cidade_nome, cidade.codigo as cidade_codigo from pais join uf on pais.codigo = uf.pais join cidade on uf.codigo = cidade.uf where cidade.ativo = 1".$where." order by ".$orderby." limit ".$limit." offset ".$offset);
while ($row = $results->fetchArray()) {

	echo "<tr>\n";
	echo "<td><a title='Alterar esta localidade' href=\"update_localidade.php?cidade_codigo=".$row["cidade_codigo"]."\">&#x1F4DD;</a></td>\n";
	echo "<td>".ucwords(strtolower($row["pais"]))."</td>\n";
	echo "<td>".ucwords(strtolower($row["uf"]))."</td>\n";
	echo "<td>".ucwords(strtolower($row["cidade_nome"]))."</td>\n";
	echo "<td>".$row["cidade_codigo"]."</td>";
	echo "<td><a title='Deletar esta localidade' href=\"delete_localidade.php?cidade_codigo=".$row["cidade_codigo"]."\" onclick=\"return(confirm('Excluir ".$row["cidade_codigo"]."?'));\">&#x1F5D1;</a></td>\n";

}

echo "</table>\n";
echo "<br>\n";

for ($page = 0; $page < ceil($total/$limit); $page++) {
	echo (($offset == $page*$limit) ? ($page+1) : "<a href=\"".url("offset", $page*$limit)."\">".($page+1)."</a>")." \n";
}

function transform($texto) {
    $carac_espec = array('À'=>'A', 'à'=>'a', 'Á'=>'A', 'á'=>'a', 'Â'=>'A', 'â'=>'a', 'Ã'=>'A', 'ã'=>'a', 'Ä'=>'A', 'ä'=>'a', 'Å'=>'A', 'å'=>'a', 'Æ'=>'A', 'æ'=>'a', 'Þ'=>'B', 'þ'=>'b', 'Ç'=>'C', 'ç'=>'c', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c', 'Ð' => 'D', 'ð'=>'d', 'Đ'=>'Dj', 'đ'=>'dj', 'È'=>'E', 'è'=>'e', 'É'=>'E', 'é'=>'e', 'Ê'=>'E', 'ê'=>'e', 'Ë'=>'E', 'ë'=>'e', 'Ì'=>'I', 'ì'=>'i', 'Í'=>'I', 'í'=>'i', 'Î'=>'I', 'î'=>'i', 'Ï'=>'I', 'ï'=>'i', 'Ñ'=>'N', 'ñ'=>'n', 'Ò'=>'O', 'ò'=>'o', 'Ó'=>'O', 'ó'=>'o', 'Ô'=>'O', 'ô'=>'o', 'Õ'=>'O', 'õ'=>'o', 'Ö'=>'O', 'ö'=>'o', 'Ø'=>'O', 'ø'=>'o', 'Ŕ'=>'R', 'ŕ'=>'r', 'Š'=>'S', 'š'=>'s', 'ẞ'=>'SS', 'ß' => 'ss', 'Ù'=>'U', 'ù'=>'u', 'Ú'=>'U', 'ú'=>'u', 'Û'=>'U', 'û'=>'u', 'Ü'=>'U', 'ü' => 'u', 'Ý'=>'Y', 'ý'=>'y', 'ÿ'=>'y', 'Ž'=>'Z', 'ž'=>'z');
    return strtoupper(strtr($texto, $carac_espec));
}

echo "<script>";

echo "function pesquisa() {";
	echo "var campo = document.getElementById('campo').value;\n";
	echo "var valor = document.getElementById('valor').value;\n";
	echo "var c = 0;\n";

echo "if (campo == 'pais') {\n";
	echo "var regex = '^[A-Za-zÀ-ÖØ-öø-ÿ]+( [A-Za-zÀ-ÖØ-öø-ÿ]+)*$';\n";
	echo "var padrao = new RegExp(regex);\n";
	echo "if(!padrao.test(valor)) {\n";
		echo "alert('Você só pode pesquisar por palavras');\n";
		echo "c++;\n";
		echo "return false;\n";
	echo "}\n";
echo "}\n";

echo "if (campo == 'uf') {\n";
	echo "var regex = '^[A-Za-zÀ-ÖØ-öø-ÿ]+( [A-Za-zÀ-ÖØ-öø-ÿ]+)*$';\n";
	echo "var padrao = new RegExp(regex);\n";
	echo "if(!padrao.test(valor)) {\n";
		echo "alert('Você só pode pesquisar por palavras');\n";
		echo "c++;\n";
		echo "return false;\n";
	echo "}\n";
echo "}\n";

echo "if (campo == 'cidade_nome') {\n";
	echo "var regex = '^[A-Za-zÀ-ÖØ-öø-ÿ]+( [A-Za-zÀ-ÖØ-öø-ÿ]+)*$';\n";
	echo "var padrao = new RegExp(regex);\n";
	echo "if(!padrao.test(valor)) {\n";
		echo "alert('Você só pode pesquisar por palavras');\n";
		echo "c++;\n";
		echo "return false;\n";
	echo "}\n";
echo "}\n";

echo "if (campo == 'cidade_codigo') {\n";
	echo "var regex = '^([1-9][0-9]*)$';\n";
	echo "var padrao = new RegExp(regex);\n";
	echo "if(!padrao.test(valor)) {\n";
		echo "alert('Você só pode pesquisar por números inteiros positivos não-nulos');\n";
		echo "c++;\n";
		echo "return false;\n";
	echo "}\n";
echo "}\n";

echo "if (c == 0) {\n";
	echo "let value = document.getElementById('valor').value.trim().replace(/ +/g, '+');\n";
	echo "let link = document.getElementById('pesquisa');\n";
	echo "result = '".strtr(implode("&", $parameters), " ", "+")."';\n";
	echo "result = ((value != '') ? document.getElementById('campo').value+'='+value+((result != '') ? '&' : '') : '')+result;\n";
	echo "link.href = 'select_localidade.php'+((result != '') ? '?' : '')+result;";
echo "} else {\n";
	echo "return false;\n";
echo "}\n";
echo "}\n";


echo "</script>";

$db->close();
?>
</body>
</html>

