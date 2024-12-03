<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_paciente = $_POST['id_paciente'];
    $fecha_cita = $_POST['fecha_cita'];
    $hora_cita = $_POST['hora_cita'];
    $id_servicio = $_POST['id_servicio'];
    $comentarios = $_POST['comentarios'] ?? '';
    $estado = 'pendiente';  // Valor predeterminado para el estado de la cita

    // Preparar la consulta para insertar la cita
    $sql = "INSERT INTO citas (id_paciente, fecha_cita, hora_cita, id_servicio, comentarios, estado)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Preparar y ejecutar la consulta
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ississ", $id_paciente, $fecha_cita, $hora_cita, $id_servicio, $comentarios, $estado);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'La cita se ha registrado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ocurrió un error al registrar la cita.']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo preparar la consulta.']);
    }

    $conn->close();
}
?>