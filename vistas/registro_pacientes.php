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
    <link rel="stylesheet" href="../assets/css/registro_pacientes.css">
</head>

<body>
    <div class="sidebar">
        <h2 class="text-center mb-4">AYSO Admin</h2>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calendario.php"><i class="fas fa-calendar-alt"></i> Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="resumen_financiero.php"><i class="fas fa-user-md"></i> Finanzas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="registro_pacientes.php"><i class="fas fa-users"></i> Pacientes</a>
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
        <div class="row mt-6">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Usuarios</h5>
                    </div>
                    <div class="card-body">
                        <table id="usuarios" class="table table-light ">
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistrarPaciente" tabindex="-1" role="dialog" aria-labelledby="modalRegistrarPacienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalRegistrarPacienteLabel">Registrar Paciente - Historial Médico</h4>
                </div>
                <div class="modal-body">
                    <form id="formRegistrarPaciente" method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre completo:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="motivo_consulta" class="form-label">Motivo de la consulta:</label>
                            <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">¿Está bajo tratamiento médico actualmente?</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="tratamiento_medico" id="tratamiento_si" value="si" required> Sí
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="tratamiento_medico" id="tratamiento_no" value="no" required> No
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="medicamentos" class="form-label">Medicamentos que toma actualmente:</label>
                            <textarea class="form-control" id="medicamentos" name="medicamentos" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">¿Es alérgico a algún medicamento?</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="alergias" id="alergias_si" value="si" required> Sí
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="alergias" id="alergias_no" value="no" required> No
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alergias_detalle" class="form-label">Si es alérgico, especifique:</label>
                            <input type="text" class="form-control" id="alergias_detalle" name="alergias_detalle">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Condiciones médicas:</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="hipertension" name="condiciones[]" value="hipertension"> Hipertensión
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="diabetes" name="condiciones[]" value="diabetes"> Diabetes
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="problemas_cardiacos" name="condiciones[]" value="problemas_cardiacos"> Problemas cardíacos
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="otros" name="condiciones[]" value="otros"> Otros
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="otras_condiciones" class="form-label">Especifique otras condiciones médicas:</label>
                            <textarea class="form-control" id="otras_condiciones" name="otras_condiciones" rows="3"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Registrar Paciente</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        function mostrarFormularioRegistro() {
            $('#modalRegistrarPaciente').modal('show'); 
        }
        $(document).ready(function() {
            $('#formRegistrarPaciente').submit(function(e) {
                e.preventDefault(); 

                var formData = $(this).serialize();

                $.ajax({
                    url: '../ajax/registropaciente.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        alert('Paciente registrado correctamente');
                        $('#modalRegistrarPaciente').modal('hide'); 
                    },
                    error: function() {
                        alert('Hubo un error al registrar el paciente. Intenta de nuevo.');
                    }
                });
            });
        });

        $(document).ready(function() {
            $.ajax({
                url: '../ajax/usuarios.php?op=listarUsuarios',
                type: 'GET',
                dataType: 'html',
                success: function(response) {
                    $('#usuarios tbody').empty();
                    if (response.trim().length > 0) {
                        $('#usuarios tbody').html(response);
                    } else {
                        $('#usuarios tbody').html('<tr><td colspan="5">No se encontraron usuarios</td></tr>');
                    }
                },
                error: function(error) {
                    console.error('Error al cargar los usuarios:', error);
                },
            });
        });
    </script>
</body>

</html>