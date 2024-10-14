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
// Obtener datos del formulario
$user = $_POST['username'];
$pass = $_POST['password'];

// Verificar credenciales
$sql = "SELECT u.id_usuario, p.id_paciente FROM usuarios u JOIN pacientes p ON u.id_usuario = p.id_usuario WHERE u.correo = ? AND u.contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['id_usuario'] = $row['id_usuario'];
    $_SESSION['id_paciente'] = $row['id_paciente']; // Almacenar id_paciente en la sesión
    // Redirigir a la página de citas
    header("Location: registrar_cita.html");
    exit();
} else {
    echo "Credenciales incorrectas.";
}

$stmt->close();
$conn->close();