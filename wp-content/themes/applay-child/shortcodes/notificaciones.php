<?php
	global $wpdb;
	global $user;
	$notificaciones = $wpdb->get_results("select * from wp_notificaciones where id_destinatario = {$user->ID}");
?>
<div class="iparke">
	<h1>
		Notificaciones
	</h1>
	<?php if(!empty($notificaciones)): ?>
		<?php foreach($notificaciones as $p): ?>
			<div class="parqueadero">
				<b class="titulo"><?=$p->titulo?></b>
				<?php if(!in_array($p->tipo,["solicitud","solicitud_aprobada"])): ?>
				<div class="buttons">
					<a href="#" class="delete" data-id='<?=$p->id?>'><i class="fa fa-trash"></i></a>
				</div>
				<?php endif; ?>
				<p><?=$p->mensaje?></p>
				<?php if($p->tipo=="solicitud"): ?>
					<div class="actions">
						<button class="btn-warning rechazar" data-id_notificacion="<?=$p->id?>" data-json='<?=$p->datos?>'>Rechazar</button>
						<button class="btn-success aceptar"  data-id_notificacion="<?=$p->id?>" data-json='<?=$p->datos?>'>Aceptar</button>
					</div>
				<?php elseif($p->tipo=="solicitud_aprobada"): ?>
					<div class="actions">
						<button class="btn-warning declinar" data-id_notificacion="<?=$p->id?>" data-json='<?=$p->datos?>'>Declinar</button>
						<button class="btn-success pagar"  data-id_notificacion="<?=$p->id?>" data-json='<?=$p->datos?>'>Pagar</button>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<h3>No tiene notificaciones</h3>
	<?php endif;?>
</div>

<div class="overlay">
	<div class="info">
		<h3 class="nombre_parqueadero">NOMBRE PARQUEADERO</h3>
		<p class="datos_pago">Cargando datos de pago...</p>
		
		
		<p>Monto a pagar: $ <b class="monto"></b> </p>
		
		<b>Ingrese aquí toda la información de su pago:</b>
		<textarea rows="6" style="width:100%;" class="pago_cliente"></textarea>
	</div>
	<div class="actions">
		<button class="btn-warning close2">Cancelar</button>
		<button class="btn-success guardar">Guardar</button>
	</div>
</div>

<style>
p.datos_pago {
        background: #ddd;
    color: black;
    padding: 5px;
    border-radius: 3px;
    height: 150px;
    white-space: pre;
    
    overflow: auto;
}
	.whatsapp span{
	color: white;
    font-weight: bold;
    font-size: 17px;
    vertical-align: middle;
}
.whatsapp img{
	height:25px !important;
}
.whatsapp{
	border-radius:5px;
	text-align:center;
	    margin: 10px 0;
    white-space: nowrap;
    background: #1bd741;
    padding:0 10px;
	display:inline-block;
}
.overlay .actions button{
		width:45%;
	}
	.overlay .actions{
		position: absolute;
		bottom: 10px;
		width: 100%;
		display: flex;
		justify-content: space-between;
	}
	.overlay .horas {
		margin-bottom:20px;
		display:flex;
		justify-content:space-between;
		align-items:center;
	}
	.overlay .horas input{
		width:30%;
		height:30px;
		border:solid 1px gray;
	}
	.overlay .info, .overlay .actions , .overlay .horas {
		padding:0 10px;
	}
	.overlay .image{
		display:none;
		height:150px;
		background-image:url(https://www.ledgerinsights.com/wp-content/uploads/2020/05/parking-lot-cars.jpg);
		background-position:center center;
		background-size:cover;
	}
	.overlay.active{
		display:block;
	}
	.overlay{
		position: absolute;
		display:none;
		top: 0;
		left: 25px;
		background: white;
		width: calc(100% - 50px);
		height: 470px;
		z-index: 8;
		border-radius: 5px;
		box-shadow: 3px 3px 11px -3px rgb(0 0 0 / 50%);
	}
	.parqueadero .actions button{
		width:45%;
	}
	.parqueadero .actions{
		margin-top:10px;
		display: flex;
		justify-content: space-between;
	}
	.parqueadero b.titulo{
		    font-size: 18px;
    display: block;
    padding-right: 35px;
    margin-bottom: 10px;
	}
	.parqueadero .buttons a.edit{
		background:#46a5e5;
	}
	.parqueadero .buttons a.delete{
		background:#d02d2d;
		
	}
	.parqueadero .buttons a{
		display: inline-block;
    padding: 3px 7px;
    color: white;
    margin-left: 5px;
	border-radius:3px;
	}
	.parqueadero .buttons{
		position:absolute;
		top:7px;
		right:9px;
	}		
	.parqueadero{		
		    position: relative;
    background: white;
    padding: 13px;
    border-radius: 3px;
    margin-top: 15px;
	}
	.publicar{
		
    font-size: 18px;
    background: #4eda4e;
    color: white;
    padding: 3px 5px;
    line-height: 9px;
    border-radius: 3px;
    float: right;

	}
</style>
<script>
	jQuery(function($){
		$(".parqueadero .declinar").on("click",function(){			
			if(confirm("¿Desea eliminar la solicitud de parqueadero?")){
				var btn = $(this);
				btn.html("Espere...");
				btn.removeClass("declinar");
				var id_notificacion = $(this).data("id_notificacion");
				var json = $(this).data("json");
				$.post(
					'/wp-admin/admin-ajax.php?action=custom_ajax&caction=declinar_solicitud',
					{"id_notificacion":id_notificacion,'id_solicitud':json.id},
					function(r){
						alert(r.message);
						if(r.success)
							window.location.reload();			
					},
					"json"
				)
			}
		})
		$(".parqueadero .delete").on("click",function(){			
			if(confirm("¿Desea eliminar esta notificación?")){
				var id = $(this).data("id");
				$.post(
					'/wp-admin/admin-ajax.php?action=custom_ajax&caction=delete_notificacion',
					{"id":id},
					function(r){
						alert(r.message);
						if(r.success)
							window.location.reload();			
					},
					"json"
				)
			}
		})
		$(".parqueadero .rechazar").on("click",function(){			
			if(confirm("Está a punto de eliminar ésta solicitud.\n¿Desea Continuar?")){
				var btn = $(this);
				btn.html("Espere...");
				btn.removeClass("rechazar");
				var json = $(this).data("json");
				var id_notificacion = $(this).data("id_notificacion");
				$.post(
					'/wp-admin/admin-ajax.php?action=custom_ajax&caction=procesar_solicitud&procesar=0',
					{"id":json.id_solicitud,"id_notificacion":id_notificacion},
					function(r){
						alert(r.message);
						if(r.success)
							window.location.reload();			
					},
					"json"
				)
			}
		})
		$(".parqueadero .aceptar").on("click",function(){			
			if(confirm("Al aceptar esta solicitud, se le enviará al usuario una notificación para que realice el pago correspondiente.\n¿Desea Continuar?")){
				var btn = $(this);
				btn.html("Espere...");
				btn.removeClass("aceptar");
				var json = $(this).data("json");
				var id_notificacion = $(this).data("id_notificacion");
				$.post(
					'/wp-admin/admin-ajax.php?action=custom_ajax&caction=procesar_solicitud&procesar=1',
					{"id":json.id_solicitud,"id_notificacion":id_notificacion},
					function(r){
						alert(r.message);
						if(r.success)
							window.location.reload();			
					},
					"json"
				)
			}
		})
		$(".parqueadero .pagar").on("click",function(){			
			$(".overlay").show();
			var json = $(this).data("json")
			var id_notificacion = $(this).data("id_notificacion")
			$(".overlay .monto").html(json.monto)
			$(".overlay .guardar").data("json",json)
			$(".overlay .guardar").data("id_notificacion",id_notificacion)
			$(".datos_pago").html("Cargando datos de pago...")
			$(".pago_cliente").val("")
			$.post(
				'/wp-admin/admin-ajax.php?action=custom_ajax&caction=get_datos_pago',
				{'id_solicitud':json.id},
				function(r){
					$(".datos_pago").html(r.data)
				},
				"json"
			)
		})
		
		$(".overlay .close2").on("click",function(){
			$(".overlay").hide();
		})
		$(".overlay .guardar").on("click",function(){
			if(confirm("Está a punto de registrar el pago por el parqueadero.\¿Desea continuar?")){
				var json = $(this).data("json")
				var id_notificacion = $(this).data("id_notificacion")
				data = {
					'id_notificacion':id_notificacion,
					'id_solicitud':json.id,
					'datos_pago':$(".pago_cliente").val()
				};
				$.post('/wp-admin/admin-ajax.php?action=custom_ajax&caction=pagar_solicitud',
					data,
					function(r){
						alert(r.message);
						window.location.reload()
					},"json")
			}
		})
		
	})
</script>

