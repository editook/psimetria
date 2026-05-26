<?php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispositivo no compatible</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            width:100%;
            height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            background:#ffffff;

            font-family:Arial, sans-serif;
            color:#000;

        }

        .container{

            text-align:center;

            max-width:600px;

            padding:40px;

        }

        .logo{

            width:140px;
            height:auto;

            margin-bottom:35px;

        }

        .title{

            font-size:34px;
            font-weight:700;

            margin-bottom:18px;

            color:#000;

        }

        .message{

            font-size:20px;
            line-height:1.6;

            color:#222;

        }

        .message strong{
            font-weight:700;
        }

    </style>
</head>

<body>

    <div class="container">

        <!-- LOGO -->
        <img src="../../assets/img/brand/favicon.png" alt="Logo Empresa" class="logo">

        <!-- TITULO -->
        <div class="title">
            Acceso no disponible
        </div>

        <!-- MENSAJE -->
        <div class="message">
            Esta sección no está disponible para el uso con dispositivos móviles.
            <br><br>
            Por favor ingrese desde una computadora o dispositivo compatible.
        </div>

    </div>

</body>

</html>