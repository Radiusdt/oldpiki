$(function(){
    $('.copy').each(function(){
        $(this).html('<i class="fa fa-copy"></i> ' + $(this).html());
    });

    const copyToClipboard = str => {
        const el = document.createElement('textarea');
        el.value = str;
        el.setAttribute('readonly', '');
        el.style.position = 'absolute';
        el.style.left = '-9999px';
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
    };

    $(document).on('click', '.copy', function(){
        copyToClipboard($(this).text().trim());
        Swal.fire({
            title: "Clipboard copy",
            text: "Successed",
            timer: 1500,
            showConfirmButton: false,
            icon: 'success'
        });
    });
});