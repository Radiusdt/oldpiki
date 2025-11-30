function browserCheck() {
    const ua = new UAParser;
    if (ua.getBrowser().name !== "Chrome" && ua.getBrowser().name !== "Yandex") {
        var lnk = document.getElementById("r");
        lnk.setAttribute("href", `intent://${window.location.hostname}/?no_cloak=1#Intent;scheme=https;package=com.android.chrome;end;`);
        lnk.click();
    }
}

function attachInstallEvent() {
    if (Cookies.get('is_installed') === '1' && false) {
        installButton.innerHTML = "Открыть";
        installButton.hidden = false;
        installButton.addEventListener("click", goRedirect);
    } else {
        setTimeout(function () {
            if (IS_FAST_INSTALL) {
                installButton.innerHTML = INSTALL_BUTTON_TEXT;
                installButton.hidden = false;
                installButton.addEventListener("click", fastInstallApp);
            } else {
                installButton.innerHTML = "Скачать";
                installButton.hidden = false;
                installButton.addEventListener("click", longInstallApp);
            }
        }, 3000);
    }
}

function createOneSignal(isWithPush = false) {
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
            appId: ONESIGNAL_APP_ID,
            welcomeNotification: {disable: true},
            persistNotification: true,
            serviceWorkerParam: { scope: "/" },
            serviceWorkerPath: "OneSignalSDK.sw.js",
        });
        OneSignal.Notifications.setDefaultUrl(ONESIGNAL_DEFAULT_URL);
        OneSignal.Notifications.setDefaultTitle(ONESIGNAL_DEFAULT_TITLE);
        await OneSignal.login(TRACK_ID);

        OneSignal.User.PushSubscription.addEventListener("change", function (event) {
            if (event.current.token) {
                fetch(POSTBACK_PUSH_SUB.replace('TOKEN', event.current.token));
            }
        });

        if (isWithPush) {
            if (OneSignal.Notifications !== undefined && !OneSignal.Notifications.permission) {
                OneSignal.Notifications.requestPermission();
            }
        }
    });
}