<div class="slider_mo">
	<div class="slides">
		<div class="screen1">
			<img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-1.png' ?>">
			<div class="text">Mudanza rápida y al alcance de todos</div>
		</div>
		<div class="screen2">
			<img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-2.png' ?>">
			<div class="text">Mudanza rápida y al alcance de todos</div>
		</div>
		<div class="screen3">
			<img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-3.png' ?>">
			<div class="text">Mudanza rápida y al alcance de todos</div>
		</div>
	</div>
	<!-- 	<div class="logo_container">
		<img src="/wp-content/app/logo-iparke.png">
	</div> -->

	<div id="tabs">
		<div id="tab_1"></div>
		<div id="tab_2"></div>
		<div id="tab_3"></div>
	</div>

	<button id="next">Continuar</button>
</div>
<style>
	#main {
		background: linear-gradient(#FFF, #FFF, #ffe5d4);
		text-align: center;
		height: 100vh;
	}

	.text {
		font-size: 23px;
		color: #a8abaa;
		padding-left: 40px;
		padding-right: 40px;
	}

	.screen1 {
		margin-bottom: 150px;
	}

	.screen1 img {
		height: 200px;
		width: 115px;
		margin-top: 180px;
	}

	.screen1 .text {
		margin-top: 50px;
	}

	.screen2 {
		margin-bottom: 180px;
	}

	.screen2 img {
		height: 150px;
		width: 150px;
		margin-top: 200px;
	}

	.screen2 .text {
		margin-top: 50px;
	}

	.screen3 {
		margin-bottom: 130px;
	}

	.screen3 img {
		height: 200px;
		width: 180px;
		margin-top: 200px;
	}

	.screen3 .text {
		margin-top: 50px;
	}

	#tabs {
		display: flex;
		width: 100%;
		align-items: center;
		justify-content: center;
	}

	#tabs div {
		height: 10px;
		width: 10px;
		margin: 10px;
		border-radius: 15px;
	}

	@keyframes tabs {
		from {
			background-color: #54648f;
		}

		to {
			background-color: #ff8b00;
		}
	}

	#next {
		background: linear-gradient(to right, #f07647, #f29351);
		color: #FFF;
		border-radius: 30px;
		width: 90%;
		margin-left: 15px;
		margin-top: 50px;
	}

	/* .slide .text {
		position: absolute;
		bottom: 30vh;
		padding: 0 10vw;
		text-align: center;
		color: #a7a8aa;
		font-size: 1.2rem;
	}

	.button_mo button {
		margin: 0;
		color: #FFF;
		border-radius: 30px;
		width: 87%;
		font-size: 1.5rem;
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

	.logo_container img {
		width: 50%;
		max-width: 250px;
		display: none;
	}

	.logo_container {
		position: absolute;
		top: 10vh;
		width: 100%;
		text-align: center;
	}

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
		height: 30%;
		width: 50%;
		margin-top: 50%;
	}

	.slide:nth-child(3) img {
		height: 30%;
		width: 50%;
		margin-top: 50%;
	}

	.slide:nth-child(1) {
		background-image: url(<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-1.png' ?>);
		left: 0;
	}

	.slide:nth-child(2) {
		background-image: url(<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-2.png' ?>);
		left: 100%;
	}

	.slide:nth-child(3) {
		background-image: url(<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-3.png' ?>);
		left: 200%;
	} */
</style>
<?php add_action('wp_footer', function () { ?>
	<script>
		var cnt = 1;

		jQuery(function($) {
			window.onload = () => {
				current_page();
			}

			function setCookie(cname, cvalue, exdays) {
				var d = new Date();
				d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
				var expires = "expires=" + d.toUTCString();
				document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
			}

			//Acción que se realiza al presionar el botón con el identificador "#next"
			$("#next").click(() => {
				console.log(cnt);
				if (cnt > 3) {
					setCookie('first_time', 1, 3650);
					window.location.href = "/clogin";
				} else {
					current_page();
				}
			});

			//Esta función oculta las páginas que no figura con el valor de la variable "c", y la página que si lo haga se muestra y lo mismo con el indicador
			function current_page() {
				$(".slides>div").hide();
				$("#tabs div").css({
					"background-color": "#54648f",
				});

				$(".screen" + cnt).fadeIn();
				$("#tab_" + cnt).css({
					"background-color": "#ff8b00",
					"animation-name": "tabs",
					"animation-duration": "0.5s"
				});

				cnt++;
			}

			/* $('#next').on("click", function() {
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
			}) */
		})
	</script>
<?php }); ?>