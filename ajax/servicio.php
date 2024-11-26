<?php
require_once "../modelos/Servicio.php";
$servicio = new Servicio();

$id_servicio = isset($_POST["id_servicio"]) ? limpiarCadena($_POST["id_servicio"]) : "";
$nombre_servicio = isset($_POST["nombre_servicio"]) ? limpiarCadena($_POST["nombre_servicio"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$precio = isset($_POST["precio"]) ? limpiarCadena($_POST["precio"]) : "";

switch ($_GET["op"]) {
    case 'agregarServicio':
        $rspta = $servicio->agregarServicio($nombre_servicio, $descripcion, $precio);
        echo json_encode(['status' => $rspta ? 'success' : 'error', 'message' => $rspta ? 'Servicio agregado correctamente.' : 'No se pudo agregar el servicio']);
        break;
    case 'actualizarServicio':
        $rspta = $servicio->actualizarServicio($id_servicio, $nombre_servicio, $descripcion, $precio);
        echo json_encode(['status' => $rspta ? 'success' : 'error', 'message' => $rspta ? 'Servicio actualizado correctamente.' : 'No se pudo actualizar el servicio']);
        break;
    case 'listarServicios':
        $rspta = $servicio->listarServicios();
        $data = array();
        if ($rspta->num_rows > 0) {
            while ($row = $rspta->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['nombre_servicio'] . "</td>
                        <td>" . $row['descripcion'] . "</td>
                        <td>" . $row['precio'] . "</td>
                        <td>
                            <button class='btn btn-info btn-sm' onclick=\"mostrarActualizarServicios({$row['id_servicio']})\">Actualizar</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay servicios disponibles</td></tr>";
        }
        break;
    case 'eliminarServicio':
        $rspta = $servicio->eliminarServicio($id_servicio);
        echo json_encode(['status' => $rspta ? 'success' : 'error', 'message' => $rspta ? 'Servicio eliminado correctamente.' : 'Error al eliminar el servicio']);
        break;
    case 'obtenerServicio':
        $id_servicio = isset($_POST['id_servicio']) ? limpiarCadena($_POST['id_servicio']) : null;
        if ($id_servicio) {
            $rspta = $servicio->obtenerServicio($id_servicio);
            echo json_encode($rspta);
        } else {
            echo json_encode(['error' => 'ID de servicio no proporcionado']);
        }
        break;
}
?>
