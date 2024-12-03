<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $motivo_consulta = $_POST['motivo_consulta'];
    $tratamiento_medico = $_POST['tratamiento_medico'];
    $medicamentos = $_POST['medicamentos'];
    $alergias = $_POST['alergias'];
    $alergias_detalle = $_POST['alergias_detalle'];
    $condiciones = implode(", ", $_POST['condiciones']); 
    $otras_condiciones = $_POST['otras_condiciones'];

    $sql = "INSERT INTO pacientes (nombre, fecha_nacimiento, direccion, telefono, email, motivo_consulta, tratamiento_medico, medicamentos, alergias, alergias_detalle, condiciones, otras_condiciones)
    VALUES ('$nombre', '$fecha_nacimiento', '$direccion', '$telefono', '$email', '$motivo_consulta', '$tratamiento_medico', '$medicamentos', '$alergias', '$alergias_detalle', '$condiciones', '$otras_condiciones')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro creado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    
    $conn->close();
}
?>
