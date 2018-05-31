//Colocando as mascaras
$(document).ready(function () {
    $("#cpf").mask('000.000.000-00', {reverse: true});
    $("#tel").mask('0000-0000', {reverse: true});
    $("#dtnasc").mask('00/00/0000', {reverse: true});
    $("#cep").mask('00.000-000', {reverse: true});
    $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
});

// Troca de campos caso seja PJ
function tipoPessoaJur() {
    let pj = document.getElementById("pj").checked;
    if (pj) {
        document.getElementById("fisica").style.display = "none";
        document.getElementById("juridica").style.display = "block";

        $('#nome').prop('required', false);
        $('#cpf').prop('required', false);
        $('#tel').prop('required', false);
        $('#ddd').prop('required', false);
        $('#email').prop('required', false);
        $('[name="sexo"]').prop('required', false);
        $('#dtnasc').prop('required', false);

        $('#empresa').prop('required', true);
        $('#resp').prop('required', true);
        $('#mail').prop('required', true);
        $('#tel_pj').prop('required', true);
        $('#ddd_pj').prop('required', true);
        $('#razao_soc').prop('required', true);
        $('#cnpj').prop('required', true);
    }
}
function tipoPessoaFis() {
    let pf = document.getElementById("pf").checked;
    if(pf){
        document.getElementById("fisica").style.display = "block";
        document.getElementById("juridica").style.display = "none";

        $('#empresa').prop('required', false);
        $('#resp').prop('required', false);
        $('#mail').prop('required', false);
        $('#tel_pj').prop('required', false);
        $('#ddd_pj').prop('required', false);
        $('#razao_soc').prop('required', false);
        $('#cnpj').prop('required', false);

        $('#nome').prop('required', true);
        $('#cpf').prop('required', true);
        $('#tel').prop('required', true);
        $('#ddd').prop('required', true);
        $('#email').prop('required', true);
        $('[name="sexo"]').prop('required', true);
        $('#dtnasc').prop('required', true);
    }
}

// Correção de bug no botão de limpar
function limparPJ() {
    document.getElementById("fisica").style.display = "block";
    document.getElementById("juridica").style.display = "none";
}
