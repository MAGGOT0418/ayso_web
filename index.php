<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id_usuario'])) {
    $rol = $_SESSION['id_rol']; // Obtener el rol del usuario
    $nombre = $_SESSION['nombre'];
    $correo = $_SESSION['correo'];
    if ($rol == 3 ) {
        header("location: vistas/index.php");
    } elseif ($rol == 1) {
        header("location: vistas/dashboard.php");
    }
} else {
    $rol = null; // No está logueado
    //header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Dental</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/footer.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php" style="color: #fff;">
                <img src="assets/images/LogoC.png" alt="Logo" style="width: 140px; height: 70px; margin-left: -30px;">
                Arte y salud oral
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    
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
                                <li><a class="dropdown-item profile-item" href="perfil.php"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                                <li><a class="dropdown-item logout-item" href="php/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
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
    <!-- Carousel -->
    <div id="dentalCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#dentalCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#dentalCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#dentalCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/freepik-export-20241127212111IXD0.jpeg" class="d-block w-100" alt="Sonrisa brillante">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Sonrisas Brillantes</h5>
                    <p>Transformamos tu sonrisa con nuestros tratamientos de vanguardia.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/dental-chair-other-accesorries-used-by-dentist-empty-cabinet-stomatology-cabinet-with-nobody-it-orange-equipment-oral-treatment.jpg" class="d-block w-100" alt="Equipo dental">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Equipo Profesional</h5>
                    <p>Nuestro equipo de expertos está aquí para cuidar de tu salud dental.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/dentist.jpeg" class="d-block w-100" alt="Tecnología dental">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Tecnología Avanzada</h5>
                    <p>Utilizamos la última tecnología para ofrecerte el mejor cuidado dental.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#dentalCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#dentalCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <!-- Doctor Profiles -->
    <div class="Perfil">
        <section class="doctor-profiles">
            <div class="container">
                <h2 class="text-center mb-5">Especialistas</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="doctor-card">
                            <img src="assets/images/freepik-export-20241127210432GbLV.jpeg" alt="Dr. Juan Pérez" class="doctor-image">
                            <div class="doctor-info">
                                <h3 class="doctor-name">Dr. Juan Pérez</h3>
                                <p class="doctor-specialty">Odontólogo General</p>
                                <p class="doctor-bio">El Dr. Juan Pérez cuenta con más de 15 años de experiencia en odontología general. Se especializa en tratamientos preventivos y estética dental. Su enfoque se centra en proporcionar atención integral y personalizada a cada paciente, asegurando sonrisas saludables y radiantes.</p>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="doctor-card">
                            <img src="assets/images/freepik-export-20241127210231IJaB.jpeg" alt="Dra. María González" class="doctor-image">
                            <div class="doctor-info">
                                <h3 class="doctor-name">Dra. María González</h3>
                                <p class="doctor-specialty">Ortodoncista</p>
                                <p class="doctor-bio">La Dra. María González es experta en ortodoncia y tratamientos de alineación dental. Con una trayectoria de 10 años en el campo, su enfoque se centra en crear sonrisas perfectas y saludables. Utiliza las técnicas más avanzadas para garantizar resultados óptimos y una experiencia cómoda para sus pacientes.</p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Contact Form and Map -->
    <div id="contact" class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form id="request" class="main_form" action="send_email.php" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Contáctanos</h3>
                            </div>
                            <div class="col-md-12">
                                <input class="contactus" placeholder="Nombre" type="text" name="Name" required>
                            </div>
                            <div class="col-md-12">
                                <input class="contactus" placeholder="Teléfono" type="text" name="Phone_Number" required>
                            </div>
                            <div class="col-md-12">
                                <input class="contactus" placeholder="E-mail" type="email" name="Email" required>
                            </div>
                            <div class="col-md-12">
                                <textarea class="contactusmess" placeholder="Mensaje" name="Message" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <button class="send_btn" type="submit">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.3622532245317!2d-104.6667116894344!3d24.018287578398834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x869bc93080c10a1d%3A0xda7c56aa8fcf0655!2sArte%20y%20Salud%20Oral!5e0!3m2!1ses-419!2smx!4v1727883693543!5m2!1ses-419!2smx" width="100%" height="450" style="border:0;" allowfullscreen="allowfullscreen" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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
    <!-- Aquí estará el contenido del modal -->
    <div id="loginModal" class="modal"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/loginmod.js"></script>
</body>

</html>