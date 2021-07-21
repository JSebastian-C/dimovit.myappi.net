<div class="ext_body">
    <img class="img" src="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/wp-content/themes/applay-child/images/Dimovit logo.png' ?>">

    <nav class="reestablecer">Reestablecer contraseña</nav>
    <nav class="descripcion">Ingresa tu correo electrónico parar recibir nuestro link de verificación y cambiar tu contraseña</nav>

    <input type="text" placeholder="Correo electrónico" class="input">
    <button>Enviar</button>
</div>

<style>
    #main {
        background-color: #53658d;
        text-align: center;
        height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ext_body {
        background-color: #FFF;
        border-radius: 20px;
        padding-left: 10%;
        padding-right: 10%;
        margin: 10%;
    }

    .img {
        width: 40%;
        height: 40%;
        margin-top: 20%;
    }

    .reestablecer {
        color: #51678c;
        font-size: 20px;
        font-weight: bold;
        margin-top: 15%;
    }

    .descripcion {
        margin-top: 8%;
        font-size: 17px;
        text-align: justify;
    }

    .input::placeholder {
        color: #a7a7a7;
    }

    .input {
		border: none;
		border-bottom: 1px solid #a8a6a7;
		width: 100%;
		background-color: transparent;
		box-shadow: none;
		-webkit-box-shadow: none;
        margin-top: 10%;
	}

    .ext_body button {
        background: linear-gradient(to right, #f07647, #f29351);
        color: #FFF;
        border-radius: 30px;
        margin-top: 8%;
        width: 100%;
    }
</style>