<?php

$qtde = 300;
$hrs = 24;
$pais = 'BRASIL';
$dias = 7;

$result = querySingle("select count(*) from (select count(*) from usuario join interacao on usuario.email = interacao.usuario join (select count(*) as qtde, inter1.codigo as codigo, usuario.email as email from interacao as inter2 join interacao as inter1 on inter1.codigo = inter2.referencia join cidade on inter1.cidade = cidade.codigo join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo join usuario on inter1.usuario = usuario.email where (inter2.tipo = 'CURTIR') and (datetime(inter2.data_hora) between datetime(inter1.data_hora) and datetime(inter1.data_hora, '+".$hrs." hours')) and (datetime(inter1.data_hora) between datetime('now', 'localtime', '-".$dias." days') and datetime('now', 'localtime')) and (pais.nome like '".$pais."') group by 3, 2) as tmp on tmp.codigo = interacao.codigo where tmp.qtde > ".$qtde." group by tmp.email)");

echo $result.' usuário(s) receberam '.$qtde.' curtidas ou mais após '.$hrs.' horas nos últimos '.$dias.' dias';

?>