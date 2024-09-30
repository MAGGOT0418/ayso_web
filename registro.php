<?php
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
$nombre = $_POST['nombre'];  // Cambiar 'username' a 'nombre'
$email = $_POST['email'];
$pass = $_POST['password'];
$telefono = $_POST['telefono'];
// Verificar si el usuario ya existe
$sql_check = "SELECT * FROM usuarios WHERE nombre = '$nombre' OR correo = '$email'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "El nombre de usuario o correo electrónico ya están registrados.";
} else {
    // Insertar nuevo usuario
    $sql_insert = "INSERT INTO usuarios (nombre, correo, contraseña,telefono) VALUES ('$nombre', '$email', '$pass','$telefono')";  // Cambiar 'username' a 'nombre' y 'password' a 'contraseña'
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "Cuenta creada exitosamente. Ahora puedes iniciar sesión.";
    } else {
        echo "Error al crear la cuenta: " . $conn->error;
    }
}

$conn->close();
?>
