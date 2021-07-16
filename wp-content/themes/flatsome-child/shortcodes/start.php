    <div class="ext_body">
        <div class="solicitar_servicio">
            <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-4.png' ?>" /><br>
            <span>Solicitar servicio</span><br>
            <a href="/ask_for_service"><Button class="b_solicitar_servicio">Empezar</Button></a>
        </div>

        <div class="divider"></div>

        <div class="ofrecer_servicio">
            <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-5.png' ?>" /><br>
            <span>Ofrecer servicio</span><br>
            <a href=""><Button class="b_ofrecer_servicio">Empezar</Button></a>
        </div>
    </div>
    <style>
        #main {
            background-color: #FFF;
            height: 100vh;
            width: 100%;
            text-align: center;
        }

        .ext_body {
            margin-top: 10%;
        }

        .solicitar_servicio span,
        .ofrecer_servicio span {
            color: #000;
            font-size: 17px;
        }

        .solicitar_servicio img,
        .ofrecer_servicio img {
            margin-bottom: 3%;
        }

        .solicitar_servicio img {
            height: 40%;
            width: 35%;
        }

        .ofrecer_servicio img {
            height: 50%;
            width: 50%;
        }

        .b_solicitar_servicio,
        .b_ofrecer_servicio {
            background: linear-gradient(to right, #f07647, #f29351);
            color: #FFF;
            font-weight: bold;
            padding-left: 15%;
            padding-right: 15%;
            border-radius: 10px;
            margin-top: 5%;
        }

        .divider {
            background-color: #b0a9a7;
            height: 1.5px;
            border-radius: 30px;
            margin: 10%;
            margin-left: 50px;
            margin-right: 50px;
        }

        /*  Estilo de menú lateral */
        .mfp-content {
            background: linear-gradient(#FFF, #FFF, #ffe5d4);
        }
    </style>

    <script>
        jQuery(($) => {
            window.onload = () => {
                /* Titulo del header */
                $("#logo>a").attr("href", "/start");
            }
        });
    </script>