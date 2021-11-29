<html>
  <body>
      <style>
         @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

          html, body {
  background: #e9ebee;
  height: 100%;
  margin: 0;
}
/*
.dropbtn {
  background-color: #3498DB;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}


.dropbtn:hover, .dropbtn:focus {
  background-color: #2980B9;
}


.dropdown {
  position: relative;
  display: inline-block;
}


.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}


.dropdown-content a:hover {background-color: #ddd}


.show {display:block;}
*/
a:link { text-decoration: none; }
a:visited { text-decoration: none; }
a:hover { text-decoration: none; }
a:active { text-decoration: none; }

* {
  font-family: Raleway, sans-serif;
}

.container-box {
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: auto 200px;
  grid-template-rows: 40px 1fr;
  grid-template-areas:
    'header header'
    'main aside'
    'footer footer'
  ;
}

.header {
  grid-area: header;
  background: linear-gradient(270deg, #5D54A4, #6A679E);
}

.main {
  grid-area: main;
  display: grid;
  grid-template-columns: 150px minmax(100px,1fr) 200px;
  grid-template-rows: auto;
  grid-template-areas: 'menu feed event';
  grid-gap: 10px;
  padding: 10px 40px;
}

.aside {
  grid-area: aside;
  border-left: 2px solid #ccc;
}

.menu {
  grid-area: menu;
}

.feed {
  grid-area: feed;
  background: #fff;
}

.event {
  grid-area: event;
  background: #fff;
}
#post{
    padding: 80px;
    font-size: 16px;
    font-family: Calibri;
    border-left: solid;
    border-color: #5D54A4;
    margin-bottom: 30px;
    border-width: 6px;
    

}
#comentarios{
    padding: 50px;
    padding-top: 20px;
    padding-bottom: 20px;
    font-size: 14px;
    font-family: Calibri;
    /* border: solid;
    border-color: #000; */
    /* border-radius: px; */
    background-color: #ECEAFC;
    margin-bottom: 10px;
    /* border-width: 3px;  */
    

}
#comentarios2{
    padding: 50px;
    padding-top: 20px;
    padding-bottom: 20px;
    font-size: 14px;
    font-family: Calibri;
    /* border: solid;
    border-color: #000; */
    /* border-radius: px; */
    background-color: #dbd7fc;
    margin-bottom: 10px;
    /* border-width: 3px;  */
    

}

#postar{
    padding: 80px;
    font-size: 16px;
    font-family: Calibri;
    border-left: solid;
    border-color: #5D54A4;
    margin-bottom: 30px;
    border-width: 6px;
    

}
#nome{
    font-weight: bold;
    padding: 20px;
    font-size: 18px;
    
}
#data{
      font-size: 12px;
      font-weight: normal;
}
#reactions{
      margin-top: 30px;
      background-color: #5D54A4;
      color: #fff
}
#coment{
      margin-top: 30px;
}
#conteudo{
       font-weight: normal;
}
#assuntos{
       color: #5D54A4;
}
#add{
       color: #5D54A4;
}

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
      </style>
<?php
    $db = new SQLite3("future.db");
    $db->exec("PRAGMA foreign_keys = ON");
    // $nome = $_POST['nome'];
    // $email = $_POST['email'];

    // echo strtoupper($email);

$login = $_GET['email'];
$nome = $login;
//echo $nome;
  //  if(isset($login)){
   
    echo '<div class="container-box">';
    echo '<header class="header"></header>';
    echo '<main class="main">';
    echo '<section class="menu">';
    echo '</section>';
    echo '<section class="feed">';
    // echo $nome;
    
    echo '<div id = postar>';
    echo '<div id = nome>';
    $results1 = $db->query('select nome from usuario where email = '.'"'.$login.'"'.'');
    while ($row = $results1->fetchArray()) {
      echo ucfirst(strtolower($row['nome']));
    }
    echo '</div>';
    $resultsF = $db->query('select distinct nome as amigo, a.usuario2 as user2, a.usuario1 as user1, a.ativo as ativo
    from amizade as a
    left join amizade as b on a.usuario2 = b.usuario2
    left join usuario as p on a.usuario2 = p.email
    where a.usuario1  = '.'"'.$login.'"'.'');
    //$amigo = $_GET["amigo"];
    
    echo '<form name="formpost" method="post" action="#">';
    echo '<select id="selectassuntos" name="selectassuntos">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row = $results4->fetchArray()) {
		echo "<option value=\"".$row["codigo"]."\">".strtolower($row["nome"])."</option>\n";
	}
	echo '</select>';
  echo'<input type="button" id = "mais" value="+" onclick="add();">';
  echo'<input type="hidden" id = "array" name ="array">';

  echo '<div id="add"></div>';
    echo '<textarea id="conteudo" name="conteudo" rows="4" cols="50" placeholder = "O que você está pensando?">';
    echo '</textarea>';
    
    echo '<button name="postar" type="submit">Publicar</button>';
    echo '</form>';
    echo '</div>';
    
    
    $results = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'POST' order by data desc");
    while ($row = $results->fetchArray()) {
      
      $results3 = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'COMENTARIO' and referencia = ".$row["codigo"]."");
      $results5 = $db->query("select group_concat(assunto.nome, ', ') as assunto from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = ".$row["codigo"]);
      $results7 = $db->query("select usuario.nome as usuarionome from interacao join usuario on usuario.email = interacao.usuario where tipo = 'CURTIR' and referencia =".$row["codigo"]);
      $results8 = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario, referencia from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'COMPARTILHAMENTO' and referencia =".$row["codigo"]." order by data desc");

 while ($row8 = $results8->fetchArray()) {
        $results9 = $db->query("select usuario.nome as usuarionome from interacao join usuario on usuario.email = interacao.usuario where tipo = 'CURTIR' and referencia =".$row8["codigo"]);

   echo '<div id="post" name='.$row8["codigo"].'>';
   echo $row8["usuario"]. ' compartilhou';
      

	
    echo '<div id = nome>';
    echo ucfirst(strtolower($row["usuario"]));
    echo '<div id = data>';
    echo $row["data"];
      while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '</div>';
    
    echo '</div>';
   
  
    echo '<div id = conteudo>';
    echo $row["conteudo"];
    echo '</div>';

    

 echo '<form name="formcurtir" method="post" action="#">';
    echo '<div id = reactions>';

     echo '<button type="submit" name="curtir">Curtir</button>';
	echo '<input type="hidden" name="codigocoment2" value="'.$row8["codigo"].'">';

  echo '<select id="selectassuntoscoment" name="selectassuntoscoment">';
	$results4 = $db->query("select nome, codigo from assunto");
  //where email = '.'"'.$login.'"'.'');

	while ($row4 = $results4->fetchArray()) {
		echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	}
	echo '</select>';
  echo'<input type="button" id = "maiscoment" value="+" onclick="add1();">';
  while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '<div id="add1"></div>';

  echo'<input type="hidden" id = "array1" name ="array1">';

// echo '<p>Deseja marcar alguém?</p>';
    echo '</form>';
    echo '</div>';
  while ($row9 = $results9->fetchArray()) {
    echo $row9["usuarionome"]. ' curtiu'. '<br>';

    }
    echo '</div>';

  }

      echo '<div id="post" name='.$row["codigo"].'>';
      echo $row["codigo"];

    $id = $row['codigo'];	
    echo '<div id = nome>';
    echo ucfirst(strtolower($row["usuario"]));
    echo '<div id = data>';
    echo $row["data"];
      while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '</div>';
    
    echo '</div>';
   
  
    echo '<div id = conteudo>';
    echo $row["conteudo"];
    echo '</div>';


    echo '<form name="formcurtir" method="post" action="#">';
    echo '<div id = reactions>';

     echo '<button type="submit" name="curtir">Curtir</button>';
	echo '<input type="hidden" name="codigocoment2" value="'.$row["codigo"].'">';

  echo '<select id="selectassuntoscoment" name="selectassuntoscoment">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row4 = $results4->fetchArray()) {
		echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	}
	echo '</select>';
  echo'<input type="button" id = "maiscoment" value="+" onclick="add1();">';
  while ($row5 = $results5->fetchArray()) {
    echo '<div id = assuntos>';
    echo $row5["assunto"];
    echo '</div>';
  }
    echo '<div id="add1"></div>';

  echo'<input type="hidden" id = "array1" name ="array1">';

// echo '<p>Deseja marcar alguém?</p>';
    echo '</form>';
    echo '</div>';

 echo '<form name="formccompartilhar" method="post" action="#">';
    echo '<div id = compartilhar>';

     echo '<button type="submit" name="compartilhar">Compartilhar</button>';
	echo '<input type="hidden" name="codigocoment3" value="'.$row["codigo"].'">';
    echo '</div>';

  // echo '<select id="selectassuntoscoment" name="selectassuntoscoment">';
	// $results4 = $db->query("select nome, codigo from assunto");
	// while ($row4 = $results4->fetchArray()) {
	// 	echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	// }
	// echo '</select>';
  // echo'<input type="button" id = "maiscoment" value="+" onclick="add1();">';
  // while ($row5 = $results5->fetchArray()) {
  //   echo '<div id = assuntos>';
  //   echo $row5["assunto"];
  //   echo '</div>';
  // }
  //   echo '<div id="add1"></div>';

  // echo'<input type="hidden" id = "array1" name ="array1">';

// echo '<p>Deseja marcar alguém?</p>';
    echo '</form>';
    


       while ($row7 = $results7->fetchArray()) {
    echo $row7["usuarionome"]. ' curtiu'. '<br>';
    
  }
    echo '<div id = coment>';

    echo '<form name="formcomment" method="post" action="#">';
    echo '<input type="hidden" name="codigocoment" value="'.$row["codigo"].'">';
    
    echo '<textarea id="comentario" name="conteudocomentario" rows="4" cols="50" placeholder = "Escreva algo">';
    echo '</textarea>';
    
    echo '<button name = "comentar"type="submit">Comentar</button>';
    echo '</form>';

    echo '</div>';
    // echo '<br>';
    while ($row3= $results3->fetchArray()) {
      
      echo '<div id="comentarios" name='.$row3["codigo"].'>';
      echo '<div id = nome>';
      echo ucfirst(strtolower($row3["usuario"]));
      echo '<div id = data>';
      echo $row3["data"];
      echo '</div>';
      echo '</div>';
      echo $row3["conteudo"];
      
      echo '<div id = reactions>';
      echo '<button id="myBtn">Curtir</button>';
      echo '<div id="myModal" class="modal">';
      echo '<div class="modal-content">';
      echo '<span class="close">&times;</span>';
      echo '<p>Some text in the Modal..</p>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      echo '<div id = coment>';
      
      echo '<form name="formcomment" method="post" action="#">';
      echo '<input type="hidden" name="codigocoment" value="'.$row3["codigo"].'">';
      // echo $_POST['codigocoment'];
      echo '<textarea id="comentario" name="conteudocomentario" rows="2" cols="50" placeholder = "Escreva algo">';
      echo '</textarea>';
      
      echo '<button name = "comentar"type="submit">Comentar</button>';
      echo '</form>';
      
    echo '</div>';
    $results6 = $db->query("select codigo, conteudo, hora_post as data, usuario.nome as usuario from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'COMENTARIO' and referencia = ".$row3["codigo"]."");
  
    while ($row6 = $results6->fetchArray()) {
    
    echo '<div id="comentarios2" name='.$row6["codigo"].'>';
    echo '<div id = nome>';
    echo ucfirst(strtolower($row6["usuario"]));
    echo '<div id = data>';
    echo $row6["data"];
    echo '</div>';
    echo '</div>';
    echo $row6["conteudo"];
    
    echo '<div id = reactions>';
    echo '<button id="myBtn">Curtir</button>';
    echo '<div id="myModal" class="modal">';
    echo '<div class="modal-content">';
    echo '<span class="close">&times;</span>';
    echo '<p>Some text in the Modal..</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div id = coment>';
    
    echo '<form name="formcomment" method="post" action="#">';
    echo '<input type="hidden" name="codigocoment" value="'.$row6["codigo"].'">';
    
    echo '<textarea id="comentario" name="conteudocomentario" rows="2" cols="50" placeholder = "Escreva algo">';
    echo '</textarea>';
    
    echo '<button name = "comentar"type="submit">Comentar</button>';
    echo '</form>';
    
    echo '</div>';
    echo '</div>';
    
  }
    echo '</div>';
    
  }
  echo '</div>';
}
echo '</section>';
//echo "<td><a href=\"delete.php?codigo=".$row["codigo"]."\" onclick=\"return(confirm('Excluir ".ucfirst(strtolower($row["sabor"]))."?'));\">&#x1F5D1;</a></td>\n";
	echo "</tr>";

echo '<section class="event">';
echo '<center>';
echo '<h3>Amigos</h3>';
echo '<h6>Clique em um amigo se deseja excluí-lo da sua lista de amizades.</h6>';
echo '</center>';
while ($rowF = $resultsF->fetchArray()) {

  //echo "<a href=\"unfriend.php?email=".$login." onclick=\"return(confirm('Excluir ".ucfirst(strtolower($rowF["amigo"]))."?'))>$rowF["amigo"]</a>";
 /* echo '<div id="dropdown">';*/
  echo '<br>';
  echo '<center>';
  echo ($rowF["ativo"] == 0 ? "" : "<button type='button' disabled><a href=\"unfriend.php?usuario1=".$login."&usuario2=".$rowF["user2"]."\" onclick=\"return(confirm('Excluir ".ucwords(strtolower($rowF["amigo"]))." da sua lista de amizades?'));\">"." &#128100 ".ucwords(strtolower($rowF["amigo"]))."</a></button>");
  echo '</center>';
 /* echo ($rowF["ativo"] == 0 ? "" : "\n<button onclick='myFunction()' class='dropbtn'>"." &#128100 ". ucwords(strtolower($rowF["amigo"]))."</button>");

echo '<div id="myDropdown" class="dropdown-content">';
echo "<a href=\"unfriend.php?usuario1=".$login."&usuario2=".$rowF["user2"]."\" >Desfazer amizade</a>";

echo '</div>';
echo '</div>';*/
}


echo '</section>';

echo '</main>';
echo '</div>';
//$amigo = $_GET["amigo"];
// echo isset($_POST['comentar']);
// $nome=$_POST['nome'];
// $email=$_POST['email'];
// $data = date("Y/m/d");           
// $comentario=$_POST['comentario']; 
// echo $comentario;

// echo $_POST['codigocoment'];
$total = $db->query("select count(*) as total from interacao")->fetchArray()["total"];
if (isset($_POST['postar'])){
  $x = $_POST['array'];
  $valores = explode(",",$x);
  echo $x;
  $total++;
  $post_content  = $_POST['conteudo'];
  $db->exec("insert into interacao (codigo, usuario, tipo, cidade, conteudo) values ($total, '".$login."', 'POST',  1, '".$post_content."')");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
if (!empty($_POST['array'])){
	for($i=0;$i<count($valores);$i++){
					// echo $valores[$i];
					$db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
			}
}
}
if (isset($_POST['comentar'])){
  $total++;
  $comment_content  = $_POST['conteudocomentario'];
  $db->exec("insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values ($total, '".$login."', 'COMENTARIO', 1, '".$comment_content."', ".$_POST['codigocoment'].")");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
}
if (isset($_POST['curtir'])){
  echo 'asdad';
  $total++;
  $x = $_POST['array1'];
  $valores = explode(",",$x);
  $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '".$login."', 'CURTIR', 1, ".$_POST['codigocoment2'].")");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
if (!empty($_POST['array1'])){
	for($i=0;$i<count($valores);$i++){
					// echo $valores[$i];
					$db->exec("insert into assunto_interacao (assunto, interacao) values ($valores[$i], $total)");
			}
}
}					
if (isset($_POST['compartilhar'])){
  $total++;
  // $comment_content  = $_POST['conteudocomentario'];
  $db->exec("insert into interacao(codigo, usuario, tipo, cidade, referencia) values ($total, '".$login."', 'COMPARTILHAMENTO', 1, ".$_POST['codigocoment3'].")");
  echo "<script>window.location = 'feed.php?email=".$login."'</script>";
}			


// if(isset($_POST['comentar'])) #insere somente se no form foi escrito o nome
// {
//     $insert = $db->query("insert into interacao(codigo, usuario, tipo, cidade, conteudo, referencia) values (5, ".$login.", 'COMENTARIO', 1, ".$comentario.", ".$row["codigo"]);
   
// };
//     $results = $db->query("select usuario, conteudo from interacao where tipo = 'COMENTARIO' and referencia = ".$row["codigo"]);

//     while ($row = $results->fetchArray()) {


//     echo $exibir['usuario'];
//     echo "</br>";
//     echo $exibir['conteudo'];
//     echo "</br><hr>";
// }
  //  }
?>
      
</body>
<script>
  function muda() {
	let select = document.getElementById("selectuser").value;
	let b = document.getElementById("form");
	
	

	console.log(select)
	b.setAttribute('action', 'feed.php?email='+select+'' )
}
		let options = []
		let select1 = document.querySelector("#selectassuntos")
	let options1 = []
		let select2 = document.querySelector("#selectassuntos")

function add(){
  
  let select = document.getElementById("selectassuntos").value
  options.push(select);
  let x = options.length;
  let add = document.getElementById("add")
  console.log(options)
  add.innerHTML +=  " - "+select1[options[options.length-1]-1].text + " - ";
  document.getElementById("array").setAttribute('value', options )
// select1.options[select1.selectedIndex].text
          }
          
function add1(){
  
  let select = document.getElementById("selectassuntoscoment").value
  options1.push(select);
  let x = options1.length;
  let add = document.getElementById("add1")
  console.log(options1)
  add.innerHTML +=  " - "+select1[options1[options1.length-1]-1].text + " - ";
  document.getElementById("array1").setAttribute('value', options1 )
// select1.options[select1.selectedIndex].text
          }

function teste() {
  console.log("asdasd")
}

/*

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}*/
  </script>
</html>