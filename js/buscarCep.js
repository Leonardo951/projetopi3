function getEndereco() {
    // Se o campo CEP não estiver vazio
    if($.trim($("#cep").val()) != ""){

        $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(),
            function(){
                //Se o resultado for igual a 1
                if(  resultadoCEP["resultado"] ){

                    $("#logradouro").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                    // $("#logradouro").val(unescape(resultadoCEP["logradouro"]));
                    $("#bairro").val(unescape(resultadoCEP["bairro"]));
                    $("#cidade").val(unescape(resultadoCEP["cidade"]));
                    $("#estado").val(unescape(resultadoCEP["uf"]));

                }else{
                    alert("CEP inválido!");
                    return false;
                }
            });
    }
    else{
        alert('Antes, preencha o campo CEP!')
    }

}
