<?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");

echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Document</title>';
echo '</head>';
echo '<body>';

echo '<h1>Adição de Localidade</h1>';
echo '<form id="form" action="insert_localidade.php" method="post">';
echo '<table>';
echo '<tr>';
echo '<td><select id="pais" name="pais" onchange="muda1();">';
echo '</select></td>';
echo '<td><input type="text" id="outro" name="outro"';
echo 'placeholder="Insira o nome do país" style="display: none;" required disabled></td>';
echo '</tr>';
echo '<tr>';
echo '<td><select id="uf" name="uf" onchange="muda();">';
echo '</select></td>';
echo '<td><input type="text" id="outra" name="outra"';
echo 'placeholder="Insira o nome da unidade federativa" style="display: none;" required disabled></td>';
echo '</tr>';
echo '<tr>';
echo '<td><select id="cidade" name="cidade" onchange="mostra();">';
echo '</select></td>';
echo '<td><input type="text" id="outra1" name="outra1"';
echo 'placeholder="Insira o nome da cidade" style="display: none;" required disabled></td>';
echo '</tr>';
echo '<tr>';
echo '<td><br></td>';
echo '</tr>';
echo '<tr>';
echo '<td><button type="submit" id="insere" name="insere">Adicionar localidade</button></td>';
echo '</tr>';
echo '</table>';
echo '<form>';

echo '<script>';

echo 'let pais_cod = [""];';
echo 'let pais_nome = ["Selecione um dos seguintes países"];';
echo 'let uf_cod = [""];';
echo 'let uf_nome = ["Selecione uma unidade federativa"];';
echo 'let cidade_cod = [""];';
echo 'let cidade_nome = ["Selecione uma cidade"];';
echo 'let uf_row = [];';
echo 'let cidade_row = [];';

$results = $db->query("select pais.codigo as pais_cod, pais.nome as pais_nome from pais");

while ($row = $results->fetchArray())
{
    echo "pais_cod.push('" . $row['pais_cod'] . "');\n";
    echo "pais_nome.push('" . $row['pais_nome'] . "');\n";
}

echo "let select_pais = document.getElementById('pais');\n";
echo "let select_uf = document.getElementById('uf');\n";
echo "let select_cidade = document.getElementById('cidade');\n";

echo "var option = new Option(pais_nome[0], pais_cod[0]);\n";
echo "select_pais.options.add(option);\n";
echo "for (let w = 1; w < pais_cod.length; w++) {\n";
echo "var option = new Option(pais_nome[w].toLowerCase(), pais_cod[w]);\n";
echo "select_pais.options.add(option);\n";
echo "}\n";
echo "var option = new Option('outro...', 'outro');\n";
echo "select_pais.options.add(option);\n";
echo "var option = new Option(uf_nome[0], uf_cod[0]);\n";
echo "select_uf.options.add(option);\n";
echo "var option = new Option(cidade_nome[0], cidade_cod[0]);\n";
echo "select_cidade.options.add(option);\n";

$results = $db->query("select codigo, nome, pais from uf");

while ($row = $results->fetchArray())
{
    echo "uf_row.push('" . $row['codigo'] . "" . '*' . "" . $row['nome'] . "" . '*' . "" . $row['pais'] . "');\n";
}

$results = $db->query("select codigo, nome, uf from cidade");

while ($row = $results->fetchArray())
{
    echo "cidade_row.push('" . $row['codigo'] . "" . '*' . "" . $row['nome'] . "" . '*' . "" . $row['uf'] . "');\n";
}

echo 'function mostra() {';
echo 'var input2 = document.getElementById("outro");';
echo 'var input1 = document.getElementById("outra1");';
echo 'var input = document.getElementById("outra");';
echo 'if (document.getElementById("cidade").value == "outra1") {';
echo 'input1.style.display = "inline";';
echo 'input1.disabled = false;';
echo '} else {';
echo 'input1.style.display = "none";';
echo 'input1.value = "";';
echo 'input1.disabled = true;';
echo 'input1.required = true;';
echo '}';
echo 'if (document.getElementById("uf").value == "outra") {';
echo 'input.style.display = "inline";';
echo 'input.disabled = false;';
echo '} else {';
echo 'input.style.display = "none";';
echo 'input.value = "";';
echo 'input.disabled = true;';
echo 'input.required = true;';
echo '}';
echo 'if (document.getElementById("pais").value == "outro") {';
echo 'input2.style.display = "inline";';
echo 'input2.disabled = false;';
echo '} else {';
echo 'input2.style.display = "none";';
echo 'input2.value = "";';
echo 'input2.disabled = true;';
echo 'input2.required = true;';
echo '}';
echo '}';
echo 'function muda1() {';
echo 'var tmp_uf = [];';
echo 'select_uf.innerHTML = "";';
echo 'var opcaozero_cod = "";';
echo 'var opcaozero_nome = "Selecione uma unidade federativa";';
echo 'var option = new Option(opcaozero_nome, opcaozero_cod);';
echo 'select_uf.options.add(option);';
echo 'var pais = document.getElementById("pais").value;';
echo 'for (let z = 0; z < uf_row.length; z++) {';
echo 'tmp_uf = uf_row[z].split("*");';
echo 'if (tmp_uf[2] == pais) {';
echo 'option = new Option(tmp_uf[1].toLowerCase(), tmp_uf[0]);';
echo 'select_uf.options.add(option);';
echo '}';
echo '}';
echo 'select_uf.options[select_uf.options.length] = new Option("outra...", "outra");';
echo 'select_uf.selectedIndex = 0;';
echo 'mostra();';
echo '}';
echo 'function muda() {';
echo 'var tmp_cidade = [];';
echo 'select_cidade.innerHTML = "";';
echo 'var opcaozero_cod = "";';
echo 'var opcaozero_nome = "Selecione uma cidade";';
echo 'var option = new Option(opcaozero_nome, opcaozero_cod);';
echo 'select_cidade.options.add(option);';
echo 'var uf = document.getElementById("uf").value;';
echo 'for (let z = 0; z < cidade_row.length; z++) {';
echo 'tmp_cidade = cidade_row[z].split("*");';
echo 'if (tmp_cidade[2] == uf) {';
echo 'var option = new Option(tmp_cidade[1].toLowerCase(), tmp_cidade[0]);';
echo 'select_cidade.options.add(option);';
echo '}';
echo '}';
echo 'select_cidade.options[select_cidade.options.length] = new Option("outra...", "outra1");';
echo 'select_cidade.selectedIndex = 0;';
echo 'mostra();';
echo '}';

echo '</script>';

function transform($texto)
{
    $carac_espec = array(
        'À' => 'A',
        'à' => 'a',
        'Á' => 'A',
        'á' => 'a',
        'Â' => 'A',
        'â' => 'a',
        'Ã' => 'A',
        'ã' => 'a',
        'Ä' => 'A',
        'ä' => 'a',
        'Å' => 'A',
        'å' => 'a',
        'Æ' => 'A',
        'æ' => 'a',
        'Þ' => 'B',
        'þ' => 'b',
        'Ç' => 'C',
        'ç' => 'c',
        'Č' => 'C',
        'č' => 'c',
        'Ć' => 'C',
        'ć' => 'c',
        'Ð' => 'D',
        'ð' => 'd',
        'Đ' => 'Dj',
        'đ' => 'dj',
        'È' => 'E',
        'è' => 'e',
        'É' => 'E',
        'é' => 'e',
        'Ê' => 'E',
        'ê' => 'e',
        'Ë' => 'E',
        'ë' => 'e',
        'Ì' => 'I',
        'ì' => 'i',
        'Í' => 'I',
        'í' => 'i',
        'Î' => 'I',
        'î' => 'i',
        'Ï' => 'I',
        'ï' => 'i',
        'Ñ' => 'N',
        'ñ' => 'n',
        'Ò' => 'O',
        'ò' => 'o',
        'Ó' => 'O',
        'ó' => 'o',
        'Ô' => 'O',
        'ô' => 'o',
        'Õ' => 'O',
        'õ' => 'o',
        'Ö' => 'O',
        'ö' => 'o',
        'Ø' => 'O',
        'ø' => 'o',
        'Ŕ' => 'R',
        'ŕ' => 'r',
        'Š' => 'S',
        'š' => 's',
        'ẞ' => 'SS',
        'ß' => 'ss',
        'Ù' => 'U',
        'ù' => 'u',
        'Ú' => 'U',
        'ú' => 'u',
        'Û' => 'U',
        'û' => 'u',
        'Ü' => 'U',
        'ü' => 'u',
        'Ý' => 'Y',
        'ý' => 'y',
        'ÿ' => 'y',
        'Ž' => 'Z',
        'ž' => 'z'
    );
    return strtoupper(strtr($texto, $carac_espec));
}

function verificaPadrao()
{
    $erro = 0;

    $regex = '^[A-Z]+( [A-Z]+| [D][AEIO] [A-Z]+| [D][AO][S] [A-Z]+| [E] [A-Z]+)*$';

    if (isset($_POST['outro']))
    {
        if (!preg_match($regex, transform($_POST['outro'])))
        {
            echo '<script>';
            echo 'var outro = document.getElementById("outro");';
            echo 'outro.value = "";';
            echo 'outro.focus();';
            echo 'alert("O nome do país informado não corresponde ao formato permitido por FUTURE");';
            echo '</script>';
            $erro++;
        }
    }

    if (isset($_POST['outra']))
    {
        if (!preg_match($regex, transform($_POST['outra'])))
        {
            echo '<script>';
            echo 'var outra = document.getElementById("outra");';
            echo 'outra.value = "";';
            echo 'outra.focus();';
            echo 'alert("O nome da unidade federativa informado não corresponde ao formato permitido por FUTURE");';
            echo '</script>';
            $erro++;
        }
    }

    if (isset($_POST['outra1']))
    {
        if (!preg_match($regex, transform($_POST['outra1'])))
        {
            echo '<script>';
            echo 'var outra1 = document.getElementById("outra1");';
            echo 'outra1.value = "";';
            echo 'outra1.focus();';
            echo 'alert("O nome da cidade informado não corresponde ao formato permitido por FUTURE");';
            echo '</script>';
            $erro++;
        }
    }

    return $erro;
}

if (isset($_POST['pais']))
{
    if ($_POST['pais'] == 'outro')
    {
        $result = $db->querySingle("select codigo from pais where nome = '" . transform($_POST['outro']) . "'");
        if ($result === null)
        {
            $db->exec("insert into pais (nome) values ('" . transform($_POST['outro']) . "')");
        }
        if ($_POST['uf'] == 'outra')
        {
            $result = $db->querySingle("select codigo from uf where nome = '" . transform($_POST['outra']) . "'");
            if ($result === null)
            {
                $ultPais = $db->querySingle("select codigo from pais group by 1 order by 1 desc limit 1");
                $db->exec("insert into uf (nome, pais) values ('" . transform($_POST['outra']) . "', " . $ultPais . ")");
            }
            if ($_POST['cidade'] == 'outra1')
            {
                $result = $db->querySingle("select codigo from cidade where nome = '" . transform($_POST['outra1']) . "'");
                if ($result === null)
                {
                    $ultUF = $db->querySingle("select codigo from uf group by 1 order by 1 desc limit 1");
                    $db->exec("insert into cidade (nome, uf) values ('" . transform($_POST['outra1']) . "', " . $ultUF . ")");
                    echo "<script> setTimeout(function () { window.open(\"adm.php\",\"_self\"); }, 3000); </script>";
                }
            }
        }
        else
        {
            if ($_POST['cidade'] == 'outra1')
            {
                $result = $db->querySingle("select codigo from cidade where nome = '" . transform($_POST['outra1']) . "'");
                if ($result === null)
                {
                    $db->exec("insert into cidade (nome, uf) values ('" . transform($_POST['outra1']) . "', " . $_POST['uf'] . ")");
                    echo "<script> setTimeout(function () { window.open(\"select_localidadeadm.php\",\"_self\"); }, 3000); </script>";
                }
            }
        }
    }
    else
    {
        if ($_POST['uf'] == 'outra')
        {
            $result = $db->querySingle("select codigo from uf where nome = '" . transform($_POST['outra']) . "'");
            if ($result === null)
            {
                $db->exec("insert into uf (nome, pais) values ('" . transform($_POST['outra']) . "', " . $_POST['pais'] . ")");
            }
            if ($_POST['cidade'] == 'outra1')
            {
                $result = $db->querySingle("select codigo from cidade where nome = '" . transform($_POST['outra1']) . "'");
                if ($result === null)
                {
                    $ultUF = $db->querySingle("select codigo from uf group by 1 order by 1 desc limit 1");
                    $db->exec("insert into cidade (nome, uf) values ('" . transform($_POST['outra1']) . "', " . $ultUF . ")");
                    echo "<script> setTimeout(function () { window.open(\"select_localidadeadm.php\",\"_self\"); }, 3000); </script>";
                }
            }
        }
        else
        {
            if ($_POST['cidade'] == 'outra1')
            {
                $result = $db->querySingle("select codigo from cidade where nome = '" . transform($_POST['outra1']) . "'");
                if ($result === null)
                {
                    $db->exec("insert into cidade (nome, uf) values ('" . transform($_POST['outra1']) . "', " . $_POST['uf'] . ")");
                    echo "<script> setTimeout(function () { window.open(\"select_localidadeadm.php\",\"_self\"); }, 3000); </script>";
                }
            }
        }
    }
}

echo '</body>';
echo '</html>';

?>
