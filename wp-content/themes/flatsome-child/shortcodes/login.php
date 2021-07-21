<div class="ext"></div>
<div>
	<img class="img_logo" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/Dimovit logo.png' ?>">

	<h5 class="bienvenido">¡Bienvenido/a!</h5>

	<form class="form_register">
		<input class="i_correo" placeholder="Correo electrónico" type="email" name="email" value="" required><br>
		<input class="i_contra" placeholder="Contraseña" type="password" name="password" required><br>

		<button type="submit">Iniciar sesión</button>
	</form>

	<div class="footer">
		<!-- <a href="/recover_pass" class="olvidar_contra">¿Olvidaste tu contraseña?</a>
		<div class="divider"></div> -->
		<a class="registro" href="/registro"><button>Registrate</button></a>
	</div>
</div>

<style>
	#main {
		background: linear-gradient(#FFF, #FFF, #ffe5d4);
		text-align: center;
		height: 100vh;
		width: 100%;
	}

	.ext {
		height: 15vh;
	}

	.img_logo {
		width: 28%;
		height: 28%;
	}

	.bienvenido {
		color: #53658d;
		font-weight: bolder;
		font-size: 23px;
		margin-top: 13%;
	}

	.form_register {
		margin-top: 5%;
		padding-left: 13%;
		padding-right: 13%;
	}

	.form_register>button {
		background: linear-gradient(to right, #f07647, #f29351);
		text-transform: uppercase;
		width: 100%;
		color: #FFF;
		margin-top: 15%;
		border-radius: 30px;
	}

	.form_register>button:hover {
		border-color: #FFF;
	}

	.form_register>input {
		border: none;
		border-bottom: 1px solid #a8a6a7;
		width: 100%;
		background-color: transparent;
		box-shadow: none;
		-webkit-box-shadow: none;
	}

	/* Centra el texto del placeholder */
	.form_register>input::placeholder {
		text-align: center;
	}

	.i_contra {
		margin-top: 5%;
	}

	.footer {
		padding-top: 1%;
		margin-top: 10%;
	}

	.olvidar_contra {
		color: #53658d;
		text-decoration: none;
	}

	.olvidar_contra:hover {
		color: #53658d;
	}

	.registro>button {
		border: none;
		color: #53638e;
		text-transform: uppercase;
		text-align: center;
		padding-left: 4.5vh;
	}

	.footer>button:active {
		background-color: #FFF;
		border-radius: 30px;
	}

	.divider {
		height: 1px;
		background-color: #ccbeb4;
		margin-left: 28%;
		margin-right: 28%;
		margin-top: 3%;
		margin-bottom: 1%;
	}
</style>

<script>
	jQuery(function($) {
		$('form').on('submit', function(e) {
			var btn = $(".form_buttons button")
			btn.prop("disabled", true);
			btn.html("Espere");
			e.preventDefault()
			var data = $(this).serialize();
			$.post('/wp-admin/admin-ajax.php?action=custom_ajax&caction=clogin',
				data,
				function(r) {
					if (r.success)
						window.location.href = '/start';
					else {
						alert(r.message);
						btn.prop("disabled", false);
						btn.html("Acceder");

					}


				}, "json")
			return false;
		});
	})
</script>