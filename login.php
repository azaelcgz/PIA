<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('./img/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.9;
            z-index: -1;
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            padding-top: 20px;
        }

        .card {
            width: 100%;
            max-width: 400px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            color: #34a32a;
            font-weight: bold;
            height: 6vw;
            line-height: 6vw;
            font-size: 3.5vw;
            opacity: 1;
            animation: growAndShrink 2s infinite;
            text-shadow: 2px 2px 2px black;
        }

        .fixed-size {
            animation: none !important;
        }

        @keyframes growAndShrink {
            0%, 100% {
                font-size: 3.5vw;
            }
            50% {
                font-size: 4.5vw;
            }
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            50% {
                transform: translateX(5px);
            }
            75% {
                transform: translateX(-5px);
            }
            100% {
                transform: translateX(0);
            }
        }
    </style>
    <script>
        window.onload = function() {
            document.getElementById("username").focus();
        };
    </script>
</head>
<body>
<?php 
include './Menus/menu_login.php';
?>
    <br>
    <h2 id="title">Cafetería FIME</h2>
    <div class="container-fluid">
        <div class="card p-4">
            <h1 class="text-center mb-4">Inicio de Sesión</h1>
            <form method="POST" action="validar_usuario.php" id="login-form">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su nombre de usuario" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Iniciar Sesión</button>
            </form>
            <hr>
            <p class="text-center">¿Aún no tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>

    <script>
        setTimeout(function() {
            var titleElement = document.getElementById('title');
            titleElement.classList.add('fixed-size');
            titleElement.style.fontSize = '4vw';

            var formElement = document.getElementById('login-form');
            formElement.classList.add('shake');
            setTimeout(function() {
                formElement.classList.remove('shake');
            }, 2000);
        }, 2000);
    </script>
</body>
</html>
