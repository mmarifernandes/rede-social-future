let options1 = []
let options = []
let guardar = []

// let options1c = []
let optionsc1 = []
let optionsc = []

let guardarc = []

function verificaPattern() {
    if (document.getElementById("grupo") != undefined) {
        var nome = document.getElementById("grupo");
    }
    let padrao = new RegExp(nome.pattern);
    if (!padrao.test(nome.value)) {
        alert('Nome no formato inválido');
    } else {
        document.getElementById("form").submit();
    }
}

function mostra() {
    var input = document.getElementById("outra");
    var input2 = document.getElementById("adicionar");
    var mais = document.querySelectorAll("#mais")[1];
    var menos = document.querySelectorAll("#del")[1];
    console.log(menos)
    if (document.getElementById("selectassuntos").value == "outra") {
        input.style.display = "inline";
        input.disabled = false;
        input2.style.display = "inline";
        input2.disabled = false;
        mais.style.display = "none";
        mais.disabled = true;
        menos.style.display = "none";
        menos.disabled = true;
    } else {
        input.style.display = "none";
        input.value = "";
        input.disabled = true;
        input2.style.display = "none";
        input2.disabled = true;
        mais.style.display = "inline";
        mais.disabled = false;
        menos.style.display = "inline";
        menos.disabled = false;
    }
}




function add() {
    let select1 = document.querySelector("#selectassuntos");
    let select = document.getElementById("selectassuntos").value;
    let option = select1.options[select1.selectedIndex].value;
    let add = document.getElementById("add")

    if (select1.value == "outra") {
        let conteudo = document.getElementById("outra").value
        console.log(select1.length)
        options.push(conteudo);
        add.innerHTML += " - " + conteudo + " - ";
        document.getElementById("array").setAttribute('value', options);
    } else {
        if (options.indexOf(option) !== -1) {
            alert("Assunto já inserido");
            return;
        } else {

            options.push(select);
            add.innerHTML += " - " + select1[options[options.length - 1] - 1].text + " - ";
            document.getElementById("array").setAttribute('value', options);
        }
    }
    console.log(options)

}

function addcitar() {
    let select1 = document.querySelector("#selectcitar");
    let select = document.getElementById("selectcitar").value;
    // let option = select1.optionsc[select1.selectedIndex].value;
    let add = document.getElementById("addcitar")

    if (optionsc.indexOf(select) !== -1) {
        alert("Pessoa já inserida");
        return;
    } else {

        optionsc.push(select);
        console.log(select1[0].text)
        add.innerHTML += " - " + [select1[select1.selectedIndex].text] + " - ";
        document.getElementById("arraycita").setAttribute('value', optionsc);
    }
}

function addcitar1(num) {
    let select = document.getElementById("selectcitar" + num).value
    let select1 = document.querySelector("#selectcitar" + num)
    // let mais = document.querySelectorAll("#mais")[num];
    let add = document.getElementById("addcitarc" + num);
    let b = document.querySelectorAll("#arraycita1").length;
    let c = document.querySelectorAll("#arraycita1");
    let option = select1.options[select1.selectedIndex].value;

    // let guardarc


    console.log(guardarc)
    console.log(select1.name)

    // console.log(option)
    // console.log(select)

    if (guardarc !== select1.name) {
        let add2 = document.getElementById("addcitarc" + select1.name);
        add2.innerHTML = "";
        optionsc1 = []
    }

    guardarc = select1.name;

    if (optionsc1.indexOf(select) !== -1) {
        alert("Assunto já inserido");
        return;
    } else {

        // console.log(add)
        optionsc1.push(select);
        // console.log(optionsc1)
        for (i = 0; i < b; i++) {
            c[i].setAttribute('value', optionsc1)
            // console.log(c[i])
        }

        // console.log(optionsc1[0])
        add.innerHTML += " - " + [select1[select1.selectedIndex].text] + " - ";
    }
    // select1.options[select1.selectedIndex].text
}



function tiracitar(that) {
    let select1 = document.querySelector("#selectcitar")
    let select = document.getElementById("selectcitar").value
    let add = document.getElementById("addcitar")

    add.innerHTML = "";
    optionsc = []
    document.getElementById("arraycita").setAttribute('value', optionsc);

};

function tiracitar1(that) {
    let c = document.querySelectorAll("#arraycita1");
    let b = document.querySelectorAll("#arraycita1").length;

    let select1 = document.querySelector("#selectcitar" + that)
    let select = document.getElementById("selectcitar" + that).value
    let add = document.getElementById("addcitarc" + that)

    add.innerHTML = "";
    optionsc1 = []
    for (i = 0; i < b; i++) {
        c[i].setAttribute('value', optionsc1)
    }
    // document.querySelectorAll("arraycita1").setAttribute('value', optionsc1 );

};



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
    document.getElementById("array").setAttribute('value', options);

};