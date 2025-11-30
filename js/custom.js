$(function () {
    //glueCopy('.copy');
    //glueInputCopy('.copy-input');
});

function glueCopy(selector) {
    if ($(selector).length) {

        var clipboard = new ClipboardJS(selector);

        $('.copy').attr('data-toggle', 'tooltip').attr('title', 'Copy to clipboard');

        $('[data-toggle="tooltip"]').tooltip();

        clipboard.on('success', function (e) {
            originalClass = e.trigger.classList.value;
            e.trigger.classList.value += ' btn-current';
            $('.btn-current').tooltip('hide');
            e.trigger.dataset.originalTitle = 'Copied';
            $('.btn-current').tooltip('show');
            setTimeout(function () {
                $('.btn-current').tooltip('hide');
                e.trigger.dataset.originalTitle = 'Copy to clipboard';
                e.trigger.classList.value = originalClass;
            }, 1000);
            e.clearSelection();
        });
    }
}

function glueInputCopy(selector) {
    $(document).on('click', selector, function(e) {
        this.select();
        document.execCommand("copy");
        $(this).addClass('border-success').addClass('bg-success');
        clearSelection();
    });
}
function clearSelection() {
    if (window.getSelection) {window.getSelection().removeAllRanges();}
    else if (document.selection) {document.selection.empty();}
}
