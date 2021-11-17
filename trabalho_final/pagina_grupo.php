<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Página ou Grupo</title>
    <style>
        button {
            margin-bottom: 10px;
            margin-left: 10px;
        }
        textarea {
            resize: none;
        }
    </style>
</head>
<body>

    <?php
        if(isset($_POST["confirma"])) {
            $var;
            foreach($_POST as $indice => $item) {
                if($indice == "pagina") {
                    $var = "pagina";
                    $valor = $_POST[$indice];
                    break;
                }else if($indice == "grupo") {
                    $valor = $_POST[$indice];
                    $var = "grupo";
                    break;
                }
            }
            // ver se o nome do grupo/página é válido, se o nome do grupo/página não existe, insere o grupo e (talvez uma logo)*
            $db = new SQLite3("facebook.db");
		    $db->exec("PRAGMA foreign_keys = ON");
            $db->exec("insert into $var (nome, descricao) values ('".$valor."','".$_POST["descricao"]."')");
            $db->close();
        } else {
            echo "<h3>Criar Grupo ou Página</h3>";
            echo "<button onclick=\"paginaGrupo('grupo')\">Grupo</button>";
            echo "<button onclick=\"paginaGrupo('pagina')\">Pagina</button>";
            echo "<div id=\"formulario\"></div>";
        }
    ?>
</body>
<script>
    function paginaGrupo(valor) {
        if(valor != "grupo" && valor != "pagina") {
            alert("Valor informado inválido tente novamente");
            return false;
        }else {
            let div = document.getElementById("formulario");
            div.innerHTML = "<form action='pagina_grupo.php' method='post'><table><tr><td>Nome "+`${valor}`+": <input type='text' name='"+`${valor}`+"' maxlength='100'> </td></tr><tr><td>Descrição: <textarea name='descricao' maxlength='200'></textarea> </td></tr><tr><td><button type='submit' name='confirma'>Criar "+`${valor}`+"</button></td></tr></table></form>";
        }

    }
</script>
</html>