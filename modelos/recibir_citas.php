<?php
require_once "../config/Conexion.php";

$response = array();

try {
    $conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    $sql = "SELECT citas.id_cita, citas.fecha_cita, citas.estado, citas.comentarios, 
                   usuarios.nombre as nombre_usuario, 
                   servicios.nombre_servicio 
            FROM citas 
            JOIN usuarios ON citas.id_paciente = usuarios.id_usuario 
            JOIN servicios ON citas.id_servicio = servicios.id_servicio";

    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $row['fecha_cita'] = date('Y-m-d H:i:s', strtotime($row['fecha_cita']));
            $response[] = $row;
        }
    }

    $conexion->close();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

echo json_encode($response);
