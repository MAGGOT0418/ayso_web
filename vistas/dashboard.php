<?php
session_start(); 


if (isset($_SESSION['id_usuario'])) {
    $rol = $_SESSION['id_rol']; 
    $nombre = $_SESSION['nombre'];
    $correo = $_SESSION['correo'];
    if ($rol == 3) {
        header("location: index.php");
    }
} else {
    $rol = null; 
    header("location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo - DentalCare</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="sidebar">
        <h2 class="text-center mb-4">AYSO Admin</h2>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendario.php"><i class="fas fa-calendar-alt"></i> Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="resumen_financiero.php"><i class="fas fa-user-md"></i> Finanzas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registro_pacientes.php"><i class="fas fa-users"></i> Pacientes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="inventario.php"><i class="fas fa-clipboard-list"></i> Inventario / Servicios</a>
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
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Citas Hoy</h5>
                    </div>
                    <div class="card-body">
                        <h2 id="totalCitas" class="card-text">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tratamientos Pendientes</h5>
                    </div>
                    <div class="card-body">
                        <h2 id="totalcitaspendientes" class="card-text">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pacientes Totales</h5>
                    </div>
                    <div class="card-body">
                        <h2 id="totalusuarios" class="card-text">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ingresos del Mes</h5>
                    </div>
                    <div class="card-body">
                        <h2 class="card-text">$25,000</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Próximas Citas</h5>
                    </div>
                    <div class="card-body">
                        <table id="citasprox" class="table table-light">
                            <thead class="thead-light">
                                <tr>

                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Historial Médico</h5>
                    </div>
                    <div class="card-body">
                        <table id="historialMedicoTable" class="table table-light">
                            <thead class="thead-light">
                                <tr>

                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '../ajax/historial_medico.php?op=listarHistorialMedico',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#historialMedicoTable tbody').empty();

                    if (response.length > 0) {
                        response.forEach(function(historial) {
                            const row = `
                        <tr>
                            <td>${historial.diagnostico}</td>
                            <td>${historial.tratamiento}</td>
                            <td>${historial.fecha}</td>
                        </tr>
                    `;
                            $('#historialMedicoTable tbody').append(row);
                        });
                    } else {
                        $('#historialMedicoTable tbody').html('<tr><td colspan="3">No se encontraron registros de historial médico</td></tr>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar el historial médico:', error);
                    $('#historialMedicoTable tbody').html('<tr><td colspan="3">Error al cargar los datos</td></tr>');
                }
            });
        });

        $(document).ready(function() {
            $.ajax({
                url: '../ajax/agenda.php?op=listarProximas',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#citasprox tbody').empty();

                    if (response.length > 0) {
                        response.forEach(function(cita) {
                            const row = `
                        <tr>
                            <td>${cita.title}</td>
                            <td>${cita.class}</td>
                            <td>${cita.inicio_normal}</td>
                        </tr>
                    `;
                            $('#citasprox tbody').append(row);
                        });
                    } else {
                        $('#citasprox tbody').html('<tr><td colspan="3">No hay citas programadas para hoy</td></tr>');
                    }
                },
                error: function(error) {
                    console.error('Error al cargar las citas:', error);
                },
            });
        });

        $(document).ready(function() {

            $.ajax({
                url: '../ajax/agenda.php?op=contarHoy',
                type: 'GET',
                dataType: 'json',
                success: function(response) {

                    if (response.total_citas !== undefined) {
                        $('#totalCitas').text(response.total_citas);
                    } else {
                        console.error('Respuesta inesperada:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });

        $(document).ready(function() {

            $.ajax({
                url: '../ajax/usuarios.php?op=listar',
                type: 'GET',
                dataType: 'json',
                success: function(response) {

                    if (response.total_usuarios !== undefined) {
                        $('#totalusuarios').text(response.total_usuarios);
                    } else {
                        console.error('Respuesta inesperada:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });


        $(document).ready(function() {

            $.ajax({
                url: '../ajax/cita.php?op=citaspendientes',
                type: 'GET',
                dataType: 'json',
                success: function(response) {

                    if (response.total_citas_pendientes !== undefined) {
                        $('#totalcitaspendientes').text(response.total_citas_pendientes);
                    } else {
                        console.error('Respuesta inesperada:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>