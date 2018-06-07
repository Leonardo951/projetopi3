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
            $('#preco').text(data.preco);
            $("#busca_prod").val("");
            // let tr = $('#exex').clone();
            // $('#aqui').append( tr );
        }else{
            $('#text').text(data.message);
            document.getElementById("alert").style.display = "block";
            $("#busca_prod").val("");
        }
    })
}