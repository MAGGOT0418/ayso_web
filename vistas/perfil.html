<?php 
session_start(); // Iniciar sesión

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultorio_bd2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}

// Obtener el ID del usuario desde la sesión
$id_usuario = $_SESSION['id_usuario'];

// Consultar los datos del usuario
$sql = "SELECT nombre, correo, fecha_nacimiento, direccion FROM usuarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Error: No se encontraron datos para este usuario.";
    exit;
}

// Consultar el historial médico
$sql_historial_medico = "SELECT diagnostico, tratamiento, fecha FROM historial_medico WHERE id_paciente = ?";
$stmt = $conn->prepare($sql_historial_medico);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$historial_medico = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Clínica Dental</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="index.php" style="color: #fff;">
            <img src="../assets/images/LogoC.png" alt="Logo" style="width: 140px; height: 70px; margin-left: -30px;">
            Arte y salud oral
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="servicios.php">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registrar_cita.php">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="perfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="faq.php">FAQ</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <!-- Mostrar el círculo con la inicial del nombre del usuario -->
                    <?php $initial = strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                    <div class="dropdown">
                        <button class="btn" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-flex align-items-center justify-content-center">
                                <?= $initial ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item profile-item" href="perfil.html"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                            <li><a class="dropdown-item logout-item" href="../php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <button class="btn btn-outline-light me-3" id="loginButton"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
    <div id="loginModal" class="modal"></div>
    
    <div class="profile-header-container">
        <div class="profile-header text-center">
            <h1>Perfil de <?= htmlspecialchars($usuario['nombre']); ?></h1>
            <p>Bienvenido a tu perfil en el Consultorio Dental</p>
        </div>
    </div>

    <div class="container profile-content">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="profile-sidebar">
                    <h2 class="h4 mb-3">Información Personal</h2>
                    <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']); ?></p>
                    <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']); ?></p>
                    <p><strong>Fecha de Nacimiento:</strong> <?= htmlspecialchars($usuario['fecha_nacimiento']); ?></p>
                    <p><strong>Dirección:</strong> <?= htmlspecialchars($usuario['direccion']); ?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="profile-main">
                    <div class="profile-section">
                        <h2 class="h4 mb-3">Historial Médico</h2>
                        <ul class="medical-history">
                            <?php while ($row = $historial_medico->fetch_assoc()): ?>
                                <li>Diagnóstico: <?= htmlspecialchars($row['diagnostico']); ?> <br>
                                    Tratamiento: <?= htmlspecialchars($row['tratamiento']); ?> <br>
                                    Fecha: <?= htmlspecialchars($row['fecha']); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <ul class="list-unstyled d-flex justify-content-around location_icon">
                        <li class="text-center">
                            <a href="#"><i class="fa fa-map-marker-alt fa-2x" aria-hidden="true"></i><br>
                                <span>Ubicación</span></a>
                        </li>
                        <li class="text-center">
                            <a href="#"><i class="fa fa-phone fa-2x" aria-hidden="true"></i><br>
                                <span>+52 123 456 7890</span></a>
                        </li>
                        <li class="text-center">
                            <a href="#"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i><br>
                                <span>contacto@artesaludoral.com</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="../js/loginmod.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

