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
    $("#buscaCliente" ).autocomplete({
        source: data
    });
});

$.ajax({
    url: "../vendas/buscaClientes.php",
    method: "GET",
    data: {tipo: 'juridico'},
    dataType: "json",
}).done(function(data){
    $("#buscaCliente" ).autocomplete({
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
}

function PesFis() {
    $('#pesFis').css({display: 'block'});
    $('#pesJur').css({display: 'none'});
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
        }else{
            alert('erro');
            alert(data.erro);
        }
    })
}