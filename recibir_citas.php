<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = " ";
$dbname = "consultorio_bd";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener las citas
$sql = "SELECT c.fecha_cita, s.nombre_servicio, u.nombre 
        FROM citas c
        JOIN servicios s ON c.id_servicio = s.id_servicio
        JOIN pacientes p ON c.id_paciente = p.id_paciente
        JOIN usuarios u ON p.id_usuario = u.id_usuario
        WHERE c.estado = 'activo'";

$result = $conn->query($sql);

$citas = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $citas[] = $row;
    }
}

// Devolver las citas en formato JSON
echo json_encode($citas);

$conn->close();
?>
