let options1 = []
let options = []
let guardar = []


function add() {
let select1 = document.querySelector("#selectassuntos");
let select = document.getElementById("selectassuntos").value;
let option = select1.options[select1.selectedIndex].value;
let add = document.getElementById("add")

if (options.indexOf(option) !== -1) {
    alert("Assunto já inserido");
    return;
} else {

    options.push(select);
    add.innerHTML += " - " + select1[options[options.length - 1] - 1].text + " - ";
    document.getElementById("array").setAttribute('value', options);
}
}



function add1(num) {
let select = document.getElementById("selectassuntos" + num).value
let select1 = document.querySelector("#selectassuntos" + num)
let mais = document.querySelectorAll("#mais")[num];
let add = document.getElementById("add" + num);
let b = document.querySelectorAll("#arrayt").length;
let c = document.querySelectorAll("#arrayt");
let option = select1.options[select1.selectedIndex].value;



if (guardar !== select1.name) {
    let add2 = document.getElementById("add" + guardar);
    add2.innerHTML = "";
    options1 = []
}

guardar = select1.name;

if (options1.indexOf(option) !== -1) {
    alert("Assunto já inserido");
    return;
} else {

    // console.log(add)
    // console.log(guardar)
    options1.push(option);
    for (i = 0; i < b; i++) {
    c[i].setAttribute('value', options1)
    // console.log(c[i])
    }

    add.innerHTML += " - " + select1[options1[options1.length - 1] - 1].text + " - ";
}
// select1.options[select1.selectedIndex].text
}

function tira(that) {
let c = document.querySelectorAll("#arrayt");
let select = document.getElementById("selectassuntos" + that).value
let select1 = document.querySelector("#selectassuntos" + that)
let option = select1.options[select1.selectedIndex].value;
let b = document.querySelectorAll("#arrayt").length;
let add = document.getElementById("add" + that);
console.log(option)
options1 = []
add.removeChild(add.lastChild)
console.log(options1)
for (i = 0; i < b; i++) {
    c[i].setAttribute('value', options1)
}
};


function tira1(that) {
let select1 = document.querySelector("#selectassuntos")
let select = document.getElementById("selectassuntos").value
let add = document.getElementById("add")

options = []
add.innerHTML = "";

};

// var button = document.getElementById("button");
// button.addEventListener("click", verificaPattern);

function verificaPattern() {
    alert('oi')
if (document.getElementById("pagina") != undefined) {
    var nome = document.getElementById("pagina");
} else if (document.getElementById("grupo") != undefined) {
    var nome = document.getElementById("grupo");
}
let padrao = new RegExp(nome.pattern);
if (!padrao.test(nome.value)) {
    alert('Nome no formato inválido');
} else {
    document.getElementById("form").submit();
}
}