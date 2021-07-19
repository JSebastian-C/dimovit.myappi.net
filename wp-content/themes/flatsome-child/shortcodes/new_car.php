<div id="screens">
    <img id="img" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/Dimovit logo.png' ?>">

    <div id="screen1">
        <input type="text" placeholder="Nombre">
        <input type="text" placeholder="Apellido">
        <input type="text" placeholder="Número telefónico">
        <input type="text" placeholder="Modelo de auto">
        <input type="text" placeholder="Placa">
    </div>


    <div id="screen2">
        <div id="profile_photo">
            <div id="photo">
                <img>
                <i class="fa fa-camera"></i>
            </div>
            <div id="text">
                <span id="title">Adjuntar foto de perfil</span> <br>
                <span id="desc">tamaño mínimo: <span>100x100</span></span>
            </div>
        </div>

        <div id="property_card_photo">
            <div id="photo">
                <img>
                <i class="fa fa-camera"></i>
            </div>
            <div id="text">
                <span id="title">Adjuntar foto de la tarjeta de propiedad</span> <br>
                <span id="desc">tamaño mínimo: <span>100x100</span></span>
            </div>
        </div>
    </div>


    <div id="screen3">
        <input type="text" placeholder="Correo electrónico">
        <input type="text" placeholder="Contraseña">
        <input type="text" placeholder="Repetir contraseña">
    </div>
</div>

<button id="next">Continuar</button>

<div id="tabs">
    <div id="tab_1"></div>
    <div id="tab_2"></div>
    <div id="tab_3"></div>
</div>

<style>
    #main {
        height: 100vh;
        background: linear-gradient(#FFF, #FFF, #ffe5d4);
        text-align: center;
    }

    #screens {
        padding: 50px;
    }

    #screens img {
        height: 90px;
        width: 100px;
        margin-top: 50px;
    }

    #screens #screen1 {
        margin-top: 50px;
        margin-bottom: 10px;
    }

    #screens #screen1 input,
    #screens #screen3 input {
        border: none;
        border-bottom: 1px solid #a7a7a7;
        width: 100%;
        background-color: transparent;
        box-shadow: none;
        -webkit-box-shadow: none;
    }

    #screens #screen1 input::placeholder,
    #screens #screen3 input::placeholder {
        color: #a7a7a7;
    }

    #screen2 {
        text-align: justify;
    }

    #screen2 #profile_photo,
    #screen2 #property_card_photo {
        display: flex;
        align-items: center;
        justify-content: center;
    }


    #screen2 #profile_photo {
        margin-top: 10px;
    }

    #screen2 #property_card_photo {
        margin-top: 57px;
    }


    #screen2 #profile_photo #photo i,
    #screen2 #property_card_photo #photo i {
        color: #FFF;
        background-color: #53658d;
        padding: 10px;
        border-radius: 30px;
        margin-top: -50px;
    }

    #screen2 #profile_photo #photo img,
    #screen2 #property_card_photo #photo img {
        background-color: #BFBFC0;
        border-radius: 500px;
    }

    #screen2 #profile_photo #photo,
    #screen2 #property_card_photo #photo {
        height: 100px;
        width: 105px;
        text-align: center;
    }

    #screen2 #profile_photo #text #title,
    #screen2 #property_card_photo #text #title {
        color: #53658d;
        font-weight: bold;
        font-size: 15px;
    }

    #screen2 #profile_photo #text,
    #screen2 #property_card_photo #text {
        width: 200px;
        margin-left: 15px;
        margin-top: 70px;
    }

    #screen2 #profile_photo #text #desc,
    #screen2 #property_card_photo #text #desc {
        color: #adadad;
        font-size: 15px;
    }

    #screen2 #profile_photo #text #desc span,
    #screen2 #property_card_photo #text #desc span {
        color: #a7a7a7;
    }

    #screens #screen3{
        margin-top: 150px;
        margin-bottom: 18.5px;
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
        width: 70%;
        margin-left: 15px;
        margin-top: 100px;
    }
</style>

<script>
    jQuery(($) => {
        let c = 1;

        window.onload = () => {
            current_page();
        }

        //Acción que se realiza al presionar el botón con el identificador "#next"
        $("#next").click(() => {
            if (c > 3) {
                window.location.href = "/start";
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

            $("#screen" + c).fadeIn();
            $("#tab_" + c).css({
                "background-color": "#53658d",
                "animation-name": "tabs",
                "animation-duration": "0.5s"
            });

            c++;
        }
    });
</script>