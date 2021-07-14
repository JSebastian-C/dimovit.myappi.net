<img class="img" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/Dimovit logo.png' ?>">

<style>
	body {
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