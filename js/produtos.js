$.ajax({
    url: "../produtos/buscaDados.php",
    method: "GET",
    dataType: "json",
    data: {
        tipo: 'forn'
    },
}).done(function(data){
    $("#forn").autocomplete({
        source: data
    });
});

$.ajax({
    url: "../produtos/buscaDados.php",
    method: "GET",
    dataType: "json",
    data: {
        tipo: 'prod'
    },
}).done(function(data){
    $("#prod").autocomplete({
        source: data
    });
});

function buscaDados() {
    $.ajax({
        url: "../produtos/buscaDados.php",
        method: "GET",
        dataType: "json",
        data: {
            tipo: 'dados',
            nome: $('#prod').val()
        }
    }).done(function(data){
        if(data.result){
            $('#marca').val(data.marca);
            $('#categoria').val(data.categoria);
            $('#pk').val(data.prod);
            $('#fk-cat').val(data.cat);
        }else{
            $('#prod').val('');
        }
    });
}

function habilitaSave() {
    $('.save').prop('disabled', false);
}

$('.editar').on('hide.bs.modal', function () {
    $('.save').prop('disabled', true);
});
