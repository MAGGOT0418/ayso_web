<?php 
session_start(); // Iniciar sesión

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd3";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $user = $_POST['username']; // Correo electrónico del usuario
    $pass = $_POST['password']; // Contraseña

    // Consulta para verificar credenciales
    $sql = "SELECT u.id_usuario, u.nombre, u.correo, u.password, u.id_rol 
            FROM usuarios u 
            WHERE u.correo = ? AND u.password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Guardar datos en la sesión
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['correo'] = $row['correo'];
        $_SESSION['id_rol'] = $row['id_rol'];

        // Redirigir según el rol del usuario
        if ($row['id_rol'] == 3) { // Paciente
            header("Location: ../vistas/registrar_cita.php");
        } elseif ($row['id_rol'] == 1) { // Administrador
            header("Location: ../vistas/dashboard.php");
        } else {
            echo "Rol no reconocido.";
        }
        exit();
    } else {
        // Credenciales incorrectas
        echo "Credenciales incorrectas. Por favor, intenta nuevamente.";
    }

    $stmt->close();
}

$conn->close();
?>

 