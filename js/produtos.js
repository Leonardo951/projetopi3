$.ajax({
    url: "../produtos/buscaForns.php",
    method: "GET",
    dataType: "json"
}).done(function(data){
    $("#forn").autocomplete({
        source: data
    });
});

function habilitaSave() {
    $('.save').prop('disabled', false);
}

$('.editar').on('hide.bs.modal', function () {
    $('.save').prop('disabled', true);
});
