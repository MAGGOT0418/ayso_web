<?php 
session_start(); // Iniciar sesión

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username']; 
    $pass = $_POST['password']; 

    $sql = "SELECT u.id_usuario, u.nombre, u.correo, u.password, u.id_rol 
            FROM usuarios u 
            WHERE u.correo = ? AND u.password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $_SESSION['id_usuario'] = $row['id_usuario'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['correo'] = $row['correo'];
        $_SESSION['id_rol'] = $row['id_rol'];

        if ($row['id_rol'] == 3) {
            header("Location: ../vistas/registrar_cita.php");
        } elseif ($row['id_rol'] == 1) { 
            header("Location: ../vistas/dashboard.php");
        } else {
            echo "Rol no reconocido.";
        }
        exit();
    } else {
        echo "Credenciales incorrectas. Por favor, intenta nuevamente.";
    }

    $stmt->close();
}

$conn->close();
?>

 