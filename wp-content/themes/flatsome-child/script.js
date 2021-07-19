function getCookie(cname) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

jQuery(function ($) {
	jQuery(".logo").attr("href", '/start');

	//Anula la visualización del footer
	jQuery("#footer").remove();
	jQuery("#content p").remove();

	if (window.location.pathname == '/') {
		setTimeout(function () {
			if (getCookie('first_time') == 1) {
				if (jQuery('body').hasClass('logged-in')) {
					window.location.href = "/start";
				} else {
					window.location.href = "/clogin";
				}
			} else {
				window.location.href = "/splash";
			}
		}, 3000)
	}
})