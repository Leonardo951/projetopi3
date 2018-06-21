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
            // alert(ui.item.value);
            $('#codigo').text(ui.item);
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