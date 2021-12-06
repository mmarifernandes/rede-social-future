<html>
<body>
<?php
if (isset($_GET["usuario1"]) && isset($_GET["usuario2"])) {
	$db = new SQLite3("future.db");
	$db->exec("PRAGMA foreign_keys = ON");
    $db->exec("insert into amizade (usuario1, usuario2, data_hora, ativo) values ('".$_GET['usuario1']."', '".$_GET['usuario2']."',  (datetime('now')), true)");
    $db->exec("insert into amizade (usuario1, usuario2, data_hora, ativo) values ('".$_GET['usuario2']."', '".$_GET['usuario1']."',  (datetime('now')), true)");
    //echo "<button><a href=\"feed.php\">Voltar</a></button>";
    echo "<script>window.location = 'feed.php?email=" . $_GET["usuario1"] . "'</script>";
	$db->close();
}
?>
</body>
<script>

</script>
</html>
