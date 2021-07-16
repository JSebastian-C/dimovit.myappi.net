<div id="screens">
    <div id="step_1">
        <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-6.png' ?>"><br>
        <span id="span1">¿Donde deseas que lo recojamos?</span><br>

        <div id="my_address">
            <i class="fa fa-map-marker-alt"></i><br>

            <div>
                <span id="ma_ext">Autopista Simón Bolivar</span><br>
                <span>Calle 70 # 40-50</span>
            </div>
        </div>

        <div id="recent_locations">
            <span>Ubicaciones recientes</span>
            <div id="divider_step_1"></div><br>
        </div>

        <div id="locations">
            <i class="fa fa-map-marker-alt"></i>
            <span>Ubicaciones recientes</span>
        </div><br>
        <div id="locations">
            <i class="fa fa-map-marker-alt"></i>
            <span>Ubicaciones recientes</span>
        </div><br>
        <div id="locations">
            <i class="fa fa-map-marker-alt"></i>
            <span>Ubicaciones recientes</span>
        </div>
    </div>



    <div id="step_2">
        <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-2.png' ?>"><br>

        <span id="span1">¿Qué tipo de auto buscas?</span>

        <div id="vehicles">
            <div id="vehicle">
                <i class="fa fa-car"></i>
                <span>Particular</span>
            </div>
            <div id="vehicle">
                <i class="fa fa-shuttle-van"></i>
                <span>Camioneta</span>
            </div>
            <div id="vehicle">
                <i class="fa fa-truck"></i>
                <span>Furgoneta</span>
            </div>
        </div>
    </div>



    <div id="step_3">
        <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-2.png' ?>"><br>

        <span id="span1">Autos disponibles</span>

        <div id="avaliable_vehicles">
            <div id="vehicles">
                <div id="v_a1">
                    <span>Kia picanto</span><br>
                    <span>AAA-586</span>
                </div>
                <div id="v_a2">
                    <i class="fa fa-clock"></i><br>
                    <span>4 mins</span>
                </div>
            </div>
            <div id="vehicles">
                <div id="v_b1">
                    <span>Kia picanto</span><br>
                    <span>AAA-586</span>
                </div>
                <div id="v_b2">
                    <i class="fa fa-clock"></i><br>
                    <span>4 mins</span>
                </div>
            </div>
            <div id="vehicles">
                <div id="v_c1">
                    <span>Kia picanto</span><br>
                    <span>AAA-586</span>
                </div>
                <div id="v_c2">
                    <i class="fa fa-clock"></i><br>
                    <span>4 mins</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tabs">
    <div id="tab_1"></div>
    <div id="tab_2"></div>
    <div id="tab_3"></div>
</div>

<button id="next">Continuar</button>

<style>
    #main {
        height: 100vh;
        width: 100%;
        text-align: center;
    }

    #screens {
        width: 100%;
        display: transparent;
    }

    /* #screens div {} */

    /* Pantalla 1 */
    #step_1 {
        margin-top: 45px;
        padding-left: 30px;
        padding-right: 30px;
        margin-bottom: 100px;
    }

    #step_1 img {
        height: 20vh;
        width: 20vh;
        margin-bottom: 15px;
    }

    #step_1 #span1 {
        color: #000;
        font-size: 18px;
    }

    #my_address {
        display: flex;
        align-items: center;
        background-color: #f6f6f6;
        text-align: left;
        /* margin-left: 8%;
        margin-right: 8%; */
        margin-top: 8px;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 1px;
    }

    #my_address i {
        height: 20px;
        width: 20px;
        margin: 10px;
        color: #53658d;
    }

    #recent_locations {
        text-align: left;
        /* margin-left: 8%;
        margin-right: 8%; */
        padding-top: 8px;
    }

    #recent_locations span {
        font-size: 15px;
        margin-left: 5px;
        color: #bbbbbb;
    }

    #divider_step_1 {
        height: 1px;
        background-color: #bbbbbb;
        padding-left: 5vh;
        padding-right: 5vh;
    }

    #locations {
        text-align: left;
        margin-top: -20px;
    }

    #locations i {
        margin: 10px;
        color: #b3b3b3;
    }

    /* Pantalla 2 */
    #step_2 {
        margin-top: 45px;
        margin-bottom: 145px;
    }

    #step_2 img {
        height: 15vh;
        width: 20vh;
        margin-bottom: 18px;
    }

    #step_2 #span1 {
        color: #000;
        font-size: 18px;
    }

    #step_2 #vehicles {
        margin-top: 20px;
    }

    #step_2 #vehicle {
        text-align: left;
        margin-left: 25%;
        margin-top: 20px;
    }

    #step_2 #vehicle i {
        color: #53658d;
        margin: 20px;
    }

    #step_2 #vehicle span {
        color: #f4744a;
        font-size: 20px;
    }

    /* Pantalla 3 */
    #step_3 {
        margin-top: 45px;
        padding-left: 30px;
        padding-right: 30px;
        margin-bottom: 111px;
    }

    #step_3 img {
        height: 15vh;
        width: 20vh;
        margin-bottom: 20px;
    }

    #step_3 #span1 {
        color: #000;
        font-size: 18px;
    }

    #avaliable_vehicles {
        margin-top: 10px;
        width: 100%;
    }

    #avaliable_vehicles #vehicles {
        display: flex;
        background-color: #fff6f1;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 15px;
        justify-content: space-between;
    }

    #step_3 #avaliable_vehicles #vehicles {
        box-shadow: 5px 5px 5px 0px #eee;
    }

    #step_3 #avaliable_vehicles #vehicles:hover {
        box-shadow: 5px 10px 5px 0px #eee;
    }

    #v_a1,
    #v_b1,
    #v_c1 {
        color: #6c7997;
        text-align: left;
    }

    #v_a2,
    #v_b2,
    #v_c2 {
        color: #ed7747;
        text-align: center;
    }

    #tabs {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }

    #tabs div {
        height: 10px;
        width: 10px;
        margin: 10px;
        border-radius: 15px;
    }

    @keyframes tabs {
        from {
            background-color: #f07647;
        }

        to {
            background-color: #53658d;
        }
    }

    #next {
        background: linear-gradient(to right, #f07647, #f29351);
        color: #FFF;
        border-radius: 30px;
        width: 80%;
        margin-left: 15px;
    }
</style>

<script>
    jQuery(($) => {
        let c = 1;

        //Al abrir este archivo .php se pone la pagina que figure  con el valor de la variable "c", en este caso cómo se inicializa en 1 la página que se muestra es la primera
        window.onload = () => {
            /* Titulo del header */
            $("#logo>a").attr("href", "/start");
            $("#logo>a").html("Dirección");

            current_page();
        }

        //Acción que se realiza al presionar el botón con el identificador "#next"
        $("#next").click(() => {
            console.log(c);
            if (c > 3) {
                window.location.href = "/confirm_address";
            } else {
                current_page();
            }
        });

        //Esta función oculta las páginas que no figura con el valor de la variable "c", y la página que si lo haga se muestra y lo mismo con el indicador
        function current_page() {
            $("#screens>div").hide();
            $("#tabs div").css({
                "background-color": "#f07647",
            });

            $("#step_" + c).fadeIn();
            $("#tab_" + c).css({
                "background-color": "#53658d",
                "animation-name": "tabs",
                "animation-duration": "0.5s"
            });

            c++;
        }
    });
</script>