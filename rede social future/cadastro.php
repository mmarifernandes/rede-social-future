<?php
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '';
echo '<style>';
echo 'body {';
echo 'background-color: #7C78B8';
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
echo '<title>Document</title>';
echo '</head>';
echo '';
echo '<body>';
echo '<form method="POST" action="feed.php">';
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
echo '<label for="data">Data de Nascimento</label>';
echo '<br>';
echo '<input type="date" id="data" name="data" required min="1930-01-01"';
echo 'pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">';
echo '</td>';
echo '</tr>';
echo '';
echo '<tr>';
echo '<td>';
echo '<label for="genero">Gênero</label>';
echo '';
echo '<input type="radio" name="genero" value="masc" required>Masculino';
echo '<input type="radio" name="genero" value="fem">Feminino';
echo '<input type="radio" name="genero" value="outro">Outro';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<select id="pais" name="pais" onchange="muda1();">';
echo '<option value="0">Selecione uma das opções</option>';
echo '<option value="BRASIL">Brasil</option>';
echo '<option value="ARGENTINA">Argentina</option>';
echo '<option value="ESTADOS_UNIDOS">Estados Unidos</option>';
echo '</select>';
echo '<select id="uf" name="uf" onchange="muda();">';
echo '';
echo '</select>';
echo '<input type="text" id="outra" name="outra" pattern="^[A-Z][a-z]+( [A-Z][a-z]+)*$"';
echo 'placeholder="Insira o nome do estado" style="display: none;" required disabled>';
echo '<select id="cidade" name="cidade" onchange="mostra();">';
echo '</select>';
echo '<input type="text" id="outra1" name="outra1" pattern="^[A-Z][a-z]+( [A-Z][a-z]+)*$"';
echo 'placeholder="Insira o nome da cidade" style="display: none;" required disabled>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td style="text-align: center;">';
echo '<button type="submit" action = "feed.php">Cadastre-se</button>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</center>';
echo '</form>';
?>
</body>
<script>

    var curday = function (sp) {
        today = new Date();
        var dia = today.getDate();
        var mes = today.getMonth() + 1;
        var ano = today.getFullYear();

        if (dia < 10) dia = '0' + dia;
        if (mes < 10) mes = '0' + mes;

        return (ano + "-" + mes + "-" + dia)
    };

    document.getElementById("data").max = curday("sp");


    function mostra() {
        var input1 = document.getElementById("outra1");
        var input = document.getElementById("outra");
        console.log(document.getElementById("cidade").value)
        if (document.getElementById("cidade").value == "outra1") {
            input1.style.display = "inline";
            input1.disabled = false;
        } else {
            input1.style.display = "none";
            input1.style.placeholder = "Cidade"
            input1.value = "";
            input1.disabled = true;
            input1.required = true;
        }

        if (document.getElementById("uf").value == "outra") {
            input.style.display = "inline";
            input.disabled = false;
        } else {
            input.style.display = "none";
            input.value = "";
            input.disabled = true;
            input.required = true;

        }
    }


    function muda1() {
        var select = document.getElementById("uf");
        select.innerHTML = "";
        switch (document.getElementById("pais").value) {
            case "BRASIL":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Paraná", "PARANA");
                select.options[2] = new Option("Santa Catarina", "SANTA_CATARINA");
                select.options[3] = new Option("Rio Grande do Sul", "RIO_GRANDE_DO_SUL");
                select.options[4] = new Option("São Paulo", "SAO_PAULO");

                break;
            case "ARGENTINA":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Buenos Aires", "BUENOS_AIRES");
                break;
            case "ESTADOS_UNIDOS":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Washington", "WASHINGTON");
                select.options[2] = new Option("Nova Iorque", "NOVA_IORQUE");
                break;

        }
        select.options[select.options.length] = new Option("outra...", "outra");
        select.selectedIndex = 0;
        mostra();
    }

    function muda() {
        var select = document.getElementById("cidade");
        select.innerHTML = "";
        switch (document.getElementById("uf").value) {
            case "PARANA":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Curitiba", "Curitiba");
                select.options[2] = new Option("Paranagua", "Paranagua");
                break;
            case "SANTA_CATARINA":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Blumenau", "Blumenau");
                select.options[2] = new Option("Florianopolis", "Florianopolis");
                break;
            case "SAO_PAULO":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Campinas", "Campinas");
                select.options[2] = new Option("Sao Paulo", "Sao Paulo");
                break;
            case "RIO_GRANDE_DO_SUL":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Pelotas", "Pelotas");
                select.options[2] = new Option("Porto Alegre", "Porto Alegre");
                select.options[3] = new Option("Rio Grande", "Rio Grande");
                break;
            case "WASHINGTON":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Seatle", "SEATLE");
                break;
            case "NOVA_IORQUE":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("Nova Iorque", "NOVA_IORQUE");
                break;
            case "BUENOS_AIRES":
                select.options[0] = new Option("Selecione uma das opções", 0);
                select.options[1] = new Option("La Plata", "LA_PLATA");
                break;
        }
        select.options[select.options.length] = new Option("outra...", "outra1");
        select.selectedIndex = 0;
        mostra();
    };
<?php
echo '</script>';
echo '</html>';
?>