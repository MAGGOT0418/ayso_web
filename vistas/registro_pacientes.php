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
    <style>
        /* Estilos para el modal */
        .modal-content {
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .5);
        }

        .modal-header {
            background: #3a7bd5;
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 15px;
        }

        .modal-title {
            font-weight: bold;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        /* Estilos para el formulario */
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px 12px;
            height: auto;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(3, 202, 252, 0.2);
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        /* Estilos para radio buttons y checkboxes */
        .radio label,
        .checkbox label {
            padding-left: 25px;
            position: relative;
        }

        .radio input[type="radio"],
        .checkbox input[type="checkbox"] {
            margin-left: -25px;
            margin-top: 4px;
        }

        /* Estilos para el botón de submit */
        .btn-primary {

            border: none;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-perfil);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Estilos para los grupos de campos */
        .mb-3 {
            margin-bottom: 20px;
        }

        /* Estilos para textarea */
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Estilos para el botón de cerrar */
        .modal-header .close {
            margin-top: -2px;
            font-size: 24px;
        }

        /* Estilos para el modal grande */
        .modal-lg {
            width: 80%;
            max-width: 1000px;
        }

        /* Estilos para el cuerpo del modal */
        .modal-body {
            padding: 20px;
            background-color: #fff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal-lg {
                width: 95%;
                margin: 10px auto;
            }

            .row [class*="col-"] {
                margin-bottom: 15px;
            }
        }
    </style>
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
                                <!-- Aquí se agregarán las filas dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar el formulario -->
    <div class="modal fade" id="modalRegistrarPaciente" tabindex="-1" role="dialog" aria-labelledby="modalRegistrarPacienteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="modalRegistrarPacienteLabel">Registrar Paciente - Historial Médico</h4>
                </div>
                <div class="modal-body">
                    <!-- Formulario de registro paciente -->
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
        // Función para abrir el modal con el formulario
        function mostrarFormularioRegistro() {
            $('#modalRegistrarPaciente').modal('show'); // Usamos el método de Bootstrap 3 para mostrar el modal
        }
        $(document).ready(function() {
            // Manejar el envío del formulario con AJAX
            $('#formRegistrarPaciente').submit(function(e) {
                e.preventDefault(); // Evitar que el formulario se envíe de manera tradicional

                // Obtener los datos del formulario
                var formData = $(this).serialize();

                // Enviar los datos al servidor mediante AJAX
                $.ajax({
                    url: 'registropaciente.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Mostrar un mensaje de éxito o redirigir, según sea necesario
                        alert('Paciente registrado correctamente');
                        $('#modalRegistrarPaciente').modal('hide'); // Cerrar el modal
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