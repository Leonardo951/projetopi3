$(document).ready(function () {
    $("#cpf").mask('000.000.000-00', {reverse: true});
    $("#tel").mask('0000-0000', {reverse: true});
    $("#cep").mask('00.000-000', {reverse: true});
    $("#cnpj").mask('00.000.000/0000-00', {reverse: true});
});

function editarCampos() {
    if($('#editar').text() == 'Editar campos') {
        $('#nome').prop('disabled', false);
        $('#cpf').prop('disabled', false);
        $('#empresa').prop('disabled', false);
        $('#cnpj').prop('disabled', false);
        $('#resp').prop('disabled', false);
        $('#razao_soc').prop('disabled', false);
        $('#email').prop('disabled', false);
        $('#tel').prop('disabled', false);
        $('#ddd').prop('disabled', false);
        $('#sexoF').prop('disabled', false);
        $('#sexoI').prop('disabled', false);
        $('#sexoM').prop('disabled', false);
        $('#dtnasc').prop('disabled', false);
        $('#cep').prop('disabled', false);
        $('#compl').prop('disabled', false);
        $('#numero').prop('disabled', false);
        $('#pesquisar').prop('disabled', false);
        $('#editar').text("Desabilitar campos");
        document.getElementById("pesquisar").style.display = "block";
    }else {
        $('#nome').prop('disabled', true);
        $('#cpf').prop('disabled', true);
        $('#email').prop('disabled', true);
        $('#tel').prop('disabled', true);
        $('#ddd').prop('disabled', true);
        $('#empresa').prop('disabled', true);
        $('#cnpj').prop('disabled', true);
        $('#resp').prop('disabled', true);
        $('#razao_soc').prop('disabled', true);
        $('#sexoF').prop('disabled', true);
        $('#sexoI').prop('disabled', true);
        $('#sexoM').prop('disabled', true);
        $('#dtnasc').prop('disabled', true);
        $('#cep').prop('disabled', true);
        $('#compl').prop('disabled', true);
        $('#numero').prop('disabled', true);
        document.getElementById("pesquisar").style.display = "none";
        $('#editar').text("Editar campos");
    }
}

function desabilitaEdit() {
    $('#atualizar').prop('disabled', false);
    $('#editar').text("Editar campos");
    $('#editar').hide();
    // $('#editar').prop('disabled', true);
}

