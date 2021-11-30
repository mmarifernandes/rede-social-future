<?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");

echo '<!DOCTYPE html>';
echo '<html lang="pt-br">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<title>Configurações de Dados</title>';
echo '</head>';
echo '<body>';
echo '<h1>Configurações</h1>';

$results = $db->query("select usuario.nome as nome, usuario.email as email, usuario.data_nascimento as data_nascimento, case (select genero from usuario where email='".$_GET['email']."') when 'M' then 'Masculino' when 'F' then 'Feminino' when 'N' then 'Outro' end as genero, cidade.nome as cidade, uf.nome as uf, pais.nome as pais from usuario join cidade on usuario.cidade = cidade.codigo join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where email = '".$_GET["email"]."'");
while ($row = $results->fetchArray()) {

echo '<table>';
echo '<tr>';
echo '<td><h2>E-mail</h2></td>';
echo '</tr>';
echo '<tr>';
echo '<td><p>'.strtolower($row['email']).'</p></td>';
echo '</tr>';
echo '<tr>';
echo '<td><h2>Nome</h2></td>';
echo '</tr>';
echo '<tr>';
echo '<td><p>'.ucwords(strtolower($row['nome'])).'</p></td>';
echo '<td><a href="update_dados.php?email='.$row['email'].'&atributo=nome">Alterar</a></td>';
echo '</tr>';
echo '<tr>';
echo '<td><h2>Data de Nascimento</h2></td>';
echo '</tr>';
echo '<tr>';
echo '<td><p>'.strftime('%d/%m/%Y', strtotime($row["data_nascimento"])).'</p></td>';
echo '<td><a href="update_dados.php?email='.$row['email'].'&atributo=data_nascimento">Alterar</a></td>';
echo '</tr>';
echo '<tr>';
echo '<td><h2>Gênero</h2></td>';
echo '</tr>';
echo '<tr>';
echo '<td><p>'.$row['genero'].'</p></td>';
echo '<td><a href="update_dados.php?email='.$row['email'].'&atributo=genero">Alterar</a></td>';
echo '</tr>';
echo '<tr>';
echo '<td><h2>Localidade</h2></td>';
echo '</tr>';
echo '<tr>';
echo '<td><p>'.ucwords(strtolower($row['cidade'])).', '.ucwords(strtolower($row['uf'])).', '.ucwords(strtolower($row['pais'])).'</p></td>';
echo '<td><a href="update_dados.php?email='.$row['email'].'&atributo=localidade">Alterar</a></td>';
echo '</tr>';
echo '</table>';

}
echo '</body>';
echo '</html>';
?>