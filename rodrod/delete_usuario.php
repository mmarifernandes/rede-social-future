<?php
echo '<!DOCTYPE html>';
echo '<html lang="en">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Exclusão de Conta</title>';
echo '</head>';
echo '<body>';

if (isset($_GET['email'])) {
    $db = new SQLite3('future.db');
    $db->exec("PRAGMA foreign_keys = ON");
    $db->exec("update amizade set ativo = 0 where usuario1 = ".$_GET['email']."");
    $db->exec("update amizade set ativo = 0 where usuario2 = ".$_GET['email']."");
    $results = $db->query("select grupo.codigo as codigo from grupo join grupo_usuario on grupo.codigo = grupo_usuario.grupo where adm = 1 and grupo_usuario.usuario = ".$_GET['email']."");
    while ($row = $results->fetchArray()) {
        $db->exec("update grupo_usuario set ativo = 0 where usuario = ".$_GET['email']."");
        $db->exec("update grupo set ativo = 0 where codigo = ".$row['codigo']."");
    }
    $results = $db->query("select interacao.codigo as codigo from interacao join usuario on interacao.referencia = usuario.email where usuario.email = ".$_GET['email']."");
    while ($row = $results->fetchArray()) {
        $db->exec("update interacao set ativo = 0 where codigo = ".$row['codigo']."");
    }
    $db->exec("update interacao set ativo = 0 where usuario = ".$_GET['codigo']."");
    $db->exec("update usuario set ativo = 0 where email = ".$_GET['email']."");
    echo 'A exclusão de sua conta foi efetuada';
    $db->close();
    echo "<script> setTimeout(function () { window.open(\"select_usuario.php\",\"_self\"); }, 3000); </script>";
} else {
    echo 'Você não pode excluir sua conta sem, antes, entrar com uma!';
    echo "<script> setTimeout(function () { window.open(\"select_usuario.php\",\"_self\"); }, 3000); </script>";
}

echo '</body>';
echo '</html>';
?>