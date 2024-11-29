<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
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
    $condiciones = implode(", ", $_POST['condiciones']); // Convertir las condiciones médicas en una cadena
    $otras_condiciones = $_POST['otras_condiciones'];

    // Insertar los datos en la tabla "pacientes"
    $sql = "INSERT INTO pacientes (nombre, fecha_nacimiento, direccion, telefono, email, motivo_consulta, tratamiento_medico, medicamentos, alergias, alergias_detalle, condiciones, otras_condiciones)
    VALUES ('$nombre', '$fecha_nacimiento', '$direccion', '$telefono', '$email', '$motivo_consulta', '$tratamiento_medico', '$medicamentos', '$alergias', '$alergias_detalle', '$condiciones', '$otras_condiciones')";

    if ($conn->query($sql) === TRUE) {
        echo "Nuevo registro creado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Cerrar la conexión
    
    $conn->close();
}
?>
