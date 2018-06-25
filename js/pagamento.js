$.ajax({
    url: "../vendas/buscaClientes.php",
    method: "GET",
    data: {tipo: 'fisica'},
    dataType: "json",
}).done(function(data){
    $("#buscaCliente" ).autocomplete({
        source: data
    });
});

$.ajax({
    url: "../vendas/buscaClientes.php",
    method: "GET",
    data: {tipo: 'resp'},
    dataType: "json",
}).done(function(data){
    $("#buscaPj" ).autocomplete({
        source: data
    });
});

$.ajax({
    url: "../vendas/buscaClientes.php",
    method: "GET",
    data: {tipo: 'juridico'},
    dataType: "json",
}).done(function(data){
    $("#buscaResp" ).autocomplete({
        source: data
    });
});

function numberToReal(numer) {
    let numero = numer.toFixed(2).split('.');
    numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
}

function moedaParaNumero(valor) {
    return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
}

function formaPag() {
    $('#avista').addClass('active');
    $('#pagar').val($('#total').val());
    $('.payments').css( { marginLeft : "200px"} );
    $('.lateral').css( { display : "block"} );
    $('#register').prop('disabled', false);

}

function desabilitaPag() {
    $('#avista').removeClass('active');
    $('#pagar').val('');
    $('.lateral').css( { display : "none"} );
    $('.payments').css( { marginLeft : "300px"} );
    $('#register').prop('disabled', true);
}

function trocoDinn() {
    let tot = moedaParaNumero($('#pagar').val());
    let entregue = moedaParaNumero($('#pago').val());
    let troco = entregue - tot;
    let res = numberToReal(troco);
    if(troco > 0){
        $('#troco').val(res);
    }else{
        $('#troco').val('');
    }
}

function PesJur() {
    $('#pesFis').css({display: 'none'});
    $('#pesJur').css({display: 'block'});
    $('#buscaPj').focus();
}

function PesFis() {
    $('#pesFis').css({display: 'block'});
    $('#pesJur').css({display: 'none'});
    $('#buscaCliente').focus();
}

function cancelaVenda() {
    $.ajax({
        url: "../vendas/cancelaVenda.php",
        method: "GET",
        dataType: "json"
    }).done(function(data){
        if(data.result){
            window.location.replace('../vendas/venda.php');
        }
    })
}

function registraCliente() {
    if($('#alert').css('display') == 'none' && $('#alertPJ').css('display') == 'none') {
        $.ajax({
            url: "../vendas/registra.php",
            method: "GET",
            dataType: "json",
            data: {
                resp: $('#buscaResp').val(),
                cpf: $('#buscaCliente').val(),
                cnpj: $('#buscaPj').val()
            }
        }).done(function(data){
            if(data.result){
                window.location.replace('../vendas/confirmado.php');
            }
        })
    }else{
        if($('#alert').css('display') == 'block'){
            $('#buscaCliente').focus();
        }else{
            $('#buscaPj').focus();
        }
    }
}

function erroCliente() {
    if($('#buscaCliente').val() != ''){
        $.ajax({
            url: "../vendas/confirmaCliente.php",
            method: "GET",
            dataType: "json",
            data: {
                campo: $('#buscaCliente').val(),
                tipo: 'PF'
            }
        }).done(function(data){
            if(data.result){
                document.getElementById('alert').style.display='block';
                document.getElementById('buscaCliente').style.borderColor='#D01D33';
            }else{
                document.getElementById('alert').style.display='none';
                document.getElementById('buscaCliente').style.borderColor='#0c6121';
            }
        })
    }else{
        document.getElementById('alert').style.display='none';
        document.getElementById('buscaCliente').style.borderColor='#9d9d9d';
    }
}

function erroCliPJ() {
    if($('#buscaPj').val() != '' && $('#buscaResp').val() != ''){
        $.ajax({
            url: "../vendas/confirmaCliente.php",
            method: "GET",
            dataType: "json",
            data: {
                campo: $('#buscaPj').val(),
                resp: $('#buscaResp').val(),
                tipo: 'PJ'
            }
        }).done(function(data){
            if(data.result){
                // Verificar em qual campo esta o erro
                if(data.onde == 'buscaPJ'){
                    document.getElementById('alertPJ').style.display='block';
                    document.getElementById('buscaPj').style.borderColor='#D01D33';
                    document.getElementById('buscaResp').style.borderColor='#D01D33';
                }else{
                    // neste caso o erro é somente no responsável que não é igual ao informado no campo buscaPJ
                    document.getElementById('alertPJ').style.display='block';
                    document.getElementById('buscaResp').style.borderColor='#D01D33';
                    document.getElementById('buscaPj').style.borderColor='#0c6121';
                }
            }else{
                document.getElementById('alertPJ').style.display='none';
                document.getElementById('buscaResp').style.borderColor='#0c6121';
                document.getElementById('buscaPj').style.borderColor='#0c6121';
            }
        })
    }else{
        document.getElementById('alertPJ').style.display='none';
        document.getElementById('buscaResp').style.borderColor='#9d9d9d';
        document.getElementById('buscaPj').style.borderColor='#9d9d9d';
    }
}