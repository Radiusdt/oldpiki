$(document).on('click', '#status-change', function (event) {
    $('#change-status-modal').modal('show');
});
$('#change-status-modal').on('show.bs.modal', function(e) {
    $(this).removeClass('fade');
});
$('.multiple-input').on('afterAddRow', function(e, row, currentIndex) {
    row.find('input#todo-new-1-todo-item-name').focus();
});
$('.todo-name').on('input', function(e) {
    let itemId = $(this).data('id');
    let itemName = $(this).text();
    let helpBlock = $(this).parent().find('.help-block');
    if(itemName.length === 0) {
        helpBlock.text('Name cannot be empty');
    } else if(itemName.length > 255) {
        helpBlock.text('Name is too long');
    } else {
        if(helpBlock.text().length > 0) {helpBlock.text('');}
        $.ajax({
            url: "/structure/todo/rename",
            type: "POST",
            data: {id: itemId, name: itemName},
            error: function(e) {
                console.error(e.responseText)
            }
        });
    }
});
$('.todo-check').on('change', function(e) {
    let itemId = $(this).data('id');
    let isChecked = + $(this).is(':checked');
    let _this = $(this);
    $.ajax({
        url: "/structure/todo/check",
        type: "POST",
        data: {id: itemId, isChecked: isChecked},
        error: function(e) {
            console.error(e.responseText)
        },
        success: function(res) {
            if(isChecked) {
                _this.closest('.form-line').addClass('text-muted').addClass('text-struck');
            } else {
                _this.closest('.form-line').removeClass('text-muted').removeClass('text-struck');
            }
        }
    });
});
var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};
$('.sortable-table tbody').sortable({helper: fixHelper, handle: '.handle'});
$('.sortable-table tbody').on( "sortdeactivate", function( event, ui ) {
    let priority = invertIndex($(document).find('tbody.ui-sortable tr').index(ui.item));
    let itemId = ui.item.find('.delete-button').data('id');
    let appId = ui.item.find('.delete-button').data('app-id');
    $.ajax({
        url: "/structure/todo/resort",
        type: "POST",
        data: {id: itemId, appId: appId, priority: priority},
        error: function(e) {
            console.error(e.responseText)
        }
    });
} );
function invertIndex(index) {
    let total = $(document).find('tbody.ui-sortable tr').children().length;
    return total - index - 1;
}
$('.delete-button').on('click', function(e) {
    let text = 'Are you sure that you want to delete this item?';
    if(confirm(text) === true) {
        let itemId = $(this).data('id');
        let appId = $(this).data('app-id');
        $.ajax({
            url: "/structure/todo/delete",
            type: "POST",
            data: {id: itemId, appId: appId},
            error: function(e) {
                console.error(e.responseText)
            }
        });
    }
});