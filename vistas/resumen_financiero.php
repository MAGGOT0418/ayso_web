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

// Modificamos la consulta para usar la tabla usuario en lugar de pacientes
$sql = "SELECT p.id_pago, u.nombre AS nombre_paciente, s.nombre_servicio AS nombre_servicio, 
               p.monto, p.metodo_pago, p.fecha_pago, c.fecha_cita
        FROM pagos p
        JOIN citas c ON p.id_cita = c.id_cita
        JOIN usuarios u ON c.id_paciente = u.id_usuario
        JOIN servicios s ON c.id_servicio = s.id_servicio";
         // Asumimos que el rol 3 es para pacientes

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_pago'])) {
    $id_cita = $_POST['id_cita'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];
    
    $sql_insert = "INSERT INTO pagos (id_cita, monto, metodo_pago) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("ids", $id_cita, $monto, $metodo_pago);
    
    if ($stmt->execute()) {
        $mensaje = "Pago registrado con éxito.";
    } else {
        $mensaje = "Error al registrar el pago: " . $conexion->error;
    }
    $stmt->close();
}

// Modificamos la consulta para obtener la lista de citas
$sql_citas = "SELECT c.id_cita, CONCAT(c.fecha_cita, ' - ', u.nombre) AS info_cita 
              FROM citas c 
              JOIN usuarios u ON c.id_paciente = u.id_usuario 
              WHERE u.id_rol = 3";
$result_citas = ejecutarConsulta($sql_citas);


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen Financiero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        :root {
            --primary-color: #03cafc;
            --primary-dark: #3a7bd5;
            --secondary-color: #f8f9fa;
            --text-color: #333;
            --primary-perfil: #592649;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
        }

        .wrapper {
            display: flex;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary-color), var(--primary-perfil));
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            padding-top: 20px;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex-grow: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
        }

        .chart-container {
            height: 300px;
            margin-bottom: 20px;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* ... (Resto de los estilos CSS proporcionados) ... */
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <h2 class="text-center mb-4">ASYO Admin</h2>
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendario.php"><i class="fas fa-calendar-alt"></i> Citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user-md"></i> Doctores</a>
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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Resumen Financiero</h1>
                    <button id="btnRegistrarPago" class="btn btn-primary">Registrar Pago</button>
                </div>

                <?php
                if (isset($mensaje)) {
                    echo "<div class='alert alert-info'>" . $mensaje . "</div>";
                }
                ?>

                <div class="table-responsive mb-4">
                    <table class="table table-striped table-sm">
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Ingresos por Servicio</h5>
                                <div class="chart-container">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Métodos de Pago</h5>
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
    <div id="modalRegistrarPago" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Registrar Pago</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="id_cita" class="form-label">Cita</label>
                    <select class="form-select" id="id_cita" name="id_cita" required>
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
                <div class="mb-3">
                    <label for="monto" class="form-label">Monto</label>
                    <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="metodo_pago" class="form-label">Método de Pago</label>
                    <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="Transferencia">Transferencia</option>
                    </select>
                </div>
                <button type="submit" name="registrar_pago" class="btn btn-primary">Registrar Pago</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    y: {
                        beginAtZero: true
                    }
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
        var modal = document.getElementById("modalRegistrarPago");
        var btn = document.getElementById("btnRegistrarPago");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
