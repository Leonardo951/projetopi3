document.getElementById("prod").addEventListener("click", function(event){
    event.preventDefault()
});

$.ajax({
    url: "../fornecedores/buscaProd.php",
    method: "GET",
    dataType: "json",
    data: {
        tipo: 'prod'
    }
}).done(function(data){
    $("#prod").autocomplete({
        source: data,
        minLength: 2,
        select: function(event, ui) {
            let codigo = '';
            let codigos = [];
            let produto = '';
            let produtos = [];
            $(".cod").each(function(){
                codigo = $(this).text();
                codigos.push(codigo);
            });
            $(".produtos").each(function(){
                produto = $(this).text();
                produtos.push(produto);
            });
            for(let i=0; i < codigos.length; i++) {
                if(codigos[i] == ui.item.value) {
                    $('#prod').val('');
                    return;
                }
                if(produtos[i] == ui.item.value) {
                    $('#prod').val('');
                    return;
                }
            }
            $.ajax({
                url: "../fornecedores/buscaProd.php",
                method: "GET",
                dataType: "json",
                data: {
                    tipo: 'dados',
                    prod: ui.item.value
                }
            }).done(function(data){
                $('#prod').val('');
                $('#codigo').text(data.cod);
                $('#nome_prod').text(data.nome);
                let p1 = $('#codigo').clone().removeAttr('id');
                let p2 = $('#nome_prod').clone().removeAttr('id');
                let p3 = $('#exclui').clone().removeAttr('id');
                let date = new Date().getTime();
                p3.attr('id', date);
                $( "<tr id='linha"+date+"'></tr>" ).insertBefore( "#novalinha" );
                let variable = '#linha' + date;
                $(variable).append(p1).append(p2).append(p3);
                $('#codigo').text('');
            })
        }
    });
});

function habilitaSave() {
    $('.save').prop('disabled', false);
}

$('.editar').on('hide.bs.modal', function () {
    $('.save').prop('disabled', true);
});

function apagaLinha(item) {
    let id = '#linha' + $(item).attr('id');
    $(id).remove();
}

function registraProds() {
    document.getElementById("adicionar").addEventListener("click", function(event){
        event.preventDefault()
    });
    let codigo = '';
    let codigos = [];
    $(".cod").each(function(){
        codigo = $(this).text();
        codigos.push(codigo);
    });
    $('#codigos').val(JSON.stringify(codigos));
}