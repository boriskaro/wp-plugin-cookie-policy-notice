function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + encodeURIComponent(value || "") + expires + "; path=/";
}

function getCookie(name) {
  var nameEQ = encodeURIComponent(name) + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
  }
  return null;
}

function eraseCookie(name) {
  document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}

function cookieConsent() {
  if (!getCookie("allowCookies")) {
    jQuery(".toast").toast("show");
  }
}

jQuery(document).ready(function () {
  // prevent toast from hiding
  jQuery(".toast").toast({
    autohide: false,
    close: false,
  });

  jQuery("#btnDeny").click(function () {
    eraseCookie("allowCookies");
    jQuery(".toast").toast("hide");
  });

  jQuery("#btnAccept").click(function () {
    setCookie("allowCookies", "1", 7);
    jQuery(".toast").toast("hide");
  });

  // load
  cookieConsent();

  // for demo / testing only
  jQuery("#btnReset").click(function () {
    // clear cookie to show toast after acceptance
    eraseCookie("allowCookies");
    jQuery(".toast").toast("show");
  });
});