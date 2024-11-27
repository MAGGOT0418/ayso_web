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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $direccion = $_POST['direccion'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $id_rol = 3; // Rol predeterminado: Paciente (id_rol=3)

    // Verificar si el correo ya existe
    $sql_check = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result_check = $stmt->get_result();

    if ($result_check->num_rows > 0) {
        echo "El correo electrónico ya está registrado. Intenta con otro.";
    } else {
        // Insertar nuevo usuario
        $sql_insert = "INSERT INTO usuarios (nombre, correo, password, direccion, fecha_nacimiento, id_rol) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sssssi", $nombre, $email, $pass, $direccion, $fecha_nacimiento, $id_rol);

        if ($stmt->execute()) {
            echo "Cuenta creada exitosamente. Ahora puedes iniciar sesión.";
            header("Location: ../vistas/index.php");
            exit();
        } else {
            echo "Error al crear la cuenta: " . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>