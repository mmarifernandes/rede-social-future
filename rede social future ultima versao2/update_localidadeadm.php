<?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");

echo '<!DOCTYPE html>';
echo '<html lang="pt-br">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Atualização de Localidade</title>';
echo '</head>';
echo '<body>';

if (isset($_GET['cidade_codigo']))
{
    $result = $db->query("select cidade.nome as cidade, uf.nome as uf, pais.nome as pais from cidade join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where cidade.codigo = '" . $_GET["cidade_codigo"] . "'");

    while ($row = $result->fetchArray())
    {
        echo '<h1>Alteração de Localidade</h1>';
        echo '<form id="form" action="update_localidadeadm.php?cidade_codigo=' . $_GET['cidade_codigo'] . '" method="post">';
        echo '<table>';
        echo '<tr>';
        echo '<td><label for="pais1">País atual</label></td>';
        echo '<td><input type="text" id="pais1" name="pais1" readonly value="' . ucwords(strtolower($row['pais'])) . '"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><label for="uf1">Unidade federativa atual</label></td>';
        echo '<td><input type="text" id="uf1" name="uf1" readonly value="' . ucwords(strtolower($row['uf'])) . '"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><label for="cidade1">Cidade atual</label></td>';
        echo '<td><input type="text" id="cidade1" name="cidade1" readonly value="' . ucwords(strtolower($row['cidade'])) . '"></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><br></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><input type="text" id="outra1" name="outra1"';
        echo 'placeholder="Insira o nome da cidade" required></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><br></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td><button type="submit" id="atualiza" name="atualiza">Atualizar dados</button></td>';
        echo '</tr>';
        echo '</table>';
        echo '<form>';
    }

}
else
{
    echo '<script> alert("Você não pode alterar dados de uma localidade sem, antes, selecionar uma!") </script>';
    echo "<script> setTimeout(function () { window.open(\"select_usuario.php\",\"_self\"); }, 3000); </script>";
}

echo '</body>';
echo '</html>';

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

if (isset($_POST['outra1']))
{
    $result = $db->querySingle("select codigo from cidade where nome = '" . transform($_POST['outra1']) . "'");
    if ($result === null)
    {
        $db->exec("update cidade set nome = '" . transform($_POST['outra1']) . "' where codigo = " . $_GET['cidade_codigo'] . "");
        echo "<script> setTimeout(function () { window.open(\"select_localidadeadm.php\",\"_self\"); }, 1000); </script>";
    }
    else
    {
        echo '<script> alert("Você não pode alterar para uma localidade já existente!") </script>';
    }
}

?>
