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
    <title>Servicios</title>
    <link rel="stylesheet" href="../assets/css/services.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
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
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="servicios.php">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registrar_cita.php">Citas</a>
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
    <div class="services-page">
        <section>
            <h1>Nuestros Servicios</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <h2>Tratamientos Periodontales</h2>
                        <img src="https://drstellagonzalez.com/wp-content/uploads/2022/08/Limpiezas-de-mantenimiento-periodontal.webp"
                            alt="Tratamientos Periodontales">
                        <p>Se enfocan en la prevención, diagnóstico y tratamiento de enfermedades de las encías. Estos
                            tratamientos ayudan a mantener la salud de los tejidos que rodean y soportan los dientes,
                            evitando problemas como la gingivitis y la periodontitis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Limpezas</h2>
                        <img src="https://www.implantadental.es/images/noticias/1461139647Limpieza-dental-madrid.jpg"
                            alt="Limpezas">
                        <p>Consisten en la eliminación de placa y sarro de los dientes para prevenir caries y
                            enfermedades periodontales. Las limpiezas dentales profesionales son fundamentales para
                            mantener una buena higiene bucal y frescura en la boca.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Extracciones</h2>
                        <img src="https://clinicajuliansaiz.com/wp-content/uploads/2021/08/exodoncia-clinica-dental-julian-saiz-01.jpg"
                            alt="Extracciones">
                        <p>Este procedimiento se realiza para remover dientes que están dañados, infectados o que no
                            pueden ser reparados. Las extracciones también pueden ser necesarias para preparar la boca
                            para ortodoncia o para facilitar otros tratamientos dentales.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Regeneración de Encía</h2>
                        <img src="https://pypclinic.com/wp-content/uploads/2021/09/canva-photo-editor-23.png"
                            alt="Regeneración de Encía">
                        <p>Involucra técnicas para restaurar la salud de las encías y cerrar bolsas periodontales. Este
                            tratamiento puede incluir injertos de encía para cubrir raíces expuestas y prevenir la
                            pérdida de dientes.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Regeneración de Hueso</h2>
                        <img src="https://www.clinicacemtro.com/wp-content/uploads/2020/02/regeneracion_osea_en_implantes_dentales.jpg"
                            alt="Regeneración de Hueso">
                        <p>Se utiliza para restaurar el hueso perdido alrededor de los dientes. A menudo, se realiza en
                            combinación con tratamientos periodontales para asegurar que los dientes tengan un soporte
                            adecuado.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Implantes Dentales</h2>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSWu7c8ItbCN5Dg8qzK2jHp_rHAtRjy8Zt5QQ&s"
                            alt="Implantes Dentales">
                        <p>Son soluciones permanentes para reemplazar dientes perdidos. Los implantes se colocan
                            quirúrgicamente en el hueso maxilar y actúan como raíces artificiales, proporcionando una
                            base sólida para coronas, puentes o dentaduras.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Prótesis sobre Implantes Dentales</h2>
                        <img src="https://www.sanderslaser.com/wp-content/uploads/2012/07/10-protesis_sobre_implantes.jpg"
                            alt="Prótesis sobre Implantes Dentales">
                        <p>Son estructuras dentales que se colocan sobre los implantes para restaurar la función y la
                            estética dental. Estas prótesis pueden ser fijas o removibles, según las necesidades del
                            paciente.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Endodoncias</h2>
                        <img src="https://grados.uemc.es/hs-fs/hubfs/Blog/Im%C3%A1genes/render-tratamiento-endodoncia.jpg?width=1000&height=699&name=render-tratamiento-endodoncia.jpg"
                            alt="Endodoncias">
                        <p>También conocido como tratamiento de conducto, se realiza para tratar la pulpa dental
                            inflamada o infectada. El procedimiento implica la limpieza y desinfección del interior del
                            diente, seguido de su sellado.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Retiro de Caries</h2>
                        <img src="https://www.clinicalorenzo.com/wp-content/uploads/2019/09/caries-dentales-clinica-lorenzo-zaragoza.jpg"
                            alt="Retiro de Caries">
                        <p>Este tratamiento implica la eliminación de la caries dental y la restauración del diente
                            afectado con materiales adecuados. Es fundamental para evitar que la caries progrese y cause
                            más daño.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <h2>Prótesis Dentales</h2>
                        <img src="https://www.fuentedelangel.com/wp-content/uploads/2022/11/protesis-dentales-fijas.jpg"
                            alt="Prótesis Dentales">
                        <p>Son dispositivos diseñados para reemplazar dientes perdidos. Las prótesis pueden ser
                            parciales o completas y están diseñadas para mejorar la función masticatoria y la estética
                            facial.</p>
                    </div>
                </div>
            </div>
        </section>
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
    </footer>
    <script src="../js/loginmod.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>