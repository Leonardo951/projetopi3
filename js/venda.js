// funçaõ executada quando fazemos a pesquisa por um produto
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

// função executada quando mudamos a quantidade
function mudaTotal(item) {
    let id = $(item).attr("id").split('d')[1];
    let id_preco = '#preco'+id;
    let id_total = '#total'+id;
    let qtd = $(item).val();
    let preco = moedaParaNumero($(id_preco).text());
    let total = preco*qtd;
    $(id_total).text(numberToReal(total));
    somaTudo();
}

// Função que soma todos os valores dos produtos e coloca em subtotal
function somaTudo() {
    let total = 0;
    $(".soma").each(function(){
        let val = moedaParaNumero($(this).text());
        total += val;
    });
    $("#subtotal").text(numberToReal(total));
    somaGeral();
}

// Verifica se tem algum desconto e aplica ao valor total da venda
function somaGeral() {
    let total = moedaParaNumero($('#subtotal').text());
    if(total == 0) {
        $("#tot-geral").text($('#subtotal').text());
    }else{
        if($('#percentual').val().length > 1 || $('#avista').val().length > 2) {
            if($('#avista').val() == 'R$'){
                // se verdadeiro significa que temos uma porcentagem, se não teremos um valor em dinheiro
                let valor = moedaParaNumero($('#percentual').val().split('%')[0]);
                let res = (moedaParaNumero(total)/100)*valor;
                let resultado = moedaParaNumero(total)-res;
                if(resultado <= 0) {
                    alert('Desconto inválido!');
                    $("#percentual").val('');
                    $("#tot-geral").text($('#subtotal').text());
                }else{
                    $("#tot-geral").text(numberToReal(resultado));
                }
            }else {
                let valor = moedaParaNumero($('#avista').val().split('$')[1]);
                let resul = (total-valor);
                $("#tot-geral").text(numberToReal(resul));
                if(resul <= 0) {
                    alert('Desconto inválido!');
                    $("#avista").val('');
                    $("#tot-geral").text($('#subtotal').text());
                }else{
                    $("#tot-geral").text(numberToReal(resul));
                }
            }
        }else {
            $("#tot-geral").text(numberToReal(total));
        }
    }
}

//Função do botão de remover
function removeLinha(item) {
    let id = $(item).attr("id").split('e')[1];
    let id_linha = '#linha'+id;
    $(id_linha).remove();
    somaGeral();
}

//Transforma numero inteiro na formatação de moeda
function numberToReal(numer) {
    let numero = numer.toFixed(2).split('.');
    numero[0] = "R$ " + numero[0].split(/(?=(?:...)*$)/).join('.');
    return numero.join(',');
}

// Formatação de moeda para numero inteiro
function moedaParaNumero(valor) {
    return isNaN(valor) == false ? parseFloat(valor) :   parseFloat(valor.replace("R$","").replace(".","").replace(",","."));
}

// Define a mascara de moeda para o campo de desconto, assim que a pagina é carregada
$("#avista").mask('000.000.000,00', {reverse: true});

// Executada quando o usuário sai do foco do campo de desconto em dinheiro
function simbolDinh(item){
    if($('#avista').val().length > 0 && $('#avista').val().length < 3) {
        $(item).val( $(item).val() + ',00' );
    }
    $(item).val( 'R$' + $(item).val() );
    somaGeral();
}

// define um valor pre estabelecido para o campo de desconto em dinheiro assim que a pagina é carregada
$('#avista').val( 'R$' + $('#avista').val() );

// tira o R$ do deconto em dinheiro quando ele fica em foco
function dinhFoco(item) {
    $(item).val( $(item).val().split('$')[1]);
}

//Formatação do campo de desconto em %
$('#percentual').mask('Z#9V#', {
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

// Define o valor % para o campo de percentual de desconto quando a pagina é carregada
$('#percentual').val( $('#percentual').val() + '%' );

// Define o simbolo de % no do campo de desconto %
function simbolPorc(){
        $('#percentual').val( $('#percentual').val() + '%' );
        somaGeral();
}

// Tira o simbolo % quando o campo fica em foco
function simbolFoco(item) {
    $(item).val( $(item).val().split('%')[0]);
}

//Função executada quando clica no radio de difinir que o escoto será dado como porcentagem
function checaPorcent() {
    let p = document.getElementById("descporc").checked;
    if (p) {
        document.getElementById("percentual").style.display = "block";
        document.getElementById("avista").style.display = "none";
        $('#avista').val("R$");
        somaGeral();
    }
}

// //Função executada quando clica no radio de difinir que o escoto será dado em dinheiro
function checaDinheiro() {
    let d = document.getElementById("descdin").checked;
    if (d) {
        document.getElementById("percentual").style.display = "none";
        document.getElementById("avista").style.display = "block";
        $('#percentual').val("%");
        somaGeral();
    }
}