<div class="slider_mo">
	<div class="slides">
		<div class="slide">
			<img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-1.png' ?>">
			<div class="text">Mudanza rápida y al alcance de todos</div>
		</div>
		<div class="slide">
			<img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-2.png' ?>">
			<div class="text">Mudanza rápida y al alcance de todos</div>
		</div>
		<div class="slide">
			<img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-3.png' ?>">
			<div class="text">Mudanza rápida y al alcance de todos</div>
		</div>
	</div>
	<!-- 	<div class="logo_container">
		<img src="/wp-content/app/logo-iparke.png">
	</div> -->

	<div class="dots">
		<i class="active"></i>
		<i></i>
		<i></i>
	</div>

	<div class="button_mo">
		<button class="next">Empezar</button>
	</div>
</div>
<style>
	body {
		background: linear-gradient(#FFF, #FFF, #ffe5d4);
		text-align: center;
	}

	.slide .text {
		position: absolute;
		bottom: 30vh;
		padding: 0 10vw;
		text-align: center;
		color: #a7a8aa;
		font-size: 2.2rem;
	}

	.button_mo button {
		margin: 0;
		color: #FFF;
		border-radius: 30px;
		width: 87%;
		font-size: 2rem;
		font-weight: bold;
		background: linear-gradient(to right, #f07647, #f29351);
		text-transform: uppercase;
	}

	.button_mo button:hover {
		border-width: 1px;
		border-color: #f29351;
	}

	.button_mo {
		position: absolute;
		bottom: 8vh;
		width: 100%;
		text-align: center;
	}

	.dots {
		position: absolute;
		bottom: 18vh;
		width: 100%;
		text-align: center;
		/* display: none; */
	}

	.dots i.active {
		background: #53658d;
	}

	.dots i {
		margin: 10px;
		height: 10px;
		width: 10px;
		background: #ff8b00;
		display: inline-block;
		border-radius: 10px;
	}

	.slider_mo {
		height: 100vh;
		width: 100vw;
		position: relative;
	}

	/* 	.logo_container img {
		width: 50%;
		max-width: 250px;
		display: none;
	}

	.logo_container {
		position: absolute;
		top: 10vh;
		width: 100%;
		text-align: center;
	} */

	.slide {
		position: absolute;
		top: 0;
		background-position: center center;
		background-size: cover;
		height: 100%;
		width: 100%;
	}

	.slide:nth-child(1) img {
		height: 45%;
		width: 45%;
		margin-top: 30%;
	}

	.slide:nth-child(2) img {
		height: 60%;
		width: 60%;
		margin-top: 50%;
	}

	.slide:nth-child(3) img {
		height: 50%;
		width: 50%;
		margin-top: 50%;
	}

	.slide:nth-child(1) {
		/* background-image: url(<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-1.png' ?>); */
		left: 0;
	}

	.slide:nth-child(2) {
		/* background-image: url(<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-2.png' ?>); */
		left: 100%;
	}

	.slide:nth-child(3) {
		/* background-image: url(<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-3.png' ?>); */
		left: 200%;
	}
</style>
<?php add_action('wp_footer', function () { ?>
	<script>
		var cnt = 0;

		jQuery(function($) {
			$('.next').on("click", function() {
				if (cnt < 2) {
					cnt++;
					$(".slide").animate({
						left: "-=100%"
					}, 500, 'linear');
					$(".dots i").removeClass("active");
					$(".dots i:nth-child(" + (cnt + 1) + ")").addClass("active");
					return;
				}

				setCookie('first_time', 1, 3650);
				window.location.href = "/clogin";
			})
		})
	</script>
<?php }); ?>