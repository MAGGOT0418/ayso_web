<?php
session_start();
include '../config/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php");
    exit;
}

$rol = $_SESSION['id_rol'] ?? null;
$nombre = $_SESSION['nombre'] ?? 'Invitado';
$correo = $_SESSION['correo'] ?? '';

if (!isset($conexion)) {
    die("Error: No se pudo establecer la conexión con la base de datos.");
}

// Procesar el formulario de pago
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_pago'])) {
    $id_cita = $_POST['id_cita'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];
    
    $sql_insert = "INSERT INTO pagos (id_cita, monto, metodo_pago) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("ids", $id_cita, $monto, $metodo_pago);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Pago registrado con éxito.";
    } else {
        $_SESSION['mensaje'] = "Error al registrar el pago: " . $conexion->error;
    }
    $stmt->close();
    
    // Redirigir para evitar reenvíos del formulario
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Mostrar mensaje si existe y luego eliminarlo
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}

// Consulta para obtener los pagos
$sql = "SELECT p.id_pago, u.nombre AS nombre_paciente, s.nombre_servicio AS nombre_servicio, 
               p.monto, p.metodo_pago, p.fecha_pago, c.fecha_cita
        FROM pagos p
        JOIN citas c ON p.id_cita = c.id_cita
        JOIN usuarios u ON c.id_paciente = u.id_usuario
        JOIN servicios s ON c.id_servicio = s.id_servicio";

$result = ejecutarConsulta($sql);

if (!$result) {
    die("Error en la consulta: " . $conexion->error);
}

// Preparar datos para las gráficas
$servicios = [];
$montos = [];
$metodosPago = ['Efectivo' => 0, 'Tarjeta' => 0, 'Transferencia' => 0];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!in_array($row['nombre_servicio'], $servicios)) {
            $servicios[] = $row['nombre_servicio'];
            $montos[] = $row['monto'];
        } else {
            $index = array_search($row['nombre_servicio'], $servicios);
            $montos[$index] += $row['monto'];
        }
        
        if (isset($metodosPago[$row['metodo_pago']])) {
            $metodosPago[$row['metodo_pago']] += $row['monto'];
        }
    }
    mysqli_data_seek($result, 0);
}

// Consulta para obtener la lista de citas
$sql_citas = "SELECT c.id_cita, CONCAT(c.fecha_cita, ' - ', u.nombre) AS info_cita 
              FROM citas c 
              JOIN usuarios u ON c.id_paciente = u.id_usuario";
$result_citas = ejecutarConsulta($sql_citas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Financiero</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .chart-container {
            height: 300px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2 class="text-center mb-4">AYSO Admin</h2>
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link " href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendario.php"><i class="fas fa-calendar-alt"></i> Citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="resumen_financiero.php"><i class="fas fa-user-md"></i> Finanzas</a>
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Resumen Financiero</h1>
                        <button id="btnRegistrarPago" class="btn btn-primary">Registrar Pago</button>
                    </div>
                </div>

                <?php
                if (isset($mensaje)) {
                    echo "<div class='alert alert-info'>" . $mensaje . "</div>";
                }
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-container">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Pago</th>
                                        <th>Paciente</th>
                                        <th>Servicio</th>
                                        <th>Monto</th>
                                        <th>Método de Pago</th>
                                        <th>Fecha de Pago</th>
                                        <th>Fecha de Cita</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["id_pago"] . "</td>";
                                            echo "<td>" . $row["nombre_paciente"] . "</td>";
                                            echo "<td>" . $row["nombre_servicio"] . "</td>";
                                            echo "<td>$" . number_format($row["monto"], 2) . "</td>";
                                            echo "<td>" . $row["metodo_pago"] . "</td>";
                                            echo "<td>" . $row["fecha_pago"] . "</td>";
                                            echo "<td>" . $row["fecha_cita"] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No se encontraron registros</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Ingresos por Servicio</h3>
                            </div>
                            <div class="panel-body">
                                <div class="chart-container">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Métodos de Pago</h3>
                            </div>
                            <div class="panel-body">
                                <div class="chart-container">
                                    <canvas id="pieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistrarPago" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Registrar Pago</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="id_cita">Cita</label>
                            <select class="form-control" id="id_cita" name="id_cita" required>
                                <option value="">Seleccione una cita</option>
                                <?php
                                if ($result_citas->num_rows > 0) {
                                    while ($row = $result_citas->fetch_assoc()) {
                                        echo "<option value='" . $row['id_cita'] . "'>" . $row['info_cita'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="metodo_pago">Método de Pago</label>
                            <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>
                        <button type="submit" name="registrar_pago" class="btn btn-primary">Registrar Pago</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gráfico de barras
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($servicios); ?>,
                datasets: [{
                    label: 'Monto ($)',
                    data: <?php echo json_encode($montos); ?>,
                    backgroundColor: '#4e79a7',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Gráfico circular
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Efectivo', 'Tarjeta', 'Transferencia'],
                datasets: [{
                    data: <?php echo json_encode(array_values($metodosPago)); ?>,
                    backgroundColor: ['#f28e2c', '#e15759', '#76b7b2'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        $(document).ready(function(){
            $("#btnRegistrarPago").click(function(){
                $("#modalRegistrarPago").modal('show');
            });
        });
    </script>
</body>
</html>