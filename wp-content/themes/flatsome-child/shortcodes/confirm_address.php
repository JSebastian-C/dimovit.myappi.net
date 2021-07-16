<div id="fake_header">
    <a href="/ask_for_service" id="chevron_left"><i class="fa fa-chevron-left"></i></a>
    <span id="title">Confirmar dirección</span>
</div>

<div id="map">
    MAPA AQUÍ
</div>

<div id="aux_window"></div>

<style>
    #main {
        height: 100vh;
    }

    #fake_header {
        background-color: #f07647;
        color: #FFF;
        height: 7.5vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #chevron_left {
        margin-left: 2vh;
        position: absolute;
        left: 5px;
        color: #FFF;
    }

    #fake_body {
        height: 100vh;
        display: flex;
        flex-direction: column;
    }

    #map {
        height: 75%;
        background-color: #BFBFC0;
    }

    #aux_window {
        background-color: #FFF;
        height: 25%;
    }

    #confirm_service {
        margin: 30px;
        text-align: center;
    }

    #confirm_service>i {
        background-color: #FFF;
        color: #f07647;
        text-align: center;
        position: absolute;
        right: 32px;
    }

    #confirm_service #div1 {
        text-align: center;
    }

    #confirm_service #div1 span {
        color: #000;
        font-size: 18px;
    }

    #confirm_service #div2,
    #confirm_service #div3 {
        color: #7c7c7c;
        background-color: #f6f6f6;
        border-radius: 5px;
        margin-top: 10px;
        padding: 5px;
        text-align: left;
    }

    #confirm_service #div2 i,
    #confirm_service #div3 i {
        margin-left: 10px;
    }

    #confirm_service #div2 span,
    #confirm_service #div3 span {
        margin-left: 10px;
    }

    #loading {
        text-align: center;
        padding-top: 15px;
        transition: 1s;
    }

    #loading img {
        height: 150px;
        width: 150px;
        /*         margin-bottom: 15px;
 */
    }

    #loading span {
        color: #000;
        font-size: 20px;
    }

    #confirm {
        background: linear-gradient(to right, #f07647, #f29351);
        color: #FFF;
        border-radius: 30px;
        width: 90%;
        margin-left: 15px;
        margin-top: 20px;
    }
</style>

<script>
    jQuery(($) => {
        let n = 1,
            foo = "";

        window.onload = () => {
            footer();
        }

        /* Aquí se declara una varible que contiene lo que se muestra en aux_window */
        function footer() {
            if (n == 1) {
                foo = " " +
                    "<div id = 'confirm_service' >" +
                    "<i class='fa fa-window-close'></i>" +

                    "<div id='div1'>" +
                    "<span> Confirma tu servicio </span>" +
                    "</div>" +

                    "<div id = 'div2'>" +
                    "<i class = 'fa fa-map-marker-alt'></i>" +
                    "<span>Autopista Sur Oriental</span>" +
                    "</div>" +

                    "<div id = 'div3'>" +
                    "<i class='fa fa-map-marker-alt'></i>" +
                    "<span>Autopista Simón Bolivar</span>" +
                    "</div>" +

                    "<a href = '/service_on_the_way'><button id='confirm'>Confirmar</button></a>" +
                    "</div>";

                $("#aux_window").html(foo);
            } else {
                foo = " " +
                    "<div id = 'loading'>" +
                    "<img src = " + document.location.origin + '/wp-content/themes/applay-child/images/dimovit-icono-5.png' + "><br>" +
                    "<span>Conectando con el servicio</span> " +
                    "</div>";

                $("#aux_window").html(foo);
            }
        }
    });
</script>