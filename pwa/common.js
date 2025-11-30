$(document).on("click", '#expand-button2', function () {
    if ($(this).hasClass('coll')) {
        $(this).removeClass('coll');
        $(this).text('Все отзывы');
        $('.hidden_comment').hide();
    } else {
        $(this).addClass('coll');
        $(this).text('Скрыть отзывы');
        $('.hidden_comment').show();
    }
});

$(document).on('click', '.comment-screenshots .screenshot .preview', function(){
    $('.comment-screenshots .screenshot .preview').hide();
});
$(document).on('click', '.comment-screenshots .screenshot img', function(){
    $(this).parent().find('.preview').show();
});


function eraseCookie(name, domain) {
    createCookie(name, "", -1, domain);
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function createCookie(name, value, days, domain) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name + "=" + value + expires + "; domain=" + domain + "; path=/";
}

eraseCookie("googtrans", "");

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    var items = location.search.substr(1).split("&");
    for (var index = 0; index < items.length; index++) {
        tmp = items[index].split("=");
        if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
    }
    return result;
}

function getProgress(e, n) {
    const i = [];
    let s = 0;
    for (var o = e / n / 3; n > s;) {
        s++;
        let t = s * (e / n);
        t += .5 < Math.random() ? o : -1 * o, i.push(t.toFixed(2))
    }
    return i.splice(i.length - 1, 1, e), i
}