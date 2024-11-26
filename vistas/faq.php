<?php 
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id_usuario'])) {
    $rol = $_SESSION['id_rol']; // Obtener el rol del usuario
    $nombre = $_SESSION['nombre'];
    $correo = $_SESSION['correo'];
} else {
    $rol = null; // No está logueado
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Dental</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/faq.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
                    <a class="nav-link" href="registrar_cita.php">Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="perfil.php">Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="faq.php">FAQ</a>
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
    <!-- Contenido FAQ -->
    <div class="dental-faq-container">
        <svg class="dental-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM13 17H11V15H13V17ZM13 13H11V7H13V13Z"
                fill="#0077be" />
        </svg>
        <h2 class="dental-faq-title">Preguntas Frecuentes</h2>
        <div class="dental-faq-item">
            <button class="dental-faq-question">¿Cuál es el horario de atención de la clínica dental?</button>
            <div class="dental-faq-answer">
                Nuestro horario de atención es de lunes a viernes, de 9:00 am a 7:00 pm, y los sábados de 9:00 am a 2:00
                pm.
            </div>
        </div>
        <div class="dental-faq-item">
            <button class="dental-faq-question">¿Aceptan seguros dentales?</button>
            <div class="dental-faq-answer">
                Sí, aceptamos una amplia variedad de seguros dentales. Contáctenos para verificar su seguro específico.
            </div>
        </div>
        <div class="dental-faq-item">
            <button class="dental-faq-question">¿Cuánto tiempo dura una limpieza dental?</button>
            <div class="dental-faq-answer">
                Una limpieza dental estándar generalmente dura entre 30 y 60 minutos.
            </div>
        </div>

        <div class="dental-faq-item">
            <button class="dental-faq-question">¿Ofrecen servicios de blanqueamiento dental?</button>
            <div class="dental-faq-answer">
                Sí, ofrecemos servicios profesionales de blanqueamiento dental.
            </div>
        </div>

        <div class="dental-faq-item">
            <button class="dental-faq-question">¿Qué debo hacer en caso de una emergencia dental?</button>
            <div class="dental-faq-answer">
                En caso de emergencia dental, llámenos inmediatamente. Tenemos horarios reservados para emergencias.
            </div>
        </div>
    </div>

    <!--footer-->
    <footer>
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <ul class="list-unstyled d-flex justify-content-around location_icon">
                            <li class="text-center">
                                <a href="#"><i class="fa fa-map-marker-alt fa-2x" aria-hidden="true"></i><br>
                                    <span>Location</span></a>
                            </li>
                            <li class="text-center">
                                <a href="#"><i class="fa fa-phone fa-2x" aria-hidden="true"></i><br>
                                    <span>+01 1234567890</span></a>
                            </li>
                            <li class="text-center">
                                <a href="#"><i class="fa fa-envelope fa-2x" aria-hidden="true"></i><br>
                                    <span>demo@gmail.com</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="../js/loginmod.js"></script>
    <!-- jQuery y Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Script para funcionalidad de las preguntas -->
    <script>
        document.querySelectorAll('.dental-faq-question').forEach(button => {
            button.addEventListener('click', function () {
                this.classList.toggle('active');
                const answer = this.nextElementSibling;
                if (answer.style.display === "block") {
                    answer.style.display = "none";
                } else {
                    document.querySelectorAll('.dental-faq-answer').forEach(item => {
                        item.style.display = "none";
                    });
                    document.querySelectorAll('.dental-faq-question').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    answer.style.display = "block";
                    this.classList.add('active');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>