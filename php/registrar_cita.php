<?php
session_start(); // Iniciar sesión

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$id_paciente = $_SESSION['id_paciente']; // Obtener id_paciente de la sesión
$id_servicio = $_POST['id_servicio'];
$fecha_cita = $_POST['fecha_cita'];
$comentarios = $_POST['comentarios'];

// Llamar al stored procedure
$sql = "CALL registrar_cita(?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $id_paciente, $id_servicio, $fecha_cita, $comentarios);

if ($stmt->execute()) {
    echo "Cita registrada exitosamente.";
} else {
    echo "Error al registrar la cita: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
