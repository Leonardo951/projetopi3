function habilitaSave() {
    $('.save').prop('disabled', false);
}

$('.editar').on('hide.bs.modal', function () {
    $('.save').prop('disabled', true);
});