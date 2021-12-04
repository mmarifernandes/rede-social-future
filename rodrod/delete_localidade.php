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

if (isset($_GET['cidade_codigo'])) {
    $db = new SQLite3('future.db');
    $db->exec("PRAGMA foreign_keys = ON");
    $db->exec("update cidade set ativo = 0 where codigo = ".$_GET['cidade_codigo']."");
    echo 'A exclusão da localidade selecionada foi efetuada';
    $db->close();
    echo "<script> setTimeout(function () { window.open(\"select_localidade.php\",\"_self\"); }, 3000); </script>";
} else {
    echo '<script> alert("Você não pode excluir uma localidade sem, antes, entrar com uma conta de administrador!") </script>';
    echo "<script> setTimeout(function () { window.open(\"select_localidade.php\",\"_self\"); }, 3000); </script>";
}

echo '</body>';
echo '</html>';
?>