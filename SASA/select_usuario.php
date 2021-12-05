<html>
    <body>
        <style>
 @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;	
	font-family: Raleway, sans-serif;
}

body {
	background: linear-gradient(90deg, #C7C5F4, #776BCC);	/*BACKGROUND DO HTML*/	
}

.container {
    padding-top: 65px;
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
}

.screen {		
	background: linear-gradient(90deg, #5D54A4, #7C78B8);		
	position: relative;	
	height: 600px;
	width: 360px;	
	box-shadow: 0px 0px 24px #5C5696;
}

.screen__content {
	z-index: 1;
	position: relative;	
	height: 100%;
}

.screen__background {		
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 0;
	-webkit-clip-path: inset(0 0 0 0);
	clip-path: inset(0 0 0 0);	
}

.screen__background__shape {
	transform: rotate(45deg);
	position: absolute;
}

.screen__background__shape1 {
	height: 520px;
	width: 520px;
	background: #FFF;	
	top: -50px;
	right: 120px;	
	border-radius: 0 72px 0 0;
}

.screen__background__shape2 {
	height: 220px;
	width: 220px;
	background: #6C63AC;	
	top: -172px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape3 {
	height: 540px;
	width: 190px;
	background: linear-gradient(270deg, #5D54A4, #6A679E);
	top: -24px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape4 {
	height: 400px;
	width: 200px;
	background: #7E7BB9;	
	top: 420px;
	right: 50px;	
	border-radius: 60px;
}

.login {
	width: 320px;
	padding: 30px;
	padding-top: 156px;
}

.login__submit {
	background: #fff;
	font-size: 14px;
	margin-top: 30px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #D4D3E8;
	text-transform: uppercase;
	font-weight: 700;
	display: flex;
	align-items: center;
	width: 100%;
	color: #4C489D;
	box-shadow: 0px 2px 2px #5C5696;
	cursor: pointer;
	transition: .2s;
}

.login__submit:active,
.login__submit:focus,
.login__submit:hover {
	border-color: #6A679E;
	outline: none;
}

#selectuser {
    border-radius:4px;
    border:1px solid #AAAAAA; 
    font-size: 15px;
	width:250px;  
}

h3 span {
     color: rgba(0, 0, 0, 1);
	 font-weight: 700;
}


        </style>
    <?php
    $db = new SQLite3("future.db");
    $db->exec("PRAGMA foreign_keys = ON");
	//$total = $db->query("select count(*) as total from usuario")->fetchArray()["total"];
    echo '<div class="container">';
    echo '<div class="screen">';
    echo '<div class="screen__content">';

    echo "<form name=\"login\" id = \"form\" class=\"login\" action=\"feed.php\" method=\"POST\" onsubmit=\"return confirma();\">\n";

    echo '<h3>Bem-vindo ao <span>FUTURE</span></h3>';
    echo '<h4>Entre na sua conta.</h4>';
    echo '<br>';
	echo '<select name="selectuser" id="selectuser" onchange="muda();" autofocus required>';
	$results = $db->query("select usuario.email as email, usuario.nome as nome from usuario");
    echo '<option value="" disabled selected>Selecione um usuário</option>';
	while ($row = $results->fetchArray()) {
		echo "<option name=\"".$row["email"]."\" value=\"".$row["email"]."\">".ucwords(strtolower($row["nome"])).' - '.strtolower($row["email"])."</option>\n";
	}
	
    echo '</select>';
// 	while ($row1 = $results->fetchArray()) {
// 	echo "<a href=\"feed.php?email=".$row1["email"]."\">asasd</a>\n";

// }
	echo '<input type = "hidden" id ="teste" name ="teste"></input>';
    echo '<button type="submit" action = "feed.php?email='.$row["email"].'" class="button login__submit">';
    echo '<span class="button__text">Entrar</span>';
    //echo '<i class="button__icon fas fa-chevron-right"></i>';
    echo '</button>';
    echo '<br>';
    echo " <a href=\"cadastro_usuario.php\">Cadastre-se</a>";
    //echo '<input type="submit" value="Login" />';
    echo "</form>\n";
    echo '</div>';
    echo '<div class="screen__background">';
    echo '<span class="screen__background__shape screen__background__shape4"></span>';
    echo '<span class="screen__background__shape screen__background__shape3"></span>';
    echo '<span class="screen__background__shape screen__background__shape2"></span>';
    echo '<span class="screen__background__shape screen__background__shape1"></span>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    ?>
    </body>
    <script>
function muda() {
	let select = document.getElementById("selectuser").value;
	let b = document.getElementById("form");
	
	

	console.log(select)
	b.setAttribute('action', 'feed.php?email='+select+'' )
}
        function confirma(e) {
if (login.selectuser.value == '') {
            alert("Nenhum usuário foi selecionado.");
            document.getElementById("selectuser").focus();
						return false;
    } else {
        var e = document.getElementById("selectuser");
        var text = e.options[e.selectedIndex].text;
        //var value = e.options[e.selectedIndex].value;
        let string = text[0].toUpperCase() + text.slice(1).toLowerCase();
        let trecho = string.substring(0, string.indexOf(' -'));
        if (confirm('Deseja continuar como ' + trecho + '?')) {
            e.submit();
       }
           return false;
       }
    }

        
    </script>
</html>
