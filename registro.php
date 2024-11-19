<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/favicon.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('./img/bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container-fluid {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center; 
            padding-top: 20px;
        }

        .card {
            width: 100%;
            max-width: 600px; 
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card p-4">
            <h1 class="text-center mb-4">Registro de Usuario</h1>

            <form method="POST" action="guardar_usuario.php">
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
    </div>
    <div class="form-group">
        <label for="telefono">Teléfono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese su teléfono" required>
    </div>
    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese una contraseña" required>
    </div>
    <input type="hidden" class="form-control" id="tipo" name="tipo" value="usuario">
    <button type="submit" class="btn btn-success btn-lg btn-block">Registrarse</button>
</form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
