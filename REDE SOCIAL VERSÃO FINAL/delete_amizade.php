<html>
<body>
<?php
if (isset($_GET["usuario1"]) && isset($_GET["usuario2"])) {
	$db = new SQLite3("future.db");
	$db->exec("PRAGMA foreign_keys = ON");
    $db->exec('update amizade set ativo = false
    where usuario1 = '.'"'.$_GET["usuario1"].'"'.' and usuario2 = '.'"'.$_GET["usuario2"].'" or usuario1 = '.'"'.$_GET["usuario2"].'"'.' and usuario2 = '.'"'.$_GET["usuario1"].'"');
    //echo "<button><a href=\"feed.php\">Voltar</a></button>";
    echo "<script>window.location = 'feed.php?email=" . $_GET["usuario1"] . "'</script>";
	$db->close();
}
?>
</body>
<script>

</script>
</html>
