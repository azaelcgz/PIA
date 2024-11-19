<?php 
include('db.php'); 
session_start();
$is_manager = isset($_SESSION['usuario']) && $_SESSION['usuario']['rol_id'] === 2;
$query = "SELECT id, nombre_plato AS nombre, descripcion, precio, foto FROM menu";
$result = $conn->query($query);
$platillos = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Cafetería FIME</title>
</head>
<body class="bg-light">

<?php 
include './Menus/menu_usuario.php';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Bienvenidos a la Cafetería FIME</h1>
    <div id="menu" class="text-center mb-5">
        <h2 class="mb-4">Nuestro Menú</h2>
        <div class="row">
            <?php foreach ($platillos as $platillo): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="data:image/jpeg;base64,<?= base64_encode($platillo['foto']) ?>" class="card-img-top" alt="<?= $platillo['nombre'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $platillo['nombre'] ?></h5>
                            <p class="card-text"><?= $platillo['descripcion'] ?></p>
                            <p class="card-text"><strong>Precio:</strong> $<?= $platillo['precio'] ?></p>
                            <?php if ($is_manager): ?>
                                <button class="btn btn-warning" onclick="openEditModal(<?= $platillo['id'] ?>)">Editar</button>
                                <button class="btn btn-danger" onclick="deletePlatillo(<?= $platillo['id'] ?>)">Eliminar</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if ($is_manager): ?>
        <div class="text-center mb-5">
            <button id="openAddModalBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPlatilloModal">Agregar Platillo</button>
        </div>
    <?php endif; ?>

    <!-- Modal para agregar nuevo platillo -->
    <div id="addPlatilloModal" class="modal fade" tabindex="-1" aria-labelledby="addPlatilloModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlatilloModalLabel">Agregar Platillo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="agregar_platillo.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" id="nombre" name="nombre_plato" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio:</label>
        <input type="number" id="precio" name="precio" class="form-control" required step="0.01">
    </div>
    <div class="mb-3">
        <label for="foto" class="form-label">Foto:</label>
        <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
    </div>
    <div class="text-center">
        <input type="submit" value="Agregar Platillo" class="btn btn-success">
    </div>
</form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
            </div>
        </div>
    </div>

    <!-- Modal editar platillo -->
    <div id="editPlatilloModal" class="modal fade" tabindex="-1" aria-labelledby="editPlatilloModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPlatilloModalLabel">Editar Platillo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="editar_platillo.php" method="POST" enctype="multipart/form-data" id="editPlatilloForm">
                        <input type="hidden" name="id" id="editPlatilloId">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre:</label>
                            <input type="text" id="editNombre" name="nombre_plato" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción:</label>
                            <textarea id="editDescripcion" name="descripcion" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio:</label>
                            <input type="number" id="editPrecio" name="precio" class="form-control" required step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="editFoto" class="form-label">Foto:</label>
                            <input type="file" id="editFoto" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="text-center">
                            <input type="submit" value="Guardar Cambios" class="btn btn-warning">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div id="reservas" class="text-center mb-5">
    <?php if (isset($_SESSION['usuario'])): ?>
        <button id="openModalBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reservaModal">Reservar Mesa</button>
    <?php else: ?>
        <a href="login.php" class="btn btn-primary">Reservar Mesa</a>
    <?php endif; ?>
</div>

<!-- Modal para la reserva -->
<div id="reservaModal" class="modal fade" tabindex="-1" aria-labelledby="reservaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservaModalLabel">Reserva de Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="reserva.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre_cliente" class="form-label">Nombre:</label>
                        <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="num_personas" class="form-label">Número de Personas:</label>
                        <input type="number" id="num_personas" name="num_personas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora_reserva" class="form-label">Hora de Reserva:</label>
                        <input type="time" id="hora_reserva" name="hora_reserva" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_reserva" class="form-label">Fecha de Reserva:</label>
                        <input type="date" id="fecha_reserva" name="fecha_reserva" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Confirmar Reserva" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
   function openEditModal(id) {
        fetch('http://localhost/get_platillo.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById('editPlatilloId').value = data.id;
                    document.getElementById('editNombre').value = data.nombre;
                    document.getElementById('editDescripcion').value = data.descripcion;
                    document.getElementById('editPrecio').value = data.precio;
                    new bootstrap.Modal(document.getElementById('editPlatilloModal')).show();
                }
            })
            .catch(error => {
                console.error('Error al obtener los datos del platillo:', error);
            });
    }
    function deletePlatillo(id) {
    if (confirm("¿Seguro que quieres eliminar este platillo?")) {
        fetch('eliminar_platillo.php?id=' + id, { method: 'GET' })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); 
                } else {
                    alert("Hubo un error al eliminar el platillo.");
                }
            })
            .catch(error => {
                console.error('Error al eliminar el platillo:', error);
            });
    }
}
</script>
</body>
</html>


