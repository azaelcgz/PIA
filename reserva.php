<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_cliente = $_POST['nombre_cliente'];
    $num_personas = $_POST['num_personas'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $mesa_id = $_POST['mesa'];

    // Verificar si ya existe una reserva en la misma fecha, hora y mesa
    $sql_check = "SELECT * FROM reservas WHERE mesa_id = ? AND fecha = ? AND hora = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("sss", $mesa_id, $fecha, $hora);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Ya existe una reserva para esta mesa en la misma fecha y hora.";
    } else {
        // Insertar nueva reserva
        $sql = "INSERT INTO reservas (mesa_id, nombre_cliente, fecha, hora, num_personas)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $mesa_id, $nombre_cliente, $fecha, $hora, $num_personas);

        if ($stmt->execute()) {
            echo "Reserva exitosa!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $stmt_check->close();
    $stmt->close();
    $conn->close();
} elseif (isset($_GET['fecha']) && isset($_GET['hora'])) {
    $fecha = $_GET['fecha'];
    $hora_seleccionada = $_GET['hora'];

    // Convertir la hora seleccionada al formato HH:MM:SS para la comparación
    $hora_seleccionada_formato = date('H:i:s', strtotime($hora_seleccionada));

    // Obtener el nombre del día de la semana
    $dia_semana = date('N', strtotime($fecha)); // 1 para lunes, 7 para domingo
    $dias_semana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    $dia_nombre = $dias_semana[$dia_semana - 1];

    // Obtener horario de apertura y cierre de la tabla horarios
    $sql_horario = "SELECT apertura, cierre FROM horarios WHERE dia_semana = ? AND cerrado = 0";
    $stmt_horario = $conn->prepare($sql_horario);
    $stmt_horario->bind_param("s", $dia_nombre);
    $stmt_horario->execute();
    $result_horario = $stmt_horario->get_result();

    $horas_disponibles = [];
    $mesas_disponibles = [];

    if ($result_horario->num_rows > 0) {
        $row_horario = $result_horario->fetch_assoc();
        $apertura = strtotime($row_horario['apertura']);
        $cierre = strtotime($row_horario['cierre']);

        // Generar todas las horas disponibles en incrementos de 30 minutos
        for ($hora = $apertura; $hora <= $cierre; $hora += 1800) { // Cada 30 minutos
            $horas_disponibles[] = date('H:i', $hora);
        }

        // Obtener todas las mesas
        $sql_mesas = "SELECT * FROM mesas";
        $result_mesas = $conn->query($sql_mesas);

        // Inicializar array de IDs de mesas ocupadas
        $mesas_ocupadas = [];

        // Obtener reservas para la fecha y hora seleccionadas
        $sql_reservas = "SELECT mesa_id FROM reservas WHERE fecha = ? AND hora = ?";
        $stmt_reservas = $conn->prepare($sql_reservas);
        $stmt_reservas->bind_param("ss", $fecha, $hora_seleccionada_formato);
        $stmt_reservas->execute();
        $result_reservas = $stmt_reservas->get_result();

        while ($row_reserva = $result_reservas->fetch_assoc()) {
            $mesas_ocupadas[] = $row_reserva['mesa_id'];
        }

        // Filtrar mesas disponibles
        if ($result_mesas->num_rows > 0) {
            while ($row_mesa = $result_mesas->fetch_assoc()) {
                // Solo agregar mesas no ocupadas
                if (!in_array($row_mesa['id'], $mesas_ocupadas)) {
                    $mesas_disponibles[] = $row_mesa;
                }
            }
        }
    }

    // Devolver las horas y mesas disponibles en formato JSON
    echo json_encode([
        'horas_disponibles' => $horas_disponibles,
        'mesas_disponibles' => $mesas_disponibles
    ]);

    // Cerrar las conexiones
    $stmt_horario->close();
    $stmt_reservas->close();
    $conn->close();
}
?>
