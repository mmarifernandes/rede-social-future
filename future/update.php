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



	$results = $db->query("select usuario, hora_post as data, conteudo from interacao where codigo = ".$_GET["codigo"]);
		while ($row = $results->fetchArray()) {
        
      echo '<div id = nome>';
      echo ucfirst(strtolower($row["usuario"]));
      echo '<div id = data>';
      echo $row["data"];
    //   $results5 = $db->query("select group_concat(assunto.nome, ', ') as assunto from assunto_interacao join assunto on assunto.codigo = assunto_interacao.assunto where interacao = ".$info["codigo"]);
      
    //   while ($row5 = $results5->fetchArray()) {
    //     echo '<div id = assuntos>';
    //     echo $row5["assunto"];
    //     echo '</div>';
    //   }
      echo '</div>';
      echo '</div>';
          echo '<select id="selectassuntos" name="0">';
	$results4 = $db->query("select nome, codigo from assunto");
	while ($row4 = $results4->fetchArray()) {
		echo "<option value=\"".$row4["codigo"]."\">".strtolower($row4["nome"])."</option>\n";
	}
	echo '</select>';
  echo'<input type="button" id = "mais" value="0" onclick="add();">';
  echo'<input type="hidden" id = "array" name ="array">';

  echo '<div id="add"></div>';
      echo '<div class = "conteudo">';
      echo '<textarea id="conteudo" name="conteudo" rows="4" cols="90" style="max-width:100%;">';
      echo $row["conteudo"];
      echo '</textarea>';
      echo '</div>';
    }
      echo '<button type="submit" name="confirmar">Confirmar</button>';

	?>
      
</body>
<script>
    	let options1 = []
  	let options = []
      	let guardar = []

    function add(){
		let select1 = document.querySelector("#selectassuntos")

  let select = document.getElementById("selectassuntos").value
  options.push(select);
  let x = options.length;
  let add = document.getElementById("add")
  console.log(options)
  add.innerHTML +=  " - "+select1[options[options.length-1]-1].text + " - ";
  document.getElementById("array").setAttribute('value', options );
}
</script>
</html>