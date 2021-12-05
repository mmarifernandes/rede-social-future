<html>
<body>
<?php

//update tabela1
//set ativo = false
//where campo1 = valor1;
//".$_GET["codigo"]);
//echo $_GET["amigo"];
//echo $login;
if (isset($_GET["usuario1"]) && isset($_GET["usuario2"])) {
	$db = new SQLite3("future.db");
	$db->exec("PRAGMA foreign_keys = ON");
    /*$resultsF = $db->query('select nome as usuario2
    from amizade as a
    left join amizade as b on a.usuario2 = b.usuario2
    left join usuario as p on a.usuario2 = p.email
    where a.usuario1  = '.'"'.$GET["email"].'"'.'');*/
    /*'.'"'.$login.'"'.'')*/
	/*$db->exec('update amizade set ativo = false
    where usuario1 = '.'"'.$_GET["usuario1"].'"'.' and usuario2 = '.'"'.$_GET["usuario2"].'"');
    echo "</div>";*/
    $db->exec('update amizade set ativo = false
    where usuario1 = '.'"'.$_GET["usuario1"].'"'.' and usuario2 = '.'"'.$_GET["usuario2"].'" or usuario1 = '.'"'.$_GET["usuario2"].'"'.' and usuario2 = '.'"'.$_GET["usuario1"].'"');
    echo "</div>";
	echo "Amigo excluído!";
    echo "<br>";
    echo '<button><a href="#" onclick="location.href = document.referrer; return false;">Voltar</a></button>';
    //echo "<button><a href=\"feed.php\">Voltar</a></button>";
	$db->close();
}
?>
</body>
<script>
//setTimeout(function(){history.back();}, 3000);

</script>
</html>
