<?php
echo '<!DOCTYPE html>';
echo '<html lang="pt-br">';
echo '';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '';
echo '<style>';
echo 'body {';
echo 'background-color: rgba(60, 18, 247, 0.192);';
echo '}';
echo '';
echo '* {';
echo 'box-sizing: border-box;';
echo '}';
echo '';
echo 'table {';
echo 'margin-top: 40px;';
echo 'text-align: start;';
echo 'background-color: rgb(253, 253, 253);';
echo 'padding-left: 30px;';
echo 'padding-right: 30px;';
echo 'border-radius: 17px;';
echo '}';
echo '';
echo 'td {';
echo 'padding: 10px;';
echo 'font-family: Arial, Helvetica, sans-serif;';
echo 'font-size: 14px;';
echo '}';
echo '';
echo 'input[type=text],';
echo 'textarea {';
echo 'width: 300px;';
echo 'padding: 12px;';
echo 'border: 1px solid #ccc;';
echo 'border-radius: 4px;';
echo 'resize: vertical;';
echo '}';
echo '';
echo '';
echo 'select {';
echo 'width: 300px;';
echo 'display: list-item;';
echo 'padding: 12px;';
echo 'border: 1px solid #ccc;';
echo 'border-radius: 4px;';
echo 'resize: vertical;';
echo '}';
echo '';
echo 'input[type=date] {';
echo 'width: 300px;';
echo 'padding: 12px;';
echo 'border: 1px solid #ccc;';
echo 'border-radius: 4px;';
echo 'resize: vertical;';
echo '}';
echo '';
echo 'div:first-of-type {';
echo 'display: flex;';
echo 'align-items: flex-start;';
echo 'margin-bottom: 5px;';
echo '}';
echo '';
echo 'label {';
echo 'margin-right: 15px;';
echo 'line-height: 32px;';
echo '}';
echo '';
echo 'input[type=radio] {';
echo '-webkit-appearance: none;';
echo '-moz-appearance: none;';
echo 'appearance: none;';
echo '';
echo 'border-radius: 50%;';
echo 'width: 16px;';
echo 'height: 16px;';
echo '';
echo 'border: 2px solid #999;';
echo 'transition: 0.2s all linear;';
echo 'margin-right: 5px;';
echo '';
echo 'position: relative;';
echo 'top: 4px;';
echo '}';
echo '';
echo 'input:checked {';
echo 'border: 6px solid rgb(41, 8, 102);';
echo '}';
echo '';
echo 'button,';
echo 'legend {';
echo 'color: white;';
echo 'background-color: rgb(90, 62, 167);';
echo 'padding: 10px 15px;';
echo 'border-radius: 10px;';
echo 'border: 0;';
echo 'font-size: 14px;';
echo '}';
echo '';
echo '';
echo '';
echo 'button:active {';
echo 'background-color: rgb(0, 117, 196);';
echo 'color: rgb(255, 255, 255);';
echo 'outline: 1px solid rgba(0, 0, 0, 0.041);';
echo '}';
echo '</style>';
echo '<title>Cadastro de Usu??rio</title>';
echo '</head>';
echo '';
echo '<body>';
echo '<form id="form" action="cadastro.php" method="post">';
echo '<center>';
echo '<table>';
echo '<tr>';
echo '<td>';
echo '<h1 style="font-size: 40px;">Cadastre-se</h1>';
echo '<input type="text" id="nome" name="nome" pattern="^[A-Z][a-z]+( [A-Z][a-z]+)+$"';
echo 'placeholder="Nome completo" required>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<input type="text" id="email" name="email" placeholder="Email"';
echo 'pattern="^[a-z0-9]+([_\.][a-z0-9]+)*@[a-z0-9]+([_\.][a-z0-9]+)*\.[a-z]{3}(\.[a-z]{2})?$"';
echo 'required>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<label for="bday">Data de Nascimento</label>';
echo '<br>';
echo '<input type="date" id="bday" name="bday" required min="1900-01-01"';
echo 'pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">';
echo '</td>';
echo '</tr>';
echo '';
echo '<tr>';
echo '<td>';
echo '<label for="genero">G??nero</label>';
echo '';
echo '<input type="radio" name="genero" value="M" required>Masculino';
echo '<input type="radio" name="genero" value="F">Feminino';
echo '<input type="radio" name="genero" value="N">Outro';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<select id="pais" name="pais" onchange="muda1();">';
echo '</select>';
echo '<input type="text" id="outro" name="outro" pattern="^[a-zA-Z]+(\s[a-zA-Z]+|-[a-zA-Z]+)*$"';
echo 'placeholder="Insira o nome do pa??s" style="display: none;" required disabled>';
echo '<select id="uf" name="uf" onchange="muda();">';
echo '</select>';
echo '<input type="text" id="outra" name="outra" pattern="^[a-zA-Z]+(\s[a-zA-Z]+|-[a-zA-Z]+)*$"';
echo 'placeholder="Insira o nome da unidade federativa" style="display: none;" required disabled>';
echo '<select id="cidade" name="cidade" onchange="mostra();">';
echo '</select>';
echo '<input type="text" id="outra1" name="outra1" pattern="^[a-zA-Z]+(\s[a-zA-Z]+|-[a-zA-Z]+)*$"';
echo 'placeholder="Insira o nome da cidade" style="display: none;" required disabled>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td style="text-align: center;">';
echo '<button type="button" id="cadastra" name="cadastra">Cadastre-se</button>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td style="text-align: center;">';
echo '<table id="erro" name="erro">';
echo '</table>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</center>';
echo '</form>';
?>
</body>
<script>

let pais_cod = [""];
let pais_nome = ["Selecione um dos seguintes pa??ses"];
let uf_cod = [""];
let uf_nome = ["Selecione uma unidade federativa"];
let cidade_cod = [""];
let cidade_nome = ["Selecione uma cidade"];
let uf_row = [];
let cidade_row = [];

<?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");
$results = $db->query("select pais.codigo as pais_cod, pais.nome as pais_nome from pais");

while ($row = $results->fetchArray()) {
    echo "pais_cod.push('".$row['pais_cod']."');\n";
    echo "pais_nome.push('".$row['pais_nome']."');\n";
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

while ($row = $results->fetchArray()) {
    echo "uf_row.push('".$row['codigo']."".'*'."".$row['nome']."".'*'."".$row['pais']."');\n";
}

$results = $db->query("select codigo, nome, uf from cidade");

while ($row = $results->fetchArray()) {
    echo "cidade_row.push('".$row['codigo']."".'*'."".$row['nome']."".'*'."".$row['uf']."');\n";
}


echo 'var curday = function (sp) {';
echo 'today = new Date();';
echo 'var dia = today.getDate();';
echo 'var mes = today.getMonth() + 1;';
echo 'var ano = today.getFullYear();';
echo '';
echo 'if (dia < 10) dia = "0" + dia;';
echo 'if (mes < 10) mes = "0" + mes;';
echo '';
echo 'return (ano + "-" + mes + "-" + dia)';
echo '};';
echo '';
echo 'document.getElementById("bday").max = curday("sp");';
echo '';
echo '';
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
echo '';
echo '';
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
echo 'var button = document.getElementById("cadastra");';
echo '';
echo 'button.addEventListener("click", enviar);';
echo '';
echo 'function enviar() {';
echo 'document.getElementById("form").submit();';
echo '}';
echo '</script>';
?>
<?php
$db = new SQLite3('future.db');
$db->exec('PRAGMA foreign_keys = ON');

function transform($texto) {
    $carac_espec = array('??'=>'A', '??'=>'a', '??'=>'A', '??'=>'a', '??'=>'A', '??'=>'a', '??'=>'A', '??'=>'a', '??'=>'A', '??'=>'a', '??'=>'A', '??'=>'a', '??'=>'A', '??'=>'a', '??'=>'B', '??'=>'b', '??'=>'C', '??'=>'c', '??'=>'C', '??'=>'c', '??'=>'C', '??'=>'c', '??' => 'D', '??'=>'d', '??'=>'Dj', '??'=>'dj', '??'=>'E', '??'=>'e', '??'=>'E', '??'=>'e', '??'=>'E', '??'=>'e', '??'=>'E', '??'=>'e', '??'=>'I', '??'=>'i', '??'=>'I', '??'=>'i', '??'=>'I', '??'=>'i', '??'=>'I', '??'=>'i', '??'=>'N', '??'=>'n', '??'=>'O', '??'=>'o', '??'=>'O', '??'=>'o', '??'=>'O', '??'=>'o', '??'=>'O', '??'=>'o', '??'=>'O', '??'=>'o', '??'=>'O', '??'=>'o', '??'=>'R', '??'=>'r', '??'=>'S', '??'=>'s', '???'=>'SS', '??' => 'ss', '??'=>'U', '??'=>'u', '??'=>'U', '??'=>'u', '??'=>'U', '??'=>'u', '??'=>'U', '??' => 'u', '??'=>'Y', '??'=>'y', '??'=>'y', '??'=>'Z', '??'=>'z', ' '=>'_');
    return strtoupper(strtr($texto, $carac_espec));
}

function verificaPadrao() {
    $regex = '^[A-Z][a-z]+( [A-Z][a-z]+)+$^';

    if (!preg_match($regex, $_POST['nome'])) {
        echo '<script>';
        echo 'var nome = document.getElementById("nome");';
        echo 'nome.value = "";';
        echo 'nome.focus();';
        echo 'alert("O nome informado n??o corresponde ao formato permitido por FUTURE");';
        echo '</script>';
        return false;
    }

    $regex = '^[a-z0-9]+([_\.][a-z0-9]+)*@[a-z0-9]+([_\.][a-z0-9]+)*\.[a-z]{3}(\.[a-z]{2})?$^';

    if (!preg_match($regex, $_POST['email'])) {
        echo '<script>';
        echo 'var email = document.getElementById("email");';
        echo 'email.value = "";';
        echo 'email.focus();';
        echo 'alert("O e-mail informado n??o corresponde ao formato permitido por FUTURE");';
        echo '</script>';
        return false;
    }

    $regex = '^[0-9]{4}-[0-9]{2}-[0-9]{2}$^';

    if (!preg_match($regex, $_POST['bday'])) {
        echo '<script>';
        echo 'var bday = document.getElementById("bday");';
        echo 'bday.value = "";';
        echo 'bday.focus();';
        echo 'alert("A data de nascimento informada n??o corresponde ao formato permitido por FUTURE");';
        echo '</script>';
        return false;
    }

    $regex = '^[a-zA-Z]+(\s[a-zA-Z]+|-[a-zA-Z]+)*$^';

    if (isset($_POST['outro'])) {
        if (!preg_match($regex, $_POST['outro'])) {
            echo '<script>';
            echo 'var outro = document.getElementById("outro");';
            echo 'outro.value = "";';
            echo 'outro.focus();';
            echo 'alert("O nome do pa??s informado n??o corresponde ao formato permitido por FUTURE");';
            echo '</script>';
            return false;
        }
    }

    if (isset($_POST['outra'])) {
        if (!preg_match($regex, $_POST['outra'])) {
            echo '<script>';
            echo 'var outra = document.getElementById("outra");';
            echo 'outra.value = "";';
            echo 'outra.focus();';
            echo 'alert("O nome da unidade federativa informado n??o corresponde ao formato permitido por FUTURE");';
            echo '</script>';
            return false;
        }
    }

    if (isset($_POST['outra1'])) {
        if (!preg_match($regex, $_POST['outra1'])) {
            echo '<script>';
            echo 'var outra1 = document.getElementById("outra1");';
            echo 'outra1.value = "";';
            echo 'outra1.focus();';
            echo 'alert("O nome da cidade informado n??o corresponde ao formato permitido por FUTURE");';
            echo '</script>';
            return false;
        }
    }
}

if (isset($_POST['email'])) {

        if (verificaPadrao() !== false) {

        $result = $db->querySingle("select email from usuario where email = '".$_POST['email']."'");
        if ($result === null) {

            if ($_POST['pais'] == 'outro') {
                $db->exec("insert into pais (codigo, nome) values ('".transform($_POST['outro'])."', '".$_POST['outro']."')");
                if ($_POST['uf'] == 'outra') {
                    $db->exec("insert into uf (codigo, nome, pais) values ('".transform($_POST['outra'])."', '".$_POST['outra']."', '".transform($_POST['outro'])."')");
                    if ($_POST['cidade'] == 'outra1') {
                        $ultCidade = $db->querySingle("select codigo from cidade group by 1 order by 1 desc limit 1");
                        $ultCidade = $ultCidade + 1;
                        $db->exec("insert into cidade (codigo, nome, uf) values (".$ultCidade.", '".$_POST['outra1']."', '".transform($_POST['outra'])."')");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$ultCidade.")");
                    } else {
                        $result = $db->querySingle("select codigo from cidade where nome = '".$_POST['cidade']."'");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$result.")");
                    }
                } else {
                    if ($_POST['cidade'] == 'outra1') {
                        $ultCidade = $db->querySingle("select codigo from cidade group by 1 order by 1 desc limit 1");
                        $ultCidade = $ultCidade + 1;
                        $db->exec("insert into cidade (codigo, nome, uf) values (".$ultCidade.", '".$_POST['outra1']."', '".$_POST['uf']."')");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$ultCidade.")");
                    } else {
                        $result = $db->querySingle("select codigo from cidade where nome = '".$_POST['cidade']."'");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$result.")");
                    }
                }
            } else {
                if ($_POST['uf'] == 'outra') {
                    $db->exec("insert into uf (codigo, nome, pais) values ('".transform($_POST['outra'])."', '".$_POST['outra']."', '".$_POST['pais']."')");
                    if ($_POST['cidade'] == 'outra1') {
                        $ultCidade = $db->querySingle("select codigo from cidade group by 1 order by 1 desc limit 1");
                        $ultCidade = $ultCidade + 1;
                        $db->exec("insert into cidade (codigo, nome, uf) values (".$ultCidade.", '".$_POST['outra1']."', '".transform($_POST['outra'])."')");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$ultCidade.")");
                    } else {
                        $result = $db->querySingle("select codigo from cidade where nome = '".$_POST['cidade']."'");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$result.")");
                    }
                } else {
                    if ($_POST['cidade'] == 'outra1') {
                        $ultCidade = $db->querySingle("select codigo from cidade group by 1 order by 1 desc limit 1");
                        $ultCidade = $ultCidade + 1;
                        $db->exec("insert into cidade (codigo, nome, uf) values (".$ultCidade.", '".$_POST['outra1']."', '".$_POST['uf']."')");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$ultCidade.")");
                    } else {
                        $result = $db->querySingle("select codigo from cidade where nome = '".$_POST['cidade']."'");
                        $db->exec("insert into usuario (email, nome, data_nascimento, genero, cidade) values ('".$_POST['email']."', '".$_POST['nome']."', '".$_POST['bday']."', '".$_POST['genero']."', ".$result.")");
                    }
                }
            }

            echo "<script> setTimeout(function () { window.open(\"feed.php?email=".$_POST["email"]."\",\"_self\"); }, 3000); </script>";

        } else {
            echo '<script>';
            echo 'var email = document.getElementById("email");';
            echo 'var erro = document.getElementById("erro");';
            echo 'var tr = erro.insertRow(0);';
            echo 'var td = tr.insertCell(0);';
            echo 'email.value = "";';
            echo 'email.focus();';
            echo 'td.innerHTML = "O e-mail inserido est?? vinculado a uma conta existente. Insira outro e-mail para efetuar o cadastro."';
            echo 'td.style.color = "red";';
            echo '</script>';
        }
}

}
?>
</html>
