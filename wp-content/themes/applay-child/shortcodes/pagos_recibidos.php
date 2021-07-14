<?php
	global $wpdb;
	global $user;
	$parqueadero = $wpdb->get_row("select * from wp_parqueaderos where user_id = {$user->ID}");
	if(!empty($parqueadero) && json_decode($parqueadero->caracteristicas) != null){
		$caracteristicas_usuario = json_decode($parqueadero->caracteristicas);
	}else{
		$caracteristicas_usuario = [];
	}
	
	$caracteristicas = [ "Con techo","Campo abierto","Encerrado","En Sótano","Vigilancia privada","Valet parking"];

?>
<div class="iparke">
	<h1>Pagos Recibidos</h1>
	<form id="form_register">
		<label> Nombre Completo</label>
		<input type="text" name="nombre_completo" value="<?=@$user->display_name?>" required>
		<input type="hidden" name="user_id" value="<?=@$user->ID?>" required>
		<label> Cédula</label>
		<input type="text" name="cedula" value="<?=@$parqueadero->cedula?>" required>
		<label> WhatsApp</label>
		<input type="number" maxlength='10' name="telefono" value="<?=@$parqueadero->telefono?>" required>
		
		<div class="form_buttons">
			<button type="submit">Guardar Datos</button>
		</div>
	</form>
</div>
<style>
	label.check{
		display:inline-block;
		width:47%;
		margin-bottom:10px;
	}
	.form_buttons{
		margin-top:20px;display:flex;		
		justify-content:space-between;
	}
	.form_buttons > *{
		width:49% !important;
		font-size:18px;
		padding:6px;
		border-radius:5px;
		color:white;
		text-align:center;
		margin:0 !important;
	}
	.form_buttons > button{
		background:#00b6c4;
	}
	.form_buttons > a{
		background:#a7a7a7;
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
	jQuery(function($){
		$('form').on('submit',function(e){
			e.preventDefault()
			var data = $(this).serialize();
			$.post('/wp-admin/admin-ajax.php?action=custom_ajax&caction=save_user_parking',
					data,
					function(r){
						alert(r.message);
					},"json")
			return false;
		});
	})
</script>

