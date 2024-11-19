<?php
session_start();
require_once('./db.php');
$id = $_GET['id'];
$sql = "DELETE FROM menu WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = "Error al eliminar el platillo. Inténtalo de nuevo.";
}

echo json_encode($response);
?>

