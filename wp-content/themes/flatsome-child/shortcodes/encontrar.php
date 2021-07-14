<?php
	global $wpdb;
	global $user;
	$parqueaderos = $wpdb->get_results("select * from wp_parqueaderos where user_id <> {$user->ID}");
	foreach($parqueaderos as $k => $v){
		$contacto = $wpdb->get_var("select display_name from wp_users where ID = {$v->user_id}");
		$parqueaderos[$k]->telefono = get_user_meta($v->user_id,'telefono',true);
		$parqueaderos[$k]->contacto = $contacto;
	}
	
?>
<div class="ia_row">
    <div class="vc_row wpb_row vc_row-fluid">
        <div class="wpb_column vc_column_container vc_col-sm-12">
            <div class="vc_column-inner">
                <div class="wpb_wrapper">
                    <div class="ia-heading ia-heading-heading_879 heading-align-left " data-delay="0">
                        <h2>
                            Parqueaderos </h2>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 <form method="post">
            <input type="text" id="lat" readonly="yes" hidden>
            <input type="text" id="lng" readonly="yes" hidden>
            <input type="text" id="startLat" readonly="yes" hidden>
            <input type="text" id="startLng" readonly="yes" hidden>
        </form>
<div id="map"></div>

<div class="overlay">

	<div class="image">
	</div>
	<div class="info">
		<h3 class="nombre_parqueadero">NOMBRE PARQUEADERO</h3>
		<p>Direccion: <span class="direccion">Direccion</span></p>
		<div class="caracteristicas">
			<div></div>
		</div>
		<p>Contacto: <span class="contacto"></span></p>
		<p>
			<a target="blank" href="whatsapp://send?phone=573215793292" class="whatsapp">
			<img src="https://markoh.myappi.net/wp-content/uploads/2021/05/whatsapp_icon.png"><span class="telefono"></span> </a>
		</p>
		<p>Precio por hora: $ <b class="precio_hora">2000</b> </p>
		<p>Puestos disponibles: <span class="numero_cupos">5</span> </p>
	</div>
	<div class="horas">
		<label>¿Cuantas horas quiere solicitar?</label>
		<input type="number" class="horas_solicitadas">
	</div>
	<div class="horas">
		<label>Monto a Pagar</label>
		<input type="number" class="monto_pagar" readonly>
	</div>
	<div class="actions">
		<button class="btn-warning close2">Cancelar</button>
		<button class="btn-success aceptar">Solicitar</button>
	</div>
</div>
<input type="text" id="userEmail" value="mail@mail.com" hidden>
<style>
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
		left: 15px;
		background: white;
		width: calc(100% - 30px);
		height: 470px;
		z-index: 8;
		border-radius: 5px;
		box-shadow: 3px 3px 11px -3px rgb(0 0 0 / 50%);
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

    .custom-map-control-button {
        appearance: button;
        background-color: #fff;
        border: 0;
        border-radius: 2px;
        box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        margin: 10px;
        padding: 0 0.5em;
        height: 40px;
        font: 400 18px Roboto, Arial, sans-serif;
        overflow: hidden;
    }

    .custom-map-control-button:hover {
        background: #ebebeb;
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
.caracteristicas div{
	margin-bottom:10px;
}
.caracteristicas div span{
	background:gray;
	font-size:12px;
	color:white;
	display:inline-block;
	padding:3px;
	border-radius:3px 5px;
	margin:3px;
}
</style>

<script>
	jQuery(function($){
		$(".horas_solicitadas").on("keyup change blur",function(){
			var monto = $(this).val()
			if(monto!=''){
				pagar = parseFloat(monto) * parseFloat($(".precio_hora").text());
				$(".monto_pagar").val(pagar.toFixed(2));
			}
		});
		$(".overlay .aceptar").on("click",function(){
			var btn = $(this);
			btn.html("Espere...");
			btn.removeClass("aceptar");
			if($(".horas_solicitadas").val()=='' || parseInt($(".horas_solicitadas").val())==0){
				alert("Ingrese las horas a solicitar");
				return false;
			}
			var id = $(this).data('id');
			$(this).html("Espere...")
			$(this).prev().prop("disabled",true);
			
			$.post(
				'/wp-admin/admin-ajax.php?action=custom_ajax&caction=solicitar_parqueadero',
				{"id":id,"horas":$(".horas_solicitadas").val(),"monto":$(".monto_pagar").val()},
				function(r){
					alert(r.message);
					window.location.href = '/notificaciones';
				},"json"
			)
			
			
		});
		$("body").on("click",".pedir",function(){
			var json = $(this).data('json');
			console.log(json);
			$(".overlay .nombre_parqueadero").html(json.nombre_parqueadero);
			$(".overlay .direccion").html(json.direccion);
			$(".overlay .contacto").html(json.contacto);
			if(json.telefono!=''){
				$(".overlay .telefono").html(json.telefono);
				$(".overlay .whatsapp").attr('href','whatsapp://send?phone=57'+json.telefono);
				$(".overlay .whatsapp").show();
			}else{
				$(".overlay .whatsapp").hide();
			}
			var c = JSON.parse(json.caracteristicas);
			if(c.length){
				$(".caracteristicas").show();
				c.forEach(function(i){
					$(".caracteristicas div").append('<span>'+i+'</span>');
				})
			}else{
				$(".caracteristicas").hide();
			}
			$(".overlay .precio_hora").html(json.precio_hora);
			$(".overlay .numero_cupos").html(json.numero_cupos);
			$(".overlay .aceptar").data("id",json.id);
			$(".overlay").addClass("active");
		})
		$(".overlay .close2").on("click",function(){
			$(".overlay").removeClass("active");
		})
	})
    //map.js
    //Set up some of our variables.
    var map; //Will contain map object.
    var marker = false; ////Has the user plotted their location marker? 
    // locate you.
    let infoWindow;
    //Function called to initialize / create the map.
    //This is called when the page has loaded.
    var parqueaderos = <?=json_encode($parqueaderos)?>;
    function initMap() {
        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        //The center location of our map.
        var centerOfMap = new google.maps.LatLng(3.420556, -76.522224);

        //Map options.
        var options = {
            center: centerOfMap, //Set center.
            zoom: 12, //The zoom value.
            streetViewControl: false,
            styles: [{
                "featureType": "poi",
                "stylers": [{
                    "visibility": "off"
                }]
            }],
            mapTypeControl: false
        };

        //Create the map object.
        map = new google.maps.Map(document.getElementById('map'), options);
		
        var email = document.getElementById('userEmail').value;
        var parkingName, parkingAddress;
        var infowindow = new google.maps.InfoWindow;
        parqueaderos.forEach(function(p){
            
            parkingName = p.nombre_parqueadero;
            parkingAddress = p.direccion;
            			
			
			var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(p.latitud),
                    lng: parseFloat(p.longitud)
                },
                icon: "<?=home_url()?>/wp-content/uploads/2019/05/ipark-gmap-mark.png",
                map: map,
                draggable: false //make it draggable: true
            });
            let contentString =
                '<div id="content">' +
                '<div id="siteNotice">' +
                "</div>" +
                '<h3 id="firstHeading" class="firstHeading">' + parkingName + '</h3>' +
                '<p>' + parkingAddress + '</p>' +
                '<p style="display:none;">Contacto: '+ p.nombre_completo + '</p>' ;
            
			
                contentString  += "<div>" +
                '<button class="btn btn-primary" id="btn-ir">Ir</button> ' +
                '<button class="btn btn-success pedir" data-json=\''+ JSON.stringify(p) +'\'>Pedir</button> ' +
                "</div>";
            //Route
            directionsRenderer.setMap(map);
            const onChangeHandler = function() {
                calculateAndDisplayRoute(directionsService, directionsRenderer);
            };
            // Button "Ir" listener for start route
            google.maps.event.addListener(infowindow, 'domready', function() {
                // console.log("ready");
                document.getElementById('btn-ir').onclick = onChangeHandler;
            });

            //Listen for any clicks on the map.
            marker.addListener('click', function(event) {
                infowindow.setContent(contentString);
                infowindow.open(map, marker);
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                // console.log(JSON.stringify(clickedLocation.toJSON(), null, 2));
                //Get the marker's location.
                var currentLocation = marker.getPosition();
                //Add lat and lng values to a field that we can save.
                document.getElementById('lat').value = currentLocation.lat(); //latitude
                document.getElementById('lng').value = currentLocation.lng(); //Longitude
            });
            // document.getElementById("parkingName").value = ubicacion.parkingName;
            // document.getElementById("parkingAddress").value = ubicacion.directionName;
            // document.getElementById("phoneNumber").value = ubicacion.phoneNumber;
        });
		/**************************************/
            

        //Current location
        infoWindow = new google.maps.InfoWindow();
        const locationButton = document.createElement("button");
        locationButton.textContent = "Click para ver tu ubicación";
        locationButton.classList.add("custom-map-control-button");
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
        locationButton.addEventListener("click", () => {
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
						document.getElementById('startLat').value = position.coords.latitude; //latitude
                        document.getElementById('startLng').value = position.coords.longitude; //longitude
                        infoWindow.setPosition(pos);
                        infoWindow.setContent("Tu ubicación");
                        infoWindow.open(map);
                        map.setCenter(pos);
                    },
                    () => {
						alert("error al obtener la ubicacion")
                        handleLocationError(true, infoWindow, map.getCenter());
                    }
                );
            } else {
				alert("navigation no tiene geolocation")
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
        });
    }

    //Route
    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        var endLatitude = document.getElementById('lat').value;
        var endLongitude = document.getElementById('lng').value;
        var end = new google.maps.LatLng(endLatitude, endLongitude);

        var startLatitude = document.getElementById('startLat').value;
        var startLongitude = document.getElementById('startLng').value;
        var start = new google.maps.LatLng(startLatitude, startLongitude);
        directionsService.route({
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING,
            },
            (response, status) => {
                if (status === "OK") {
                    directionsRenderer.setDirections(response);
                } else {
                    window.alert("Primero selecciona tu ubicación");
                }
            }
        );
    }

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(
            browserHasGeolocation ?
            "Error: The Geolocation service failed." :
            "Error: Your browser doesn't support geolocation."
        );
        infoWindow.open(map);
    }
</script>
