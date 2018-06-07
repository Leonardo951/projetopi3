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
            $('#nome').text(data.nome);
            $('#nome').append('<small class="media-heading"> ['+data.cod+']</small>');
            $('#preco').text('R$ '+ data.preco);
            $('#total').text('R$ '+ data.preco);
            $('#categoria').text(data.categ);
            //limpar o campo de pesquisa
            $("#busca_prod").val("");
            // define o id da linha criada como a hora atual
            let id = new Date().getTime();
            // muda o id dos campos que serão usado para a soma
            $('#qntd').attr('id', id);
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
            $('[name="qntd"]').attr('id', 'qntd');
            let pre = "#preco"+id;
            let tot = "#total"+id;
            let rem = "#re"+id;
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
    let id = $(item).attr("id");
    let id_preco = '#preco'+id;
    let id_total = '#total'+id;
    let qtd = $(item).val();
    let preco = $(id_preco).text().split('$')[1];
    let total = 'R$ '+ (preco*qtd);
    $(id_total).text(total);
}

function somaTudo() {
    let total = 0;
    $(".soma").each(function(){
        let val = parseInt($(this).text().split('$')[1]);
        total += val;
    });
    $("#subtotal").text("R$ " + total);
    $("#tot-geral").text("R$ " + total);
}

function removeLinha(item) {
    let id = $(item).attr("id").split('e')[1];
    let id_linha = '#linha'+id;
    $(id_linha).remove();
}