<div id="fake_header_main">
	<div id="fake_header">
		<a href="#" id="chevron_left"><i class="fa fa-chevron-left"></i></a>
		<span id="title">Perfil</span>
	</div>
	<div id="ext_fake_header">
		<img id="img_profile" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-includes/images/smilies/rolleyes.png' ?>">
		<img id="QR_code" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/flatsome-child/images/view/Dimovit.png' ?>">
	</div>
</div>

<div id="fake_body">
	<div id="history_content">
		<span id="subtitle">Historial</span>
		<select name="rutas_realizadas" id="complete_routes">
			<option value="">Rutas realizadas</option>
			<option value="">Ruta 1</option>
			<option value="">Ruta 2</option>
		</select>
	</div>

	<div id="personal_content">
		<span id="subtitle">Personal</span>
		<div>
			<i class="fa fa-user"></i>
			<input type="text" value="Andrés Sanchez" readonly>
		</div>
		<div>
			<i class="fa fa-envelope"></i>
			<input type="text" value="andresanchez@gmail.com" readonly>
		</div>
		<div>
			<i class="fa fa-phone"></i>
			<input type="text" value="+57 300 223 2222" readonly>
		</div>
	</div>

	<div id="preferences_content">
		<span id="subtitle">Preferencias</span>
		<div>
			<input type="text" value="Recibir notificaciones" readonly>
			<div id="toggle_group">
				<div id="toggle"></div>
			</div>
		</div>
	</div>

	<a href="/wp-login.php?action=logout"><button id="close_session">Cerrar sesión</button></a>
</div>

<style>
	#main {
		background-color: #FFF;
		height: 100vh;
		width: 100%;
	}

	#fake_header_main {
		background-color: #f07647;
	}

	#fake_header {
		color: #FFF;
		height: 7.5vh;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	#ext_fake_header {
		height: 7vh;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	#img_profile,
	#QR_code {
		background-color: #FFF;
		padding: 0.5vh;
		margin-top: 7.5vh;
		height: 15vh;
		width: 15vh;
	}

	#img_profile {
		border-radius: 200px;
	}

	#QR_code {
		margin-left: 10%;
	}

	#title {
		text-transform: capitalize;
		font-size: 20px;
		font-weight: lighter;
	}

	#chevron_left {
		margin-left: 2vh;
		position: absolute;
		left: 5px;
		color: #FFF;
	}

	#fake_body {
		margin-top: 10vh;
		margin-left: 6vh;
		margin-right: 6vh;
	}

	#personal_content,
	#preferences_content {
		margin-top: 5vh;
	}

	#main input,
	#main select {
		border: none;
		border-bottom: 0.5px solid #a7a7a7;
		width: 100%;
		background-color: transparent;
		box-shadow: none;
		-webkit-box-shadow: none;
	}

	#subtitle {
		color: #b0b0b0;
		margin-left: 1.5vh;
		font-size: 15px;
	}

	#personal_content div i {
		color: #000;
		position: fixed;
		margin-top: 1.5vh;
		margin-left: 1.5vh;
	}

	#personal_content div input {
		padding-left: 5vh;
	}

	#preferences_content div {
		display: flex;
	}

	/* TOGGLEBUTTON ---*/
	#toggle_group {
		/* background-color: #53658d; */
		/* background-color: grey; */
		width: 3.5vh;
		padding: 0.3vh;
		padding-right: 0px;
		position: fixed;
		right: 6vh;
		margin-top: 11px;
	}

	#toggle_group,
	#toggle {
		border-radius: 10px;
	}

	/* --- */

	#close_session {
		color: #53658d;
		border-color: #53658d;
		border-width: 1px;
		border-radius: 30px;
		margin-top: 10vh;
		width: 100%;
	}
</style>

<script>
	jQuery(function($) {
		let valor = "on";

		$(document).ready(() => {
			switch_toggle();
		});

		//Al dar click en la etiqueta <a> se devuelve a la página/pantalla anterior
		$("#chevron_left").click(() => {
			$("#chevron_left").attr("href", history.go(-1));
		});

		//Acciones del TOGGLEBUTTON
		$("#toggle_group").click(() => {
			if (valor == "on") {
				valor = "off"
			} else {
				valor = "on"
			}

			switch_toggle();
		});


		function switch_toggle() {
			if (valor == "on") {
				$("#toggle").css({
					"background-color": "#FFF",
					"height": "1.3vh",
					"width": "1.3vh",
					"margin-left": "1.6vh"
				})

				$("#toggle_group").css("background-color", "#53658d");

			} else {
				$("#toggle").css({
					"background-color": "#FFF",
					"height": "1.3vh",
					"width": "1.3vh",
					"margin-left": "0vh"
				});

				$("#toggle_group").css("background-color", "grey");
			}
		}
	});
</script>