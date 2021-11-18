<html>
  <body>
      <style>
          html, body {
  background: #e9ebee;
  height: 100%;
  margin: 0;
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
#nome{
    font-weight: bold;
    padding: 20px;
    
}
#data{
      font-size: 12px;
      font-weight: normal;
}
#reactions{
      margin-top: 30px;
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
    // $login = $_POST['selectuser'];
    // $email = $_POST['email'];
    // echo $login;
    // echo strtoupper($email);
    $results = $db->query("select conteudo, usuario.nome as usuario from interacao  join usuario on interacao.usuario = usuario.email where tipo = 'POST'");
 

    echo '<div class="container-box">';
    echo '<header class="header"></header>';
    echo '<main class="main">';
    echo '<section class="menu">';
    echo '</section>';
    echo '<section class="feed">';
    // echo $nome;
    while ($row = $results->fetchArray()) {
      echo '<div id="post">';
    // echo '<br>';
    echo '<div id = nome>';
    echo ucfirst(strtolower($row["usuario"]));
    echo '<div id = data>';
    echo 'Há uma hora atrás';
    echo '</div>';
    echo '</div>';
    echo ucfirst(strtolower($row["conteudo"]));
    echo '<div id = reactions>';
     echo '<button id="myBtn">Curtir</button>';
echo '<div id="myModal" class="modal">';
echo '<div class="modal-content">';
echo '<span class="close">&times;</span>';
echo '<p>Some text in the Modal..</p>';
echo '</div>';
echo '</div>';
    echo '</div>';
    echo '</div>';
   
	}
    echo '</section>';
echo '<section class="event"></section>';
echo '</main>';
echo '</div>';

        ?>
</body>
<script>
  // Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
  </script>
</html>