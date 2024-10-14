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
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$direccion = $_POST['direccion'];

// Asegurarse de que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    die("No estás logueado."); // Aquí se detiene la ejecución si no hay sesión
}

$id_usuario = $_SESSION['id_usuario']; // Obtener id_usuario de la sesión

// Insertar nuevo paciente
$sql_insert = "INSERT INTO pacientes (id_usuario, fecha_nacimiento, direccion) VALUES ('$id_usuario', '$fecha_nacimiento', '$direccion')";

if ($conn->query($sql_insert) === TRUE) {
    echo "Paciente registrado exitosamente.";
} else {
    echo "Error al registrar el paciente: " . $conn->error;
}

$conn->close();
?>

