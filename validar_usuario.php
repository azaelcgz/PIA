<?php
session_start();
require_once('./db.php'); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['contrasena']; 
        $nombreUsuario = $row['nombre']; 
        $emailUsuario = $row['email']; 
        $telefonoUsuario = $row['telefono']; 
        $rol_id = $row['rol_id']; 
        if (password_verify($password, $storedPassword)) {
            $_SESSION['usuario'] = [
                'rol_id' => $rol_id,
                'nombre' => $nombreUsuario,
                'username' => $username,
                'email' => $emailUsuario,
                'telefono' => $telefonoUsuario
            ];
            if ($rol_id == 0) {
                $_SESSION['cambiar_contrasena'] = true; 
                header("Location: modal_cambio_contrasena.php"); 
            } else {
                if ($rol_id === 1) { 
                    header("Location: index.php");
                } elseif ($rol_id === 2) { 
                    header("Location: index.php");
                } elseif ($rol_id === 3) { 
                    header("Location: index.php");
                }
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    $stmt->close();
    $conn->close();
}
?>

