function tipoPessoaJur() {
    document.getElementById("fisica").style.display = "none";
    document.getElementById("juridica").style.display = "block";
    $('#show-pf').removeClass().addClass('btn btn-default');
    $('#show-pj').removeClass().addClass('btn btn-default active');
}

function tipoPessoaFis() {
    document.getElementById("fisica").style.display = "block";
    document.getElementById("juridica").style.display = "none";
    $('#show-pj').removeClass().addClass('btn btn-default');
    $('#show-pf').removeClass().addClass('btn btn-default active');
}