<?php
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_paciente = $_POST['id_paciente'];
    $fecha_cita = $_POST['fecha_cita'];
    $hora_cita = $_POST['hora_cita'];
    $id_servicio = $_POST['id_servicio'];
    $comentarios = $_POST['comentarios'] ?? '';
    $estado = 'pendiente';  

    $sql = "INSERT INTO citas (id_paciente, fecha_cita, hora_cita, id_servicio, comentarios, estado)
            VALUES (?, ?, ?, ?, ?, ?)";

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