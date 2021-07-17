<div id="fake_header">
    <a href="/ask_for_service" id="chevron_left"><i class="fa fa-chevron-left"></i></a>
    <span id="title">Servicio en camino</span>
</div>

<div id="map">
    MAPA AQUÍ
</div>

<div id="aux_window">
    <i id="chevron"></i>
    <div id="aux_window_child"></div>
</div>

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

    #map {
        background-color: #BFBFC0;
    }

    #aux_window {
        background-color: #FFF;
        text-align: center;
        padding: 10px;
        padding-left: 40px;
        padding-right: 40px;
    }

    #chevron {
        color: #000;
    }

    /*  #head_window {
    } */

    #sec_1 {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #one {
        /*  background-color: tomato; */
        display: flex;
    }

    #img_profile {
        height: 60px;
        width: 60px;
    }

    #one div {
        /* background-color: green; */
        text-align: left;
        padding-top: 5px;
        padding-left: 10px;
    }

    #one div span {
        font-size: 16px;
        color: #000;
    }

    #two i {
        /* background-color: blue; */
        color: #fdd303;
    }

    #two span {
        color: #000;
    }

    #sec_2 {
        display: flex;
        justify-content: space-between;
        padding-top: 10px;
    }

    #sec_2 div span {
        font-size: 13px;
        color: #000;
    }

    #sec_2 div i {
        color: #ee7647;
        font-size: 20px;
    }

    #cash {
        display: flex;
        align-items: center;
        padding-top: 3px;
    }

    #cash i {
        color: #ee7647;
        margin-left: 10px;
        margin-top: -10px;
    }

    #body_window {
        padding-top: 5px;
    }

    #body_window #sec_1 {
        display: flex;
        margin-bottom: -5px;
    }

    #body_window #sec_1 span {
        color: #000;
        font-size: 15px;
    }

    #body_window #sec_2 {
        display: flex;
    }

    #body_window #sec_2 input {
        border-color: #ee7647;
        border-width: 1px;
        border-radius: 5px;
        margin-right: 10px;
    }

    #body_window #sec_2 i {
        color: #FFF;
        background-color: #53658d;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 30px;
    }

    #foot_window {
        padding-top: 15px;
        display: flex;
        justify-content: space-between;
    }

    #foot_window div {
        font-size: 20px;
        color: #000;
    }

    #foot_window div i {
        color: #53658d;
        margin-right: 8px;
    }

    #service_on_way {
        text-align: center;
        color: #000;
        font-size: 20px;
    }
</style>

<script>
    jQuery(($) => {
        let window_up = false,
            cash_show = false,
            service_on_the_way = false,
            head_window = "",
            body_window = "",
            foot_window = "";

        window.onload = () => {
            chevron();
            service_on_way();
            aux_window();
        }

        //Se asigna el contenido html a las variables
        head_window = '' +
            '<div id="head_window">' +
            '<div id="sec_1">' +
            '<div id="one">' +
            '<img id="img_profile" src=' + document.location.origin + "/wp-includes/images/smilies/rolleyes.png" + '>' +
            '<div>' +
            '<span id="name"><strong>Diego Sánchez</strong></span><br>' +
            '<span id="id_car">AAA-586</span>' +
            '</div>' +
            '</div>' +

            ' <div id="two">' +
            '<i class="fa fa-star"></i>' +
            '<span>4.8</span>' +
            '</div>' +
            '</div>' +

            '<div id="sec_2">' +
            '<div>' +
            '<i class="fa fa-car-alt"></i><br>' +
            '<span>Marca auto</span>' +
            '</div>' +
            '<div>' +
            '<i class="fa fa-money-bill-alt"></i><br>' +
            '<div id="cash">' +
            '<span>Efectivo</span><br>' +
            '<i class="fa fa-sort-down"></i>' +
            '</div>' +
            '</div>' +
            '<div>' +
            '<i class="fa fa-dollar-sign"></i><br>' +
            '<span>$50.000</span>' +
            '</div>' +
            '</div>' +
            '</div>';

        body_window = '' +
            '<div id="body_window">' +
            '<div id="sec_1">' +
            '<span>Hora estimada de llegada</span>' +
            '<span>6:15 pm</span>' +
            '</div>' +
            '<div id="sec_2">' +
            '<input type="text" placeholder="Escribir mensaje">' +
            '<i class="fa fa-phone"></i>' +
            '</div>' +
            '</div>' +
            '';

        foot_window = '' +
            '<div id="foot_window">' +
            '<div><i class="fa fa-plus-circle"></i> Ver más</div>' +
            '<div><i class="fa fa-window-close"></i> Cancelar</div>' +
            '</div>';

        foot_window_aux = '' +
            '<div id="service_on_way">' +
            '<span>Servicio en curso</span>' +
            '</div>';

        //Se activa al presionar el icono chevron
        $("#chevron").click(() => {
            window_up == false ? window_up = true : window_up = false;

            chevron();
            service_on_way();
            aux_window();
        });

        //Animación del chevron
        function chevron() {
            $("#chevron").removeClass();
            window_up == false ? $("#chevron").toggleClass("fa fa-chevron-up") : $("#chevron").toggleClass("fa fa-chevron-down");
        }

        //Animación de tamaño del mapa y la ventana inferior
        function aux_window() {
            if (window_up == false) {
                $("#map").css("height", "65%");
                $("#aux_window_child").html(null);
                $("#aux_window_child").append(head_window);
                $("#aux_window_child").append(foot_window);
                $("#service_on_way").css("padding-top", "15px");
            } else {
                $("#map").css("height", "55%");
                $("#aux_window_child").html(null);
                $("#aux_window_child").append(head_window);
                $("#aux_window_child").append(body_window);
                $("#aux_window_child").append(foot_window);
                $("#body_window").css({
                    "padding-top": "10px"
                });
                $("#foot_window").css({
                    "padding-top": "0px"
                });
                $("#service_on_way").css("padding-top", "3px");
            }
        }

        //Se valida si el icono de la sección "efectivo" se seleccionó
        $("#cash i").click(() => {
            cash_show == false ? /* $("#cash i").toggleClass("fa fa-sort-down"), */ cash_show = true : /* $("#cash i").toggleClass("fa fa-chevron-down"), */ cash_show = false;
            console.log("Variable cash_show: " + cash_show);
        });

        //Html que se muestra si la entrega está en proceso o no
        function service_on_way() {
            if (service_on_the_way != false) {
                foot_window = foot_window_aux;
            }
        }
    });
</script>