<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Cafetería FIME</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#menu">Menú</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#reservas">Reservar</a>
                </li>
                <li class="nav-item">
                    <a id="openModalBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactoModal">Contacto</a>
                </li>

                <!-- Verificar si el usuario está logueado -->
                <?php if (isset($_SESSION['usuario'])): ?>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="cerrar_sesion.php">Cerrar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Bienvenido, <?php echo $_SESSION['usuario']['nombre']; // Mostrar el nombre del usuario ?>
                        </a>
                    </li>
                <?php else: ?>
                    <!-- Mostrar el enlace para iniciar sesión si no está logueado -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
