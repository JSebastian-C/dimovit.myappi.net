<div id="map"></div>

<!-- Shortcode de Flatsome para mostrar un lightbox -->
<!-- [button id="b_modal_start" text="Empezar" link="#modal_start" background-color: #FFF;]
[button id="b_modal_calification" text="Calificar servicio" link="#modal_calification" background-color: #FFF;] -->
<!-- width="100%" height="100%" -->
<!-- [lightbox id="modal_start" padding="0px"]
<div id="child_modal">
    <div id="header_modal">
        <img id="image" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-6.png' ?>"><br>

        <span id="title_modal">Siempre a tu alcance</span><br>
    </div>

    <span id="desc_modal">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    </span>
</div>

<a href="/address"><button id="b_start">¡Empezar!</button></a>
[/lightbox] -->

<!-- [lightbox id="modal_calification" padding="0px"]

<div id="child">
    <span>¡Califica el servicio!</span>

    <div id="info">
        <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-includes/images/smilies/rolleyes.png' ?>"><br>
        <span id="name">Diego Sánchez</span><br>
        <span id="id_car">AAA-586</span>

        <div id="calification"></div>
    </div>

    <div id="specs">
        <div id="one">
            <Button id="comodidad">Comodidad</Button>
            <Button id="amabilidad">Amabilidad</Button>
        </div>
        <div id="two">
            <Button id="puntualidad">Puntualidad</Button>
            <Button id="buen_manejo">Buen manejo</Button>
        </div>
    </div>
</div>

<button id="save_rating">Calificar</button>

[/lightbox] -->

<style>
    #main {
        height: 100vh;
        width: 100%;
    }
  
  	#map {
    	height: 100vh;
     	width: 100%;
    }

    /* .mfp-container {} */

    /* .mfp-content {
        background-color: transparent;
    } */

    #modal_start {
        border-radius: 15px;
    }

    #modal_start #child_modal {
        margin: 20px;
    }

    #modal_start #child_modal #header_modal #image {
        height: 20vh;
        width: 20vh;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .button {
        background-color: #f07647;
        text-transform: lowercase;
    }

    #modal_start #child_modal #header_modal {
        text-align: center;
        margin-bottom: 15px;
    }

    #modal_start #child_modal #header_modal #title_modal {
        font-size: 18px;
        color: #52638d;
        font-weight: bold;
    }

    #modal_start #child_modal #desc_modal {
        text-align: justify;
        color: #626262;
    }

    #modal_start #b_start {
        background: linear-gradient(to right, #f07647, #f29351);
        color: #FFF;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        margin-bottom: -3.3vh;
        width: 100%;
        padding-left: -15px;
        padding-right: -15px;
    }

    #modal_calification {
        border-radius: 15px;
    }

    #modal_calification #child {
        padding: 20px;
        padding-top: 25;
        padding-bottom: 0px;
        text-align: center;
    }

    #modal_calification #child span {
        color: #53658e;
        font-weight: bold;
        font-size: 25px;
    }

    #modal_calification #child #info img {
        margin-top: 20px;
        margin-bottom: 10px;
        height: 100px;
        width: 100px;
    }

    #modal_calification #child #info span {
        color: #000;
        font-size: 18px;
    }

    #modal_calification #child #info #name {
        color: #646464;
    }

    #modal_calification #child #info #id_car {
        color: #626262;
    }

    #modal_calification #child #info #calification {
        margin-top: 15px;
    }

    #modal_calification #child #info #calification i {
        color: #9b9b9b;
        margin-left: 5px;
        margin-right: 5px;
        font-size: 18px;
    }

    #modal_calification #child #specs {
        margin-top: 15px;
        padding-left: 13px;
        padding-right: 13px;
    }

    #modal_calification #child #specs #one,
    #modal_calification #child #specs #two {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #modal_calification #child #specs #one button,
    #modal_calification #child #specs #two button {
        border-radius: 5px;
        font-size: 12.5px;
        text-transform: capitalize;
        border-width: 1px;
        border-color: #f07447;
        background-color: #FFF;
        color: #626262;
        width: 100%;
    }

    #modal_calification #save_rating {
        background: linear-gradient(to right, #f07647, #f29351);
        color: #FFF;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        width: 100%;
        margin-bottom: -20px;
    }

    .mfp-content {
        background: linear-gradient(#FFF, #FFF, #ffe5d4);
    }
</style>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPmaPhesJ1SFRazCyFMZCwZohMnqT9V8E&callback=initMap"></script>-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPmaPhesJ1SFRazCyFMZCwZohMnqT9V8E"></script>
<script>
	let map;
  		function initMap() {
          map = new google.maps.Map(document.getElementById('map'), {
            center: {
              lat: 3.420556,
              lng: -76.522224
            },
            zoom: 12,
          });
      	}
  
    
    //Rol 1: cliente | Rol 2: conductor
    let rol = 1,
        calification = 4,
        num_stars = 5,
        btn = {
            "comodidad": "false",
            "amabilidad": "false",
            "puntualidad": "false",
            "buen_manejo": "false"
        };

    jQuery(($) => {
        window.onload = () => {
            /* Titulo del header */
            $("#logo>a").attr("href", "/start");

            //Acción de los botones en la ventana modal de calificación al conductor
            buttons();
          
         	initMap();
        }

        //Lógica de la calificación del conductor
        for (let i = 0; i < num_stars; i++) {
            if (i < calification) {
                $("#modal_calification #calification").append("<i class='fa fa-star'></i>");
                $("#modal_calification #calification i").css("color", "#ffd300");
            } else {
                $("#modal_calification #calification").append("<i class='fa fa-star'></i>");
            }
        }

        //Lógica al presionar botón de las características del conductor
        $("#comodidad").click(() => {
            buttons("comodidad");
        });
        $("#amabilidad").click(() => {
            buttons("amabilidad");
        });
        $("#puntualidad").click(() => {
            buttons("puntualidad");
        });
        $("#buen_manejo").click(() => {
            buttons("buen_manejo");
        });

        function buttons(value) {
            btn[value] == "true" ? btn[value] = "false" : btn[value] = "true";

            if (btn[value] == "true") {
                $("#" + value).css({
                    "background-color": "#f07447",
                    "color": "#FFF"
                });


            } else {
                $("#" + value).css({
                    "border-width": "1px",
                    "border-color": "#f07447",
                    "background-color": "#FFF",
                    "color": "#626262"
                });
            }
        }
    });
</script>