function buscaProd() {
    let prod = $("#busca_prod").val();
    document.getElementById("alert").style.display = "none";
    $.ajax({
        url: "../functions/buscaProdutos.php",
        method: "GET",
        dataType: "json",
        data: {prod: prod}
    }).done(function(data){
        if (data.result){
            // renomeia os campos da div conforme o resultado do php
            let pformat = parseFloat(data.preco);
            $('#nome').text(data.nome);
            $('#nome').append('<small class="media-heading"> ['+data.cod+']</small>');
            $('#preco').text(numberToReal(pformat));
            $('#total').text(numberToReal(pformat));
            $('#categoria').text(data.categ);
            //limpar o campo de pesquisa
            $("#busca_prod").val("");
            // define o id da linha criada como a hora atual
            let id = new Date().getTime();
            // muda o id dos campos que serão usado para a soma
            $('#qntd').attr('id', 'qd'+id);
            $('#preco').attr('id', 'preco'+id);
            $('#total').attr('id', 'total'+id);
            $('#remove').attr('id', 're'+id);
            // insere uma tr com o id criado onde será colado os dados
            $( "<tr id='linha"+id+"'></tr>" ).insertBefore( "#inner" );
            let variable = '#linha' + id;
            // defini as variavéis com os clones de todos os tds modificados
            let p1 = $('#primeira').clone().removeAttr('id');
            let p2 = $('#segunda').clone().removeAttr('id');
            let p3 = $('#terceira').clone().removeAttr('id');
            let p4 = $('#quarta').clone().removeAttr('id');
            let p5 = $('#quinta').clone().removeAttr('id');
            // volta os campos da linha exemplo para vazios e modifica o id novamente
            let pre = "#preco"+id;
            let tot = "#total"+id;
            let rem = "#re"+id;
            let qnt = "#qd"+id;
            $(qnt).attr('id', 'qntd');
            $(pre).attr('id', 'preco');
            $(tot).attr('id', 'total');
            $(rem).attr('id', 'remove');
            $('#preco').text('R$ 0');
            $('#total').text('R$ 0');
            // cola os campos criados na li ha criada
            $(variable).append( p1 ).append( p2 ).append( p3 ).append( p4 ).append( p5 );
            somaTudo();
        }else{
            $('#text').text(data.message);
            document.getElementById("alert").style.display = "block";
            $("#busca_prod").val("");
        }
    })
}

function mudaTotal(item) {
    let id = $(item).attr("id").split('d')[1];
    let id_preco = '#preco'+id;
    let id_total = '#total'+id;
    let qtd = $(item).val();
    let preco = moedaParaNumero($(id_preco).text());
    let total = preco*qtd;
    $(id_total).text(numberToReal(total));
}

function somaTudo() {
    let total = 0;
    $(".soma").each(function(){
        let val = moedaParaNumero($(this).text());
        total += val;
    });
    $("#subtotal").text(numberToReal(total));
    $("#tot-geral").text(numberToReal(total));
}

function removeLinha(item) {
    let id = $(item).attr("id").split('e')[1];
    let id_linha = '#linha'+id;
    $(id_linha).remove();
}

function numberToReal(numer) {
    let numero = numer.toFixed(2).split('.');
    numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
}

function moedaParaNumero(valor) {
    return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
}


$("#avista").mask('000.000.000,00', {reverse: true});

function simbolDinh(item){
    if($('#avista').val().length < 3) {
        $(item).val( $(item).val() + ',00' );
    }
    if($(item).val().length > 0) {
        $(item).val( 'R$' + $(item).val() );
    }
}
$('#avista').val( 'R$' + $('#avista').val() );

function dinhFoco(item) {
    $(item).val( $(item).val().split('$')[1]);
}

$('#percentual').mask('Z#9V##', {
    translation: {
        'Z': {
            pattern: /[\-\+]/,
            optional: true
        },
        'V': {
            pattern: /[\,]/
        },
        '#': {
            pattern: /[0-9]/,
            optional: true
        }
    }
});

$('#percentual').val( $('#percentual').val() + '%' );

function simbolPorc(){
        $('#percentual').val( $('#percentual').val() + '%' );
}

function simbolFoco(item) {
    $(item).val( $(item).val().split('%')[0]);
}

function checaPorcent() {
    let p = document.getElementById("descporc").checked;
    if (p) {
        document.getElementById("percentual").style.display = "block";
        document.getElementById("avista").style.display = "none";
        $('#avista').val("R$");
    }
}

function checaDinheiro() {
    let d = document.getElementById("descdin").checked;
    if (d) {
        document.getElementById("percentual").style.display = "none";
        document.getElementById("avista").style.display = "block";
        $('#percentual').val("%");
    }
}