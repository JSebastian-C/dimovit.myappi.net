<div id="map">
    MAPA AQUÍ
</div>

<!-- <div id="aux_window">
    <div id="notification"></div>
    <div id="user_cont"></div>
</div> -->

<style>
    #main {
        height: 100vh;
    }

   /*  #map {
        background-color: #BFBFC0;
        height: 75vh;
    } */

   /*  #aux_window {
        background-color: #FFF;
    }

    #ad {
        text-align: center;
        padding: 35px;
        padding-top: 10px;
    }

    #ad i {
        color: #f07647;
        font-size: 18px;
        position: absolute;
        right: 15px;
    }

    #ad #title {
        color: #51668e;
        text-justify: center;
        font-size: 20px;
        font-weight: bold;
    }

    #ad #desc {
        color: #8e8c8b;
        text-align: justify;
        margin-top: 10px;
    }

    #ad #confirm {
        background: linear-gradient(to right, #f07647, #f29351);
        border-radius: 30px;
        color: #FFF;
        width: 100%;
        margin-top: 10px;
    }

    #user {
        padding: 30px;
        padding-top: 10px;
    }

    #user #sec_1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #user #sec_1 #info img {
        height: 80px;
        width: 80px;
    }

    #user #sec_1 #info {
        display: flex;
    }

    #user #sec_1 #info #user_i {
        padding-top: 10px;
        padding-left: 10px;
    }

    #user #sec_1 #info #user_i span {
        color: #000;
    }

    #user #sec_1 #info #user_i #name {
        font-size: 18px;
        font-weight: bold;
    }

    #user #sec_1 #rating i {
        color: #ffd300;
    }

    #user #sec_1 #rating span {
        color: #000;
    }

    #user #sec_2 {
        display: flex;
        justify-content: space-between;
        padding-top: 13px;
    }

    #user #sec_2 span {
        color: #000;
    }

    #user #sec_2 #method_pay i {
        margin-right: 10px;
        color: #ef7647;
        font-size: 20px;
    }

    #user #sec_3 {
        display: flex;
        justify-content: space-evenly;
        padding-top: 13px;
    }

    #user #sec_3 div {
        text-align: center;
    }

    #user #sec_3 div i {
        color: #FFF;
        font-size: 20px;
        background-color: #53658d;
        padding: 10px;
        border-radius: 30px;
    }

    #user #sec_3 div span {
        color: #000;
    }
 */
    #not {
        background-color: #f07647;
        padding: 15px;
        position: absolute;
        top: 10px;
        width: 90%;
        text-align: center;
    }

    #not span {
        font-size: 20px;
        color: #FFF;
    }

    #notification {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    let alert = "",
        user = "",
        sign = "",
        step = 2,
        show_alert = false;

    alert = '' +
        '<div id="not">' +
        '<span>¡Una persona te ha solicitado</span>' +
        '</div>';

    sign = '' +
        '<div id="ad">' +
        '<i class="fa fa-window-close"></i>' +
        '<span id="title">Busca en el mapa</span><br>' +
        '<div id="desc">' +
        '<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </span>' +
        ' </div>' +
        '<button id="confirm">Confirmar</button>' +
        ' </div>';

    user = '' +
        '<div id="user">' +
        '<div id="sec_1">' +
        '<div id=info>' +
        '<img id="img_profile" src=' + document.location.origin + "/wp-includes/images/smilies/rolleyes.png" + '>' +
        '<div id="user_i">' +
        '<span id="name">Diego Sánchez</span><br>' +
        '<span id="address">Autopista sur oriental</span>' +
        '</div>' +
        '</div>' +
        '<div id="rating">' +
        '<i class="fa fa-star"></i>' +
        '<span>4.8</span>' +
        ' </div>' +
        '</div>' +

        '<div id="sec_2">' +
        '<div id="method_pay">' +
        '<i class="fa fa-money-bill-alt"></i>' +
        '<span>Efectivo</span>' +
        '</div>' +

        '<span>$50.000</span>' +
        '</div>' +

        '<div id="sec_3">' +
        '<div id="call">' +
        '<i class="fa fa-phone"></i><br>' +
        '<span>Llamar</span>' +
        '</div>' +
        '<div id="chat">' +
        '<i class="fa fa-comment"></i><br>' +
        '<span>Chat</span>' +
        '</div>' +
        '<div id="cancel">' +
        '<i class="fa fa-window-close"></i></i><br>' +
        '<span>Cancelar</span>' +
        ' </div>' +
        '</div>' +
        '</div>';


    jQuery(($) => {
        window.onload = () => {
            /* Titulo del header */
            $("#logo>a").attr("href", "/start");

            aux_window();
            notification();
        }

        //Logica para mostrar el mensaje de instrucción o datos del cliente en la ventana inferior
        function aux_window() {
            if (step == 1) {
                $("#user_cont").html(sign);
            } else {
                $("#user_cont").html(user);
            }
        }

        //Logica para mostrar la notificación
        function notification() {
            if (show_alert == true) {
                $("#notification").html(alert);
            } else {
                $("#notification").html(null);
            }
        }
    });
</script>