<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id_usuario'])) {
    $rol = $_SESSION['id_rol']; // Obtener el rol del usuario
    $nombre = $_SESSION['nombre'];
    $correo = $_SESSION['correo'];
} else {
    $rol = null; // No está logueado
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Dental - Registrar Cita</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="../assets/css/registrar_cita.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>

<body>
    <!-- Navbar -->
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
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="servicios.php">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="registrar_cita.php">Citas</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="faq.php">FAQ</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if (isset($_SESSION['id_usuario'])): ?>
                        <?php $initial = strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                        <div class="dropdown">
                            <button class="btn" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-flex align-items-center justify-content-center">
                                    <?= $initial ?>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item profile-item" href="perfil.php"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
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
    <div class="registrar-cita-container">
        <h2 class="text-center mb-4">Registrar Cita</h2>
        <form action="registrar_cita.php" method="post">
            <input type="hidden" name="id_paciente" value="<?php echo htmlspecialchars($id_paciente); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="calendar-container">
                        <div class="form-group">
                            <label for="fecha_cita">Fecha de la Cita:</label>
                            <input type="text" class="form-control" id="fecha_cita" name="fecha_cita" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-container">
                        <div class="form-group">
                            <label for="hora_cita">Hora de la Cita:</label>
                            <select name="hora_cita" id="hora_cita" class="form-control" required>
                                <option value="">Seleccione una hora</option>
                                <?php
                                $horas = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30"];
                                foreach ($horas as $hora) {
                                    echo "<option value='$hora'>$hora</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="servicio">Seleccione un servicio:</label>
                            <select name="id_servicio" id="servicio" class="form-control" required>
                                <option value="">Seleccione un servicio</option>
                                <option value="1">Tratamientos Periodontales</option>
                                <option value="2">Limpiezas</option>
                                <option value="3">Extracciones</option>
                                <option value="4">Regeneración de Encía</option>
                                <option value="5">Regeneración de Hueso</option>
                                <option value="6">Implantes Dentales</option>
                                <option value="7">Prótesis sobre Implantes Dentales</option>
                                <option value="8">Endodoncias</option>
                                <option value="9">Retiro de Caries</option>
                                <option value="10">Prótesis Dentales</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comentarios">Comentarios:</label>
                            <textarea class="form-control" id="comentarios" name="comentarios" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar Cita</button>
        </form>
    </div>
    <footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                <h5>Arte y Salud Oral</h5>
                <p class="mb-0">Cuidando tu sonrisa desde 2005</p>
            </div>
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="#" title="Ubicación">
                            <i class="fas fa-map-marker-alt footer-icon"></i>
                            <span class="d-none d-sm-inline">Calle Principal 123, Ciudad</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="tel:+011234567890" title="Teléfono">
                            <i class="fas fa-phone footer-icon"></i>
                            <span class="d-none d-sm-inline">+01 1234567890</span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="mailto:info@arteysaludoral.com" title="Email">
                            <i class="fas fa-envelope footer-icon"></i>
                            <span class="d-none d-sm-inline">info@arteysaludoral.com</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <div class="social-icons">
                    <a href="#" title="Facebook"><i class="fab fa-facebook footer-icon"></i></a>
                    <a href="#" title="Twitter"><i class="fab fa-twitter footer-icon"></i></a>
                    <a href="#" title="Instagram"><i class="fab fa-instagram footer-icon"></i></a>
                    <a href="#" title="LinkedIn"><i class="fab fa-linkedin footer-icon"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
    <script src="../js/loginmod.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#fecha_cita", {
                dateFormat: "Y-m-d",
                minDate: "today",
                inline: true,
                locale: "es",
                onChange: function (selectedDates, dateStr, instance) {
                    console.log(dateStr);
                }
            });
        });
    </script>
</body>
</html>