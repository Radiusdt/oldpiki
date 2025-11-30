$('.appsflyer_transfer_button').on('click', function (event) {
    let appId = $(this).data('app-id');
    $('#transfer-modal').modal('show').find('.modal-body').load('/structure/market/appsflyer-transfer?id=' + appId);
    return false;
});
$('#transfer-modal').on('show.bs.modal', function(e) {
    $(this).removeClass('fade');//само не убирается почему-то
});