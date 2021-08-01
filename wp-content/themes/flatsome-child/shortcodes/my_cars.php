<?php
global $wpdb;
global $user;
$parqueaderos = $wpdb->get_results("select * from wp_parqueaderos where user_id = {$user->ID} and eliminado = 0");
?>
<div class="dimovit">
	<h1>
		Mis vehículos
		<a href="#" class="publicar"><i class="fa fa-plus"></i></a>
	</h1>
	<?php if (!empty($parqueaderos)) : ?>
		<?php foreach ($parqueaderos as $p) : ?>
			<div class="parqueadero">
				<b><?= $p->nombre_parqueadero ?></b>
				<div class="buttons">
					<a href="/publicar-parqueadero?id=<?= $p->id ?>" class="edit"><i class="fa fa-edit"></i></a>
					<a href="#" class="delete" data-json='<?= json_encode($p) ?>'><i class="fa fa-trash"></i></a>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<h3>Aún no tiene vehiculos registrados.</h3>
	<?php endif; ?>
</div>
<style>
	#main {
		height: 100vh;
		padding: 20px;
	}

	.parqueadero b {
		font-size: 18px;
	}

	.parqueadero .buttons a.edit {
		background: #46a5e5;
	}

	.parqueadero .buttons a.delete {
		background: #d02d2d;

	}

	.parqueadero .buttons a {
		display: inline-block;
		padding: 8px 11px;
		color: white;
		margin-left: 5px;
		border-radius: 3px;
	}

	.parqueadero .buttons {
		position: absolute;
		top: 7px;
		right: 9px;
	}

	.parqueadero {
		position: relative;
		background: white;
		padding: 13px 100px 13px 10px;
		border-radius: 3px;
		margin-top: 15px;
	}

	.publicar {
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
	jQuery(function($) {
		window.onload = () => {
			/* Titulo del header */
			$("#logo>a").attr("href", "/start");
		}

		$('.delete').on('click', function(e) {
			e.preventDefault();
			var json = $(this).data("json");
			if (confirm("¿Desea eliminar el parqueadero " + json.nombre_parqueadero + "?")) {
				$.post('/wp-admin/admin-ajax.php?action=custom_ajax&caction=delete_user_parking', {
						id: json.id
					},
					function(r) {
						alert(r.message);
						if (r.success)
							window.location.reload();

					}, "json")
			}

		})
		
		$('form').on('submit', function(e) {
			e.preventDefault()
			var data = $(this).serialize();
			$.post('/wp-admin/admin-ajax.php?action=custom_ajax&caction=save_user_parking',
				data,
				function(r) {
					alert(r.message);
				}, "json")
			return false;
		});
	})
</script>