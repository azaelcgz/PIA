<?php
session_start();
require_once('./db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST); 
    print_r($_FILES); 
    echo "</pre>";
    if (isset($_POST['id'], $_POST['nombre_plato'], $_POST['descripcion'], $_POST['precio'], $_FILES['foto']) && 
        !empty($_POST['nombre_plato']) && !empty($_POST['descripcion']) && !empty($_POST['precio'])) {
        $id = $_POST['id']; 
        $nombre = $_POST['nombre_plato']; 
        $descripcion = $_POST['descripcion']; 
        $precio = $_POST['precio']; 
        if (!empty($_FILES['foto']['tmp_name'])) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['foto']['type'], $allowedTypes) && $_FILES['foto']['size'] <= 500000) { 
                $foto = file_get_contents($_FILES['foto']['tmp_name']);
                $sql = "UPDATE menu SET nombre_plato = ?, descripcion = ?, precio = ?, foto = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt === false) {
                    echo "<p>Error al preparar la consulta: " . $conn->error . "</p>";
                    exit();
                }
                $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $foto, $id);
            } else {
                echo "<p>Archivo no permitido o demasiado grande.</p>";
                exit();
            }
        } else {
            $sql = "UPDATE menu SET nombre_plato = ?, descripcion = ?, precio = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo "<p>Error al preparar la consulta: " . $conn->error . "</p>";
                exit();
            }
            $stmt->bind_param("sssi", $nombre, $descripcion, $precio, $id);
        }
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "<p>Error al actualizar el platillo: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p>Por favor complete todos los campos.</p>";
    }
}
?>
