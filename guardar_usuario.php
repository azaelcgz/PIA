<?php
require_once('./db.php');
$nombre = strtoupper(trim($_POST['nombre']));
$email = trim($_POST['email']);
$telefono = trim($_POST['telefono']);
$password = trim($_POST['password']);
$tipo = $_POST['tipo'];
if (empty($nombre) || empty($email) || empty($telefono) || empty($password) || empty($tipo)) {
    echo "<script>alert('Todos los campos son obligatorios.');</script>";
    echo "<script>window.location.href = 'registro.php';</script>";
    exit();
}
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$rol_id = 1;
$sql = "INSERT INTO usuarios (nombre, email, telefono, contrasena, rol_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "<script>alert('Error en la preparación de la consulta: " . $conn->error . "');</script>";
    echo "<script>window.location.href = 'registro.php';</script>";
    exit();
}

$stmt->bind_param("ssssi", $nombre, $email, $telefono, $hashedPassword, $rol_id);
if ($stmt->execute()) {
    echo "<script>window.location.href = 'index.php';</script>";
} else {
    echo "<script>alert('Error al registrar el usuario: " . $stmt->error . "');</script>";
    echo "<script>window.location.href = 'registro.php';</script>";
}
$stmt->close();
$conn->close();
?>
