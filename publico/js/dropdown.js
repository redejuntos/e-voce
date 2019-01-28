
function obtemUltimaPosicao() {
    return obtemFormulario().ordenacao.options.length - 1;
}

var NADA_SELECIONADO = 0;
var JA_PRIMEIRA = 1;
var JA_ULTIMA = 2;

var mensagens = new Array();
mensagens[NADA_SELECIONADO] = "Você precisa selecionar algum texto.";
mensagens[JA_PRIMEIRA] = "O(s) texto(s) selecionado(s) já está(ão) na primeira posição da lista.";
mensagens[JA_ULTIMA] = "O(s) texto(s) selecionado(s) já é(são) o(s) último(s) na lista.";

function avisa(indiceDaMensagem) {
    alert(mensagens[indiceDaMensagem]);
}

function obtemFormulario() {
    return document.textOrdenationForm;
}

function cima() {
    var indiceMenor;
    var indiceMaior;

    indiceMenor = obtemPrimeiroIndiceSelecionado();
    if (indiceMenor != -1) {
        indiceMaior = obtemUltimoIndiceSelecionado();
        if (indiceMenor == 0) {
            avisa(JA_PRIMEIRA);
        } else {
            trocaSubindo(indiceMenor, indiceMaior);
        }
    } else {
        avisa(NADA_SELECIONADO);
    }
}

function baixo() {
    var indiceMaior;
    var indiceMenor;

    indiceMenor = obtemPrimeiroIndiceSelecionado();
    if (indiceMenor != -1) {
        indiceMaior = obtemUltimoIndiceSelecionado();
        if (indiceMaior == obtemUltimaPosicao()) {
            avisa(JA_ULTIMA);
        } else {
            trocaDescendo(indiceMenor, indiceMaior);
        }
    } else {
        avisa(NADA_SELECIONADO);
    }
}

function obtemUltimoIndiceSelecionado() {
    var formulario;
    var i;
    var retorno;

    formulario = obtemFormulario();
    retorno = formulario.ordenacao.options.selectedIndex;

    for (i = retorno; i < formulario.ordenacao.length; i++) {
        if (formulario.ordenacao[i].selected == true) {
            retorno = i;
        }
    }
    return retorno;
}

function obtemPrimeiroIndiceSelecionado() {
    return obtemFormulario().ordenacao.options.selectedIndex;
}

function trocaSubindo(indiceMenor, indiceMaior) {
    var formulario = obtemFormulario();
    var i;

    var valorMenor;
    var textoMenor;

    valorMenor = formulario.ordenacao.options[indiceMenor - 1].value;
    textoMenor = formulario.ordenacao.options[indiceMenor - 1].text;

    for (i = indiceMenor; i <= indiceMaior; i++) {
        if (formulario.ordenacao.options[i].selected == true) {
            formulario.ordenacao.options[i - 1].value = formulario.ordenacao.options[i].value;
            formulario.ordenacao.options[i - 1].text = formulario.ordenacao.options[i].text;
            formulario.ordenacao.options[i - 1].selected = true;
            formulario.ordenacao.options[i].value = valorMenor;
            formulario.ordenacao.options[i].text = textoMenor;
            formulario.ordenacao.options[i].selected = false;
        } else {
            valorMenor = formulario.ordenacao.options[i].value;
            textoMenor = formulario.ordenacao.options[i].text;
        }
    }

}

function trocaDescendo(indiceMenor, indiceMaior) {
    var formulario = obtemFormulario();
    var i;

    var valorMaior;
    var textoMaior;

    valorMaior = formulario.ordenacao.options[indiceMaior + 1].value;
    textoMaior = formulario.ordenacao.options[indiceMaior + 1].text;

    for (i = indiceMaior; i >= indiceMenor; i--) {
        if (formulario.ordenacao.options[i].selected == true) {
            formulario.ordenacao.options[i + 1].value = formulario.ordenacao.options[i].value;
            formulario.ordenacao.options[i + 1].text = formulario.ordenacao.options[i].text;
            formulario.ordenacao.options[i + 1].selected = true;
            formulario.ordenacao.options[i].value = valorMaior;
            formulario.ordenacao.options[i].text = textoMaior;
            formulario.ordenacao.options[i].selected = false;
         } else {
            valorMaior = formulario.ordenacao.options[i].value;
            textoMaior = formulario.ordenacao.options[i].text;
         }
    }
}

function ordena() {
    defineOrdenacao();
    submeteOrdenacao();
}


function defineOrdenacao() {
    var formulario = obtemFormulario();
    for(var i = 0; i < formulario.ordenations.length; i++) {
        var MaisValor = document.createElement("OPTION");
        formulario.ordenations[i].value = formulario.ordenacao.options[i].value + "|" + (i + 1);
        MaisValor.value = formulario.ordenacao.options[i].value + "|" + (i + 1);
        formulario.Valor.value = formulario.Valor.value + "," + MaisValor.value;
//		alert(MaisValor.value);
    }
//    alert(formulario.Valor.value);
}

function submeteOrdenacao() {
    obtemFormulario().submit();
}