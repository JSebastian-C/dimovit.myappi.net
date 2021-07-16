<div id="fake_header">
    <a href="/ask_for_service" id="chevron_left"><i class="fa fa-chevron-left"></i></a>
    <span id="title">Servicio en camino</span>
</div>

<div id="map">
    MAPA AQUÍ
</div>

<div id="aux_window">
    <i id="chevron"></i>

    <div id="head_window">
        <div id="sec_1">
            <div id="one">
                <img id="img_profile" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-includes/images/smilies/rolleyes.png' ?>">
                <div>
                    <span id="name"><strong>Diego Sánchez</strong></span><br>
                    <span id="id_car">AAA-586</span>
                </div>
            </div>

            <div id="two">
                <i class="fa fa-star"></i>
                <span>4.8</span>
            </div>
        </div>

        <div id="sec_2">
            <div>
                <i class="fa fa-car-alt"></i><br>
                <span>Marca auto</span>
            </div>
            <div>
                <i class="fa fa-money-bill-alt"></i><br>
                <div id="cash">
                    <span>Efectivo</span><br>
                    <i class="fa fa-sort-down"></i>
                </div>
            </div>
            <div>
                <i class="fa fa-dollar-sign"></i><br>
                <span>$50.000</span>
            </div>
        </div>
    </div>

    <!-- <div id="body_window">

    </div> -->

    <div id="foot_window">
        <div><i class="fa fa-plus-circle"></i> Ver más</div>
        <div><i class="fa fa-window-close"></i> Cancelar</div>
    </div>
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
</style>

<script>
    jQuery(($) => {
        let window_up = false,
            cash_show = false,
            entrega_en_proceso = false;

        window.onload = () => {
            chevron();
            aux_window();
        }

        //Se activa al presionar el icono chevron
        $("#chevron").click(() => {
            if (window_up == false) {

                /* $("#map").css({

                });

                $("#aux_window").css("height", "30%"); */

                window_up = true;

            } else {
                /* $("#aux_window").css("height", "25%"); */

                window_up = false;
            }
            chevron();
            aux_window();
            console.log(window_up);
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
                /*  $("#aux_window").css("height", "30%"); */
            } else {
                $("#map").css("height", "55%");
                /* $("#aux_window").css("height", "40%"); */
            }
        }

        //Se valida si el icono de la sección "efectivo" se seleccionó
        $("#cash i").click(() => {
            cash_show == false ? /* $("#cash i").toggleClass("fa fa-sort-down"), */ cash_show = true : /* $("#cash i").toggleClass("fa fa-chevron-down"), */ cash_show = false;
            cash();
        });

        function cash() {
            console.log("Variable cash_show: " + cash_show);
        }
    });
</script>