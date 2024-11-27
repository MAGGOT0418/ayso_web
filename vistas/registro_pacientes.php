<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['id_usuario'])) {
    $rol = $_SESSION['id_rol']; // Obtener el rol del usuario
    $nombre = $_SESSION['nombre'];
    $correo = $_SESSION['correo'];
    if ($rol == 3) {
        header("location: index.php");
    }
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
    <title>Registrar Paciente - Historial Médico</title>
    <link rel="stylesheet" href="../assets/css/historial.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="sidebar">
        <h2 class="text-center mb-4">ASYO Admin</h2>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendario.php"><i class="fas fa-calendar-alt"></i> Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-user-md"></i> Doctores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="registro_pacientes.php"><i class="fas fa-users"></i> Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inventario.php"><i class="fas fa-clipboard-list"></i> Inventario /
                        Servicios</a>
                </li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <a href="../php/logout.php" class="nav-link text-danger logout">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>
    <div class="main-content">
        <h1 class="mb-4">Dashboard</h1>
        <div class="row mt-6">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Usuarios</h5>
                    </div>
                    <div class="card-body">
                        <table id="usuarios" class="table table-light">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Dirección</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se agregarán las filas dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2>Registrar Paciente - Historial Médico</h2>
                    <form action="registro_paciente.php" method="post">
                        <!-- Formulario de registro de paciente -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '../ajax/usuarios.php?op=listarUsuarios',
                type: 'GET',
                dataType: 'html',
                success: function (response) {
                    $('#usuarios tbody').empty();
                    if (response.trim().length > 0) {
                        $('#usuarios tbody').html(response);
                    } else {
                        $('#usuarios tbody').html('<tr><td colspan="5">No se encontraron usuarios</td></tr>');
                    }
                },
                error: function (error) {
                    console.error('Error al cargar los usuarios:', error);
                },
            });
        });
    </script>
</body>

</html>