<?php
global $wpdb;
global $user;
global $meta;

?>
<div class="dimovit">
	<h1>Mis Datos</h1>
	<form id="form_register">
		<label> Nombre Completo</label>
		<input type="text" name="nombre_completo" value="<?= @$user->display_name ?>" required>
		<label> Cédula</label>
		<input type="text" name="cedula" value="<?= @$meta->cedula ?>" required>
		<label> WhatsApp</label>
		<input type="number" maxlength='10' name="telefono" value="<?= @$meta->telefono ?>" required>
		<label> Datos Bancarios</label>
		<textarea maxlength='1000' rows="6" name="datos_bancarios"><?= @$meta->datos_bancarios ?></textarea>
		<small>Esta información se le enviará a sus clientes para que le realicen el pago relacionado al uso de sus parqueaderos.</small><br>
		<small style="font-weight:bold;">COLOQUE TODA LA INFORMACIÓN NECESARIA PARA QUE LOS PAGOS SE REALICEN EXITOSAMENTE.</small>
		<div class="form_buttons">
			<button type="submit">Guardar Datos</button>
		</div>
	</form>
</div>
<style>
	#main {
		padding: 20px;
		height: 100vh;
	}

	label.check {
		display: inline-block;
		width: 47%;
		margin-bottom: 10px;
	}

	.form_buttons {
		margin-top: 20px;
		display: flex;
		justify-content: space-between;
	}

	/* .form_buttons>* {
		width: 49% !important;
		font-size: 18px;
		padding: 3px;
		border-radius: 5px;
		color: white;
		text-align: center;
		margin: 0 !important;
	} */

	.form_buttons>button {
		background: #f07647;
		color: #FFF;
		font-size: 16px;
		text-transform: capitalize;
		font-weight: lighter;
	}

	.form_buttons>a {
		background: #a7a7a7;
	}

	#map {
		height: 400px;
	}

	#floating-panel {
		position: absolute;
		top: 10px;
		left: 25%;
		z-index: 5;
		background-color: #fff;
		padding: 5px;
		border: 1px solid #999;
		text-align: center;
		font-family: "Roboto", "sans-serif";
		line-height: 30px;
		padding-left: 10px;
	}
</style>
<script>
	jQuery(function($) {
		window.onload = () => {
			/* Titulo del header */
			$("#logo>a").attr("href", "/start");
		}

		$('form').on('submit', function(e) {
			e.preventDefault()
			var btn = $(this).find('button[type=submit]');
			btn.html("Espere...");
			var data = $(this).serialize();
			$.post('/wp-admin/admin-ajax.php?action=custom_ajax&caction=update_userdata',
				data,
				function(r) {
					alert(r.message);
					btn.html("Guardar Datos");
				}, "json")
			return false;
		});
	})
</script>