<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('./db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT id, nombre_plato AS nombre, descripcion, precio FROM menu WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $platillo = $result->fetch_assoc();
    echo json_encode($platillo);
}
?>
