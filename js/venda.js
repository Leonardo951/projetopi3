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
            $('#nome').text(data.nome);
            // $('#nome> small').text('[' + data.cod + ']');
            $('#preco').text('R$ '+ data.preco);
            $('#total').text('R$ '+ data.preco);
            $('#categoria').text(data.categ);
            $("#busca_prod").val("");
            let id = new Date().getTime();
            $('#qntd').attr('id', id);
            $('#preco').attr('id', 'preco'+id);
            $('#total').attr('id', 'total'+id);
            $( "<tr id='"+id+"'></tr>" ).insertBefore( "#inner" );
            let variable = '#' + id;
            let p1 = $('#primeira').clone().removeAttr('id');
            let p2 = $('#segunda').clone().removeAttr('id');
            let p3 = $('#terceira').clone().removeAttr('id');
            let p4 = $('#quarta').clone().removeAttr('id');
            let p5 = $('#quinta').clone().removeAttr('id');

            $('[name="qntd"]').attr('id', 'qntd');
            let pre = "#preco"+id;
            let tot = "#total"+id;
            $(pre).attr('id', 'preco');
            $(tot).attr('id', 'total');

            $(variable).append( p1 ).append( p2 ).append( p3 ).append( p4 ).append( p5 );
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
    let val = 0;
    $.each( $( ".soma" ), function() {
        alert(soma.text());
        // val = val + this.text().split('$')[1];
    });
    $('#tot-geral').text('R$ '+val);
}
