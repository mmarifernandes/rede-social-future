<html>
	<body>
        <style>
#nome{
    font-weight: bold;
    padding: 20px;
    font-size: 18px;
        font-family: Calibri;

}
#data{
      font-size: 12px;
      font-weight: normal;
          font-family: Calibri;

}
.conteudo{
       padding: 10px;
           font-family: Calibri;

        /* border: solid; */
    /* border-color: #000;  */
    /* border-radius: 17px;  */
        /* border-width:1px;  */

}
        </style>

		<?php
if (isset($_GET["codigo"])) {
	$db = new SQLite3("future.db");
	$db->exec("PRAGMA foreign_keys = ON");
}

$options = [];
$optionsc = [];

echo '<form name="formupdate" method="post" action="#">';
$login = $_GET['email'];
echo "<button><a href='feed.php?email=" . $login . "'>Voltar</a></button>";

$results = $db->query("select usuario, hora_post as data, tipo, grupo, conteudo from interacao where codigo = ".$_GET["codigo"]);
while ($row = $results->fetchArray()) {
    if($row["tipo"] == 'POST' || $row["tipo"] == 'COMENTARIO' ){
        echo'<input type="hidden" id = "tipo" name ="tipo" value = '.$row["tipo"].'>';

      echo '<div id = nome>';
      echo ucfirst(strtolower($row["usuario"]));
      echo '<div id = data>';
      echo $row["data"];
      echo '</div>';
      echo '</div>';
    
           echo '<div>';
echo 'Citar: ';
echo '<select id="selectcitar" name="selectcitar">';
$resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '".$login."'");
while ($rowc = $resultsc->fetchArray())
{
    echo "<option value=\"" . $rowc["codigo"] . "\">" . ucwords(strtolower($rowc["nome"])) . "</option>\n";
}
echo '</select>';
echo '<input type="button" id = "mais" value="+" onclick="addcitar();">';
echo "<input type=\"button\" id = \"del\" name = \"delcitar\" value=\"-\" onclick=\"tiracitar()\";>";
 echo '<div id="addcitar">';
  $results9 = $db->query("select group_concat(usuario.nome, ', ') as nome from citacao_usuario join usuario on usuario.email = citacao_usuario.usuario_marcado where interacao = ".$_GET["codigo"]);
  while ($row9 = $results9->fetchArray()) {
      echo  ucwords(strtolower($row9["nome"]));
}

  $results8 = $db->query("select usuario_marcado from citacao_usuario where interacao = ".$_GET["codigo"]);
  while ($row8 = $results8->fetchArray()) {
      $optionsc[] = $row8["usuario_marcado"];
      
	$citacao = implode(",",$optionsc);
}
echo '</div>';
    if(isset($citacao)){
    echo'<input type="hidden" id = "arraycita" name ="arraycita" value = '.$citacao.'>';
}else{
    echo'<input type="hidden" id = "arraycita" name ="arraycita">';
    
}
          echo '<select id="selectassuntos" name="0">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row4 = $results4->fetchArray()) {
		echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	}
	echo '</select>';
    
  echo'<input type="button" id = "mais" value="+" onclick="add();">';
  echo "<input type=\"button\" id = \"del\" name = \"delassuntos\" value=\"-\" onclick=\"tira1()\";>";

  echo '<div id="add">';
  $results5 = $db->query("select group_concat(assunto.nome, ' - ') as assunto, assunto as codigo from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = ".$_GET["codigo"]);
  while ($row5 = $results5->fetchArray()) {
      echo $row5["assunto"];
}

  $results6 = $db->query("select assunto as codigo from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = ".$_GET["codigo"]);
  while ($row6 = $results6->fetchArray()) {
  $options[] += $row6["codigo"];
	$valores = implode(",",$options);
    // print_r($options);
}

echo'</div>';
if(isset($valores)){
    echo'<input type="hidden" id = "array" name ="array" value = '.$valores.'>';
}else{
    echo'<input type="hidden" id = "array" name ="array">';

}
      echo '<div class = "conteudo">';
      echo '<textarea id="conteudo" name="conteudo" rows="4" cols="90" style="max-width:100%;">';
      echo $row["conteudo"];
      echo '</textarea>';
      echo '</div>';
      
         if(isset($row["grupo"]) && $row["tipo"] == 'POST'){
            echo '<div>';
echo ' Remover do grupo? ';
echo '<select id="selectgrupo" name="selectgrupo">';
    echo "<option value=1>Sim</option>\n";
    echo "<option value=2>Não</option>\n";

echo '</select>';
echo '</div>';
      }
    }else{
        echo'<input type="hidden" id = "tipo" name ="tipo" value = '.$row["tipo"].'>';

  echo '<div id = nome>';
      echo ucfirst(strtolower($row["usuario"]));
      echo '<div id = data>';
      echo $row["data"];
      echo '</div>';
      echo '</div>';
      
echo 'Citar: ';
echo '<select id="selectcitar" name="selectcitar">';
$resultsc = $db->query("select nome, usuario1 as codigo from amizade join usuario on amizade.usuario1 = usuario.email where amizade.ativo = 1 and usuario2 = '".$login."'");
while ($rowc = $resultsc->fetchArray())
{
    echo "<option value=\"" . $rowc["codigo"] . "\">" . ucwords(strtolower($rowc["nome"])) . "</option>\n";
}
echo '</select>';
echo '<input type="button" id = "mais" value="+" onclick="addcitar();">';
echo "<input type=\"button\" id = \"del\" name = \"delcitar\" value=\"-\" onclick=\"tiracitar()\";>";

  echo '<div id="addcitar">';
  $results9 = $db->query("select group_concat(usuario.nome, ', ') as nome from citacao_usuario join usuario on usuario.email = citacao_usuario.usuario_marcado where interacao = ".$_GET["codigo"]);
  while ($row9 = $results9->fetchArray()) {
      echo  ucwords(strtolower($row9["nome"]));
}

  $results8 = $db->query("select usuario_marcado as codigo from citacao_usuario where interacao = ".$_GET["codigo"]);
  while ($row8 = $results8->fetchArray()) {
  $optionsc[] = $row8["codigo"];
	$citacao = implode(",",$optionsc);
    // print_r($options);
}
echo'</div>';

if(isset($citacao)){
    echo'<input type="hidden" id = "arraycita" name ="arraycita" value = '.$citacao.'>';
}else{
    echo'<input type="hidden" id = "arraycita" name ="arraycita">';
    
}
          echo '<select id="selectassuntos" name="0">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row4 = $results4->fetchArray()) {
		echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	}
	echo '</select>';
    
  echo'<input type="button" id = "mais" value="+" onclick="add();">';
  echo "<input type=\"button\" id = \"del\" name = \"delassuntos\" value=\"-\" onclick=\"tira1()\";>";

  echo '<div id="add">';
  $results5 = $db->query("select group_concat(assunto.nome, ' - ') as assunto, assunto as codigo from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = ".$_GET["codigo"]);
  while ($row5 = $results5->fetchArray()) {
      echo $row5["assunto"];
}

  $results6 = $db->query("select assunto as codigo from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = ".$_GET["codigo"]);
  while ($row6 = $results6->fetchArray()) {
  $options[] = $row6["codigo"];
	$valores = implode(",",$options);
    // print_r($options);
}

echo'</div>';


if(isset($valores)){
    echo'<input type="hidden" id = "array" name ="array" value = '.$valores.'>';
}else{
    echo'<input type="hidden" id = "array" name ="array">';

}
         if(isset($row["grupo"]) && $row["tipo"] == 'POST'){
            echo '<div>';
echo ' Remover do grupo? ';
echo '<select id="selectgrupo" name="selectgrupo">';
    echo "<option value=1>Sim</option>\n";
    echo "<option value=2>Não</option>\n";

echo '</select>';
echo '</div>';
      }
    }
        }
      echo '<button type="submit" name="confirmar">Confirmar</button>';
            echo '</form>';

if (isset($_POST['confirmar']))
{



if($_POST["tipo"] == 'CURTIR' || $_POST["tipo"] == 'COMPARTILHAMENTO'){
       $x = $_POST['array'];
    $valores = explode(",", $x);
      $b = $_POST['arraycita'];
        $citacao = explode(",", $b);
 if (!empty($_POST['array']))
    {
        			$db->exec("delete from assunto_interacao where interacao = " .$_GET["codigo"]);
            // $db->exec("update interacao set data = default where codigo = ".$_GET["codigo"]);

        for ($i = 1;$i < count($valores);$i++)
        {
            // echo $valores[$i];
            $db->exec("insert into assunto_interacao (assunto, interacao) values (".$valores[$i].", '".$_GET['codigo']."')");
        }
    }else{
                			$db->exec("delete from assunto_interacao where interacao = " .$_GET["codigo"]);

    }
     if (!empty($_POST['arraycita']))
        {
            $db->exec("delete from citacao_usuario where interacao = " .$_GET["codigo"]);

            for ($i = 1;$i < count($citacao);$i++)
            {
                // echo $valores[$i];
                $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('".$citacao[$i]."', ".$_GET['codigo'].")");
            }
        }else{
                        $db->exec("delete from citacao_usuario where interacao = " .$_GET["codigo"]);

        }
    echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
// if($_POST["selectgrupo"] !== '0'){
//             $db->exec("update interacao set grupo = '".$_POST["selectgrupo"]."' where codigo = ".$_GET["codigo"]);

// }

}else{
     if ($_POST["conteudo"] == "")
    {
        echo "<font color=\"red\" size=\"20px\"> Digite algo! </font>";
        echo '<script>';
        echo 'alert("Você precisa digitar algo antes!")';
        echo '</script>';
        echo "<script>window.location = 'feed.php?email='".$login."'&codigo='".$_GET["codigo"]."'</script>";
    }
    else
    {
    $x = $_POST['array'];
    $valores = explode(",", $x);
    // print_r ($valores);
        $b = $_POST['arraycita'];
        $citacao = explode(",", $b);
    // $comment_content  = $_POST['conteudocomentario'];
			$db->exec("update interacao set conteudo = '".$_POST["conteudo"]."' where codigo = ".$_GET["codigo"]);
            // $db->exec("update interacao set data = default where codigo = ".$_GET["codigo"]);

    if (!empty($_POST['array']))
    {
        			$db->exec("delete from assunto_interacao where interacao = " .$_GET["codigo"]);

        for ($i = 1;$i < count($valores);$i++)
        {
            echo $valores[0];
            $db->exec("insert into assunto_interacao (assunto, interacao) values (".$valores[$i].", ".$_GET['codigo'].")");
        }
    }else{
                			$db->exec("delete from assunto_interacao where interacao = " .$_GET["codigo"]);

    }
        if(isset($_POST["selectgrupo"])){

    if($_POST["selectgrupo"] == 1){

        			$db->exec("update interacao set grupo = null where codigo = ".$_GET["codigo"]);

}
        }
  if (!empty($_POST['arraycita']))
        {
            $db->exec("delete from citacao_usuario where interacao = " .$_GET["codigo"]);

            for ($i = 1;$i < count($citacao);$i++)
            {
                // print_r($citacao[$i]);
         
                $db->exec("insert into citacao_usuario (usuario_marcado, interacao) values ('".$citacao[$i]."', ".$_GET['codigo'].")");
            }
        }else{
                        $db->exec("delete from citacao_usuario where interacao = " .$_GET["codigo"]);

        }
    echo "<script>window.location = 'feed.php?email=" . $login . "'</script>";
}
}
}


$db->close();
	?>
      
</body>
<script>
    let options = []
    let guardar = []
    let b =document.querySelector("#array").value
    let x = b.split(",");
    options=x;
    let optionsc = []
    let guardarc = []
    let c =document.querySelector("#arraycita").value
    let y = c.split(",");
    console.log(b)
  optionsc=y;
  console.log(optionsc)

function add(){
    let select1 = document.querySelector("#selectassuntos");
    let select = document.getElementById("selectassuntos").value;
    let option = select1.options[select1.selectedIndex].value;
    let add = document.getElementById("add")

  	if(options.indexOf(option) !== -1) {
			alert("Assunto já inserido");
			return;
		}else{
    
  options.push(select);
  add.innerHTML +=  " - "+select1[options[options.length-1]-1].text + " - ";
  document.querySelector("#array").setAttribute('value', options );
    }
}

     	function tira1(){
  let select1 = document.querySelector("#selectassuntos")
  let select = document.getElementById("selectassuntos").value
  let add = document.getElementById("add")

  options=[]
    console.log(options)

  add.innerHTML= "";
    document.querySelector("#array").setAttribute('value', options );


	};

function addcitar(){
		let select1 = document.querySelector("#selectcitar");
  let select = document.getElementById("selectcitar").value;
  // let option = select1.optionsc[select1.selectedIndex].value;
  let add = document.getElementById("addcitar")

  	if(optionsc.indexOf(select) !== -1) {
			alert("Pessoa já inserida");
			return;
		}else{
      
      optionsc.push(select);
      console.log(optionsc)
      add.innerHTML +=  " - "+[select1[select1.selectedIndex].text] + " - ";
      document.getElementById("arraycita").setAttribute('value', optionsc );
    }
  }

  	function tiracitar(that){
  let select1 = document.querySelector("#selectcitar")
  let select = document.getElementById("selectcitar").value
  let add = document.getElementById("addcitar")

  add.innerHTML = "";
  optionsc=[]
  console.log(options)
  document.getElementById("arraycita").setAttribute('value', optionsc );

	};


</script>
</html>