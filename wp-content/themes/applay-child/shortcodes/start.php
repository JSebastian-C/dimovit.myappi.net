    <div class="ext_body">
        <div class="solicitar_servicio">
            <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-4.png' ?>" /><br>
            <span>Solicitar servicio</span><br>
            <Button class="empezar">Empezar</Button>
        </div>

        <div class="divider"></div>

        <div class="ofrecer_servicio">
            <img src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/dimovit-icono-5.png' ?>" /><br>
            <span>Ofrecer servicio</span><br>
            <Button class="empezar">Empezar</Button>
        </div>
    </div>
    <style>
        body {
            background-color: #FFF;
        }

        .ext_body {
            text-align: center;
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

        .empezar {
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
    </style>