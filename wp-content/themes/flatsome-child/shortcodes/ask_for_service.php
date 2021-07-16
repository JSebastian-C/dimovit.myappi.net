MAPA AQUÍ



<!-- Shortcode de Flatsome para mostrar un lightbox -->
[button id="b_modal" text="Abrir ventana" link="#modal" background-color: #FFF;]
<!-- width="100%" height="100%" -->
[lightbox id="modal" padding="0px"]
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
[/lightbox]

<style>
    #main {
        height: 100vh;
        width: 100%;
    }

    /* .mfp-container {} */

    .mfp-content {
        background-color: transparent;
    }

    #modal {
        border-radius: 15px;
    }

    #child_modal {
        margin: 20px;
    }

    #image {
        height: 20vh;
        width: 20vh;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .button {
        background-color: #f07647;
        text-transform: lowercase;
    }

    #header_modal {
        text-align: center;
        margin-bottom: 15px;
    }

    #title_modal {
        font-size: 18px;
        color: #52638d;
        font-weight: bold;
    }

    #desc_modal {
        text-align: justify;
        color: #626262;
    }

    #b_start {
        background: linear-gradient(to right, #f07647, #f29351);
        color: #FFF;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
        margin-bottom: -3.3vh;
        width: 100%;
        padding-left: -15px;
        padding-right: -15px;
    }

    /* .icon-menu:active() {
        .mfp-content {
            background: linear-gradient(#FFF, #FFF, #ffe5d4);
        }
    } */
</style>

<script>
    jQuery(($) => {
        /*  $(".icon-menu").click(() => {
               Estilo de menú lateral 
             console.log("Hola")
         }); */

        window.onload = () => {
            /* Titulo del header */
            $("#logo>a").attr("href","/start");
        }
    });
</script>