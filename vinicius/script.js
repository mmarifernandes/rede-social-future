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
}
        
function add1(){
    let select = document.getElementById("selectassuntoscoment").value
    options1.push(select);
    let x = options1.length;
    let add = document.getElementById("add1")
    console.log(options1)
    add.innerHTML +=  " - "+select1[options1[options1.length-1]-1].text + " - ";
    document.getElementById("array1").setAttribute('value', options1 )
}

function paginaGrupo(valor, login) {
    if(valor != "grupo" && valor != "pagina") {
        alert("Valor informado inválido tente novamente");
        return false;
    }else {
        let div = document.getElementById("formulario");
        div.innerHTML = "<form id='form' action='feed.php?email="+login+"' method='post'><table><tr><td>Nome "+`${valor}`+": <input type='text' id='"+`${valor}`+"' name='"+`${valor}`+"' maxlength='100' pattern='([a-zA-Z0-9]+ |[a-zA-Z0-9]+)+'> </td></tr><tr><td>Descrição: <textarea name='descricao' maxlength='200'></textarea> </td></tr><tr><td><input type='text' name='usuario' class='hidden' value='"+login+"'></td></tr><tr><td><button type='button' id='button' name='confirma'>Criar "+`${valor}`+"</button></td></tr></table></form>";
        var button = document.getElementById("button");
        button.addEventListener("click", verificaPattern);
    }
}

function verificaPattern() {
    if(document.getElementById("pagina") != undefined) {
        var nome = document.getElementById("pagina");
    }else if(document.getElementById("grupo") != undefined) {
        var nome = document.getElementById("grupo");
    }
    let padrao = new RegExp(nome.pattern);
    if (!padrao.test(nome.value)) {
        alert('Nome no formato inválido');
    }else {
        document.getElementById("form").submit();
    }
}