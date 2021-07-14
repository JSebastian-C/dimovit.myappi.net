<?php
	global $wpdb;
	global $user;
	
	if(isset($_GET['id']))
		$parqueadero = $wpdb->get_row("select * from wp_parqueaderos where id = {$_GET['id']} and user_id = {$user->ID}");
	
	if(!empty($parqueadero) && json_decode($parqueadero->caracteristicas) != null){
		$caracteristicas_usuario = json_decode($parqueadero->caracteristicas);
	}else{
		$caracteristicas_usuario = [];
	}
	$titulo = isset($_GET['id']) ? 'Modificar Parquedero' : 'Publicar Parquedero';
	$caracteristicas = [ "Con techo","Campo abierto","Encerrado","En Sótano","Vigilancia privada","Valet parking"];


?>
<div class="iparke">
	<h1><?=$titulo?></h1>
	<form id="form_register">
		<h3>1. Seleccione la ubicación en el mapa</h3>
		<div id="map"></div>
		<h3>2. Datos del Parquedero</h3>
		<label> Nombre del Parquedero </label>
		<input type="hidden" name="id" value="<?=@$parqueadero->id?>">
		<input type="text" name="nombre_parqueadero" value="<?=@$parqueadero->nombre_parqueadero?>" required>
		<label> Dirección </label>
		<input type="text" name="direccion" value="<?=@$parqueadero->direccion?>" required>
		<label> Descripción </label>
		<input type="text" name="mensaje" value="<?=@$parqueadero->mensaje?>" required>
		<label> Latitud </label>
		<input type="text" name="latitud" value="<?=@$parqueadero->latitud?>" required readonly>
		<label> Longitud </label>
		<input type="text" name="longitud" value="<?=@$parqueadero->longitud?>" required readonly>
		<br>
		<h3>3. Detalles del Parquedero</h3>
		<label> Metros Cuadados </label>
		<input type="number" name="metros_cuadrados" value="<?=@$parqueadero->metros_cuadrados?>" required>
		<label> Cupos Disponibles</label>
		<input type="number" name="numero_cupos" value="<?=@$parqueadero->numero_cupos?>" required>
		<label> Precio por hora</label>
		<input type="number" name="precio_hora" value="<?=@$parqueadero->precio_hora?>" required>
		<br>
		<h3>4. Características</h3>
		<?php foreach($caracteristicas as $c):?>
			<label class="check"> 
				<input type="checkbox" name="caracteristicas[]" <?= in_array($c,$caracteristicas_usuario) != false ? "checked" : "" ?> value="<?=$c?>"> <?=$c?>
			</label>
		<?php endforeach;?>
		
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
    //map.js

    //Set up some of our variables.
    var map; //Will contain map object.
    var marker = false; ////Has the user plotted their location marker? 

    //Function called to initialize / create the map.
    //This is called when the page has loaded.
    function initMap() {

        //The center location of our map.
        var centerOfMap = new google.maps.LatLng(3.420556, -76.522224);

        //Map options.
        var options = {
            center: centerOfMap, //Set center.
            zoom: 12, //The zoom value.
            streetViewControl: false,
            styles: [
                {
                    "featureType": "poi",
                    "stylers": [
                        { "visibility": "off" }
                    ]
                }
            ],
            mapTypeControl: false
        }

        //Create the map object.
        map = new google.maps.Map(document.getElementById('map'), options);
        
		<?php if(!empty($parqueadero)):?>
			marker = new google.maps.Marker({
				position: { lat: parseFloat(<?=$parqueadero->latitud?>), lng: parseFloat(<?=$parqueadero->longitud?>) },
				icon: "<?=home_url()?>/wp-content/uploads/2019/05/ipark-gmap-mark.png",
				map: map,
				draggable: true //make it draggable
			});
			map.setCenter({ lat: parseFloat(<?=$parqueadero->latitud?>), lng: parseFloat(<?=$parqueadero->longitud?>) });
		<?php endif;?>


        //Listen for any clicks on the map.
        google.maps.event.addListener(map, 'click', function (event) {
            //Get the location that the user clicked.
            var clickedLocation = event.latLng;
            //If the marker hasn't been added.
            if (marker === false) {
                //Create the marker.
                marker = new google.maps.Marker({
                    position: clickedLocation,
                    icon: "<?=home_url()?>/wp-content/uploads/2019/05/ipark-gmap-mark.png",
                    map: map,
                    draggable: true //make it draggable
                });
                //Listen for drag events!
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    markerLocation();
                });
            } else {
                //Marker has already been added, so just change its location.
                marker.setPosition(clickedLocation);
            }
            //Get the marker's location.
            markerLocation();
        });
    }

    //This function will get the marker's current location and then add the lat/long
    //values to our textfields so that we can save the location.
    function markerLocation() {
        //Get location.
        var currentLocation = marker.getPosition();
        //Add lat and lng values to a field that we can save.
        document.querySelector('input[name=latitud]').value = currentLocation.lat(); //latitude
        document.querySelector('input[name=longitud]').value = currentLocation.lng(); //longitude
    }
</script>

<script>
	jQuery(function($){
		$('form').on('submit',function(e){
			var btn = $(".form_buttons button")
			btn.prop("disabled",true);
			btn.html("Guardando...");
			e.preventDefault()
			var data = $(this).serialize();
			$.post('/wp-admin/admin-ajax.php?action=custom_ajax&caction=save_user_parking',
					data,
					function(r){
						alert(r.message);
						if(r.success)
							window.location.href = "/my_parking_lots"
					},"json")
			return false;
		});
	})
</script>

