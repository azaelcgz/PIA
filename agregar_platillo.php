<?php
session_start();
require_once('./db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST); 
    print_r($_FILES); 
    echo "</pre>";
    if (isset($_POST['nombre_plato'], $_POST['descripcion'], $_POST['precio'], $_FILES['foto']) && 
        !empty($_POST['nombre_plato']) && !empty($_POST['descripcion']) && !empty($_POST['precio']) && !empty($_FILES['foto']['tmp_name'])) {
        $nombre = $_POST['nombre_plato']; 
        $descripcion = $_POST['descripcion']; 
        $precio = $_POST['precio']; 
        if (!empty($_FILES['foto']['tmp_name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['foto']['type'], $allowedTypes) && $_FILES['foto']['size'] <= 500000) { 
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $sql = "INSERT INTO menu (nombre_plato, descripcion, precio, foto) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    echo "<p>Error al preparar la consulta: " . $conn->error . "</p>";
                    exit();
                }
                $stmt->bind_param("ssds", $nombre, $descripcion, $precio, $foto);
                if ($stmt->execute()) {
                    header("Location: index.php"); 
                    exit();
                } else {
                    echo "<p>Error al insertar el platillo: " . $stmt->error . "</p>";
                }
            } else {
                echo "<p>Archivo no permitido o demasiado grande.</p>";
            }
        } else {
            echo "<p>Por favor complete todos los campos, especialmente la foto.</p>";
        }
    } else {
        echo "<p>Por favor complete todos los campos.</p>";
    }
}
?>
