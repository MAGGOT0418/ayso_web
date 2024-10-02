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
$email = $_POST['email'];  // Capturamos el email
$pass = $_POST['password']; // Capturamos la contraseña

// Verificar credenciales
$sql = "SELECT u.id_usuario, u.correo, u.contraseña FROM usuarios u WHERE u.correo = ? AND u.contraseña = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $pass); // Bind de email y contraseña
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si el login es exitoso
    $row = $result->fetch_assoc();
    $_SESSION['id_usuario'] = $row['id_usuario']; // Almacenar el ID del usuario en la sesión
    // Redirigir a index.html
    header("Location: /AYSO_WEB-main/index.html");
    exit();
} else {
    // Si las credenciales no coinciden
    echo "Correo electrónico o contraseña incorrectos.";
}

$stmt->close();
$conn->close();
?>
