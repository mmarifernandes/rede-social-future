<?php
$db = new SQLite3("future.db");
$db->exec("PRAGMA foreign_keys = ON");

echo '<!DOCTYPE html>';
echo '<html lang="pt-br">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
echo '<style>';
echo 'table {';
echo 'border-collapse: collapse;';
echo 'margin: 0px auto;';
echo '}';
echo 'tr {';
echo 'border-bottom: 1px solid black;';
echo '}';
echo 'td {';
echo 'padding: 15px;';
echo '}';
echo '.faixa {';
echo 'text-align: center;';
echo '}';
echo '#ftable {';
echo 'border-bottom: none;';
echo '}';
echo '.f {';
echo 'color: red;';
echo '}';
echo '.m {';
echo 'color: blue;';
echo '}';
echo '.n {';
echo 'color: green;';
echo '}';
echo '</style>';
echo '<title>Gráfico de Interações</title>';
echo '</head>';
echo '<body>';

$f = array(
    '18' => array() ,
    '1821' => array() ,
    '2125' => array() ,
    '2530' => array() ,
    '3036' => array() ,
    '3643' => array() ,
    '4351' => array() ,
    '5160' => array() ,
    '60' => array()
);
$m = array(
    '18' => array() ,
    '1821' => array() ,
    '2125' => array() ,
    '2530' => array() ,
    '3036' => array() ,
    '3643' => array() ,
    '4351' => array() ,
    '5160' => array() ,
    '60' => array()
);
$n = array(
    '18' => array() ,
    '1821' => array() ,
    '2125' => array() ,
    '2530' => array() ,
    '3036' => array() ,
    '3643' => array() ,
    '4351' => array() ,
    '5160' => array() ,
    '60' => array()
);

$fvalores = array(
    '18' => 0,
    '1821' => 0,
    '2125' => 0,
    '2530' => 0,
    '3036' => 0,
    '3643' => 0,
    '4351' => 0,
    '5160' => 0,
    '60' => 0
);
$mvalores = array(
    '18' => 0,
    '1821' => 0,
    '2125' => 0,
    '2530' => 0,
    '3036' => 0,
    '3643' => 0,
    '4351' => 0,
    '5160' => 0,
    '60' => 0
);
$nvalores = array(
    '18' => 0,
    '1821' => 0,
    '2125' => 0,
    '2530' => 0,
    '3036' => 0,
    '3643' => 0,
    '4351' => 0,
    '5160' => 0,
    '60' => 0
);

$email = array();
$genero = array();
$nascimento = array();

$results = $db->query("select email, genero, data_nascimento from usuario join cidade on usuario.cidade = cidade.codigo join uf on cidade.uf = uf.codigo join pais on uf.pais = pais.codigo where pais.nome like 'BRASIL'");
while ($row = $results->fetchArray())
{
    array_push($email, $row['email']);
    array_push($genero, $row['genero']);
    array_push($nascimento, $row['data_nascimento']);
}

for ($c = 0;$c < count($nascimento);$c++)
{
    $diff = date_diff(new DateTime($nascimento[$c]) , new DateTime("now"));
    $idade = $diff->format('%a');
    $idade = (int)$idade * 24;

    if ($idade <= 157680)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['18'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['18'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['18'], $email[$c]);
        }
    }

    if ($idade > 157680 && $idade <= 183960)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['1821'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['1821'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['1821'], $email[$c]);
        }
    }

    if ($idade > 183960 && $idade <= 219000)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['2125'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['2125'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['2125'], $email[$c]);
        }
    }

    if ($idade > 219000 && $idade <= 262800)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['2530'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['2530'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['2530'], $email[$c]);
        }
    }

    if ($idade > 262800 && $idade <= 315360)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['3036'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['3036'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['3036'], $email[$c]);
        }
    }

    if ($idade > 315360 && $idade <= 376680)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['3643'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['3643'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['3643'], $email[$c]);
        }
    }

    if ($idade > 376680 && $idade <= 446760)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['4351'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['4351'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['4351'], $email[$c]);
        }
    }

    if ($idade > 446760 && $idade <= 525600)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['5160'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['5160'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['5160'], $email[$c]);
        }
    }

    if ($idade > 525600)
    {
        if ($genero[$c] == "F")
        {
            array_push($f['60'], $email[$c]);
        }
        else if ($genero[$c] == "M")
        {
            array_push($m['60'], $email[$c]);
        }
        else if ($genero[$c] == "N")
        {
            array_push($n['60'], $email[$c]);
        }
    }
}

foreach ($f as $k => $v)
{
    if ($k == '18')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['18'] = $fvalores['18'] + (int)$result;
            }
        }
    }
    if ($k == '1821')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['1821'] = $fvalores['1821'] + (int)$result;
            }
        }
    }
    if ($k == '2125')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['2125'] = $fvalores['2125'] + (int)$result;
            }
        }
    }
    if ($k == '2530')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['2530'] = $fvalores['2530'] + (int)$result;
            }
        }
    }
    if ($k == '3036')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['3036'] = $fvalores['3036'] + (int)$result;
            }
        }
    }
    if ($k == '3643')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['3643'] = $fvalores['3643'] + (int)$result;
            }
        }
    }
    if ($k == '4351')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['4351'] = $fvalores['4351'] + (int)$result;
            }
        }
    }
    if ($k == '5160')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['5160'] = $fvalores['5160'] + (int)$result;
            }
        }
    }
    if ($k == '60')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $fvalores['60'] = $fvalores['60'] + (int)$result;
            }
        }
    }
}

foreach ($m as $k => $v)
{
    if ($k == '18')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['18'] = $mvalores['18'] + (int)$result;
            }
        }
    }
    if ($k == '1821')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['1821'] = $mvalores['1821'] + (int)$result;
            }
        }
    }
    if ($k == '2125')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['2125'] = $mvalores['2125'] + (int)$result;
            }
        }
    }
    if ($k == '2530')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['2530'] = $mvalores['2530'] + (int)$result;
            }
        }
    }
    if ($k == '3036')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['3036'] = $mvalores['3036'] + (int)$result;
            }
        }
    }
    if ($k == '3643')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['3643'] = $mvalores['3643'] + (int)$result;
            }
        }
    }
    if ($k == '4351')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['4351'] = $mvalores['4351'] + (int)$result;
            }
        }
    }
    if ($k == '5160')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['5160'] = $mvalores['5160'] + (int)$result;
            }
        }
    }
    if ($k == '60')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $mvalores['60'] = $mvalores['60'] + (int)$result;
            }
        }
    }
}

foreach ($n as $k => $v)
{
    if ($k == '18')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['18'] = $nvalores['18'] + (int)$result;
            }
        }
    }
    if ($k == '1821')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['1821'] = $nvalores['1821'] + (int)$result;
            }
        }
    }
    if ($k == '2125')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['2125'] = $nvalores['2125'] + (int)$result;
            }
        }
    }
    if ($k == '2530')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['2530'] = $nvalores['2530'] + (int)$result;
            }
        }
    }
    if ($k == '3036')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['3036'] = $nvalores['3036'] + (int)$result;
            }
        }
    }
    if ($k == '3643')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['3643'] = $nvalores['3643'] + (int)$result;
            }
        }
    }
    if ($k == '4351')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['4351'] = $nvalores['4351'] + (int)$result;
            }
        }
    }
    if ($k == '5160')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['5160'] = $nvalores['5160'] + (int)$result;
            }
        }
    }
    if ($k == '60')
    {
        for ($c1 = 0;$c1 < count($v);$c1++)
        {
            $result = $db->querySingle("select count(*) from interacao join usuario on interacao.usuario = usuario.email where usuario.email = '" . $v[$c1] . "' and datetime(interacao.hora_post) between datetime('now', 'localtime', '-3 months') and datetime('now', 'localtime')");
            if ($result !== null)
            {
                $nvalores['60'] = $nvalores['60'] + (int)$result;
            }
        }
    }
}

echo '<table>';
echo '<tr id="ftable">';
echo '<td class="f" id="astf1"></p></td>';
echo '<td class="m" id="astm1"></p></td>';
echo '<td class="n" id="astn1"></p></td>';
echo '<td class="f" id="astf2"></p></td>';
echo '<td class="m" id="astm2"></p></td>';
echo '<td class="n" id="astn2"></p></td>';
echo '<td class="f" id="astf3"></p></td>';
echo '<td class="m" id="astm3"></p></td>';
echo '<td class="n" id="astn3"></p></td>';
echo '<td class="f" id="astf4"></p></td>';
echo '<td class="m" id="astm4"></p></td>';
echo '<td class="n" id="astn4"></p></td>';
echo '<td class="f" id="astf5"></p></td>';
echo '<td class="m" id="astm5"></p></td>';
echo '<td class="n" id="astn5"></p></td>';
echo '<td class="f" id="astf6"></p></td>';
echo '<td class="m" id="astm6"></p></td>';
echo '<td class="n" id="astn6"></p></td>';
echo '<td class="f" id="astf7"></p></td>';
echo '<td class="m" id="astm7"></p></td>';
echo '<td class="n" id="astn7"></p></td>';
echo '<td class="f" id="astf8"></p></td>';
echo '<td class="m" id="astm8"></p></td>';
echo '<td class="n" id="astn8"></p></td>';
echo '<td class="f" id="astf9"></p></td>';
echo '<td class="m" id="astm9"></p></td>';
echo '<td class="n" id="astn9"></p></td>';
echo '</tr>';
echo '<tr>';
echo '<td><p id="f1">' . $fvalores['18'] . '</p></td>';
echo '<td><p id="m1">' . $mvalores['18'] . '</p></td>';
echo '<td><p id="n1">' . $nvalores['18'] . '</p></td>';
echo '<td><p id="f2">' . $fvalores['1821'] . '</p></td>';
echo '<td><p id="m2">' . $mvalores['1821'] . '</p></td>';
echo '<td><p id="n2">' . $nvalores['1821'] . '</p></td>';
echo '<td><p id="f3">' . $fvalores['2125'] . '</p></td>';
echo '<td><p id="m3">' . $mvalores['2125'] . '</p></td>';
echo '<td><p id="n3">' . $nvalores['2125'] . '</p></td>';
echo '<td><p id="f4">' . $fvalores['2530'] . '</p></td>';
echo '<td><p id="m4">' . $mvalores['2530'] . '</p></td>';
echo '<td><p id="n4">' . $nvalores['2530'] . '</p></td>';
echo '<td><p id="f5">' . $fvalores['3036'] . '</p></td>';
echo '<td><p id="m5">' . $mvalores['3036'] . '</p></td>';
echo '<td><p id="n5">' . $nvalores['3036'] . '</p></td>';
echo '<td><p id="f6">' . $fvalores['3643'] . '</p></td>';
echo '<td><p id="m6">' . $mvalores['3643'] . '</p></td>';
echo '<td><p id="n6">' . $nvalores['3643'] . '</p></td>';
echo '<td><p id="f7">' . $fvalores['4351'] . '</p></td>';
echo '<td><p id="m7">' . $mvalores['4351'] . '</p></td>';
echo '<td><p id="n7">' . $nvalores['4351'] . '</p></td>';
echo '<td><p id="f8">' . $fvalores['5160'] . '</p></td>';
echo '<td><p id="m8">' . $mvalores['5160'] . '</p></td>';
echo '<td><p id="n8">' . $nvalores['5160'] . '</p></td>';
echo '<td><p id="f9">' . $fvalores['60'] . '</p></td>';
echo '<td><p id="m9">' . $mvalores['60'] . '</p></td>';
echo '<td><p id="n9">' . $nvalores['60'] . '</p></td>';
echo '</tr>';
echo '<tr>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '<td>F</td>';
echo '<td>M</td>';
echo '<td>N</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="faixa" colspan="3">-18</td>';
echo '<td class="faixa" colspan="3">18-21</td>';
echo '<td class="faixa" colspan="3">21-25</td>';
echo '<td class="faixa" colspan="3">25-30</td>F</td>';
echo '<td class="faixa" colspan="3">30-36</td>';
echo '<td class="faixa" colspan="3">36-43</td>';
echo '<td class="faixa" colspan="3">43-51</td>';
echo '<td class="faixa" colspan="3">51-60</td>';
echo '<td class="faixa" colspan="3">60-</td>';
echo '</tr>';
echo '</table>';

echo '<script>';
echo 'let ids1 = ["f1", "m1", "n1", "f2", "m2", "n2", "f3", "m3", "n3", "f4", "m4", "n4", "f5", "m5", "n5", "f6", "m6", "n6", "f7", "m7", "n7", "f8", "m8", "n8", "f9", "m9", "n9"];';
echo 'let ids2 = ["astf1", "astm1", "astn1", "astf2", "astm2", "astn2", "astf3", "astm3", "astn3", "astf4", "astm4", "astn4", "astf5", "astm5", "astn5", "astf6", "astm6", "astn6", "astf7", "astm7", "astn7", "astf8", "astm8", "astn8", "astf9", "astm9", "astn9"];';
echo '';
echo 'for (let c = 0; c < ids1.length; c++) {';
echo 'var valor = document.getElementById(ids1[c]).innerHTML;';
echo 'if (valor > 10) {';
echo 'var numero = (valor - (valor % 10)) / 10;';
echo 'var p = document.getElementById(ids2[c]);';
echo 'var asteriscos = "";';
echo 'for (let i = 0; i < numero; i++) {';
echo 'asteriscos = asteriscos + "*" + "<br>";';
echo '}';
echo 'p.innerHTML = asteriscos;';
echo '}';
echo '}';
echo '</script>';

echo '</body>';
echo '</html>';
$db->close();

?>
