<img class="img" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/Dimovit logo.png' ?>">

<style>
	#main {
		background: linear-gradient(#FFF, #FFF, #ffe5d4);
		text-align: center;
		line-height: 100vh;
	}

	.img {
		height: 40%;
		width: 40%;
		vertical-align: middle;
	}
</style>

<script>
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

	jQuery(function($) {
		if (window.location.pathname == '/') {
			setTimeout(function() {
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
</script>