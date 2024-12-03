<?php

require_once "../modelos/Citas.php";

$citas = new Citas();

$id_cita = isset($_POST["id_cita"]) ? limpiarCadena($_POST["id_cita"]) : "";
$idPaciente = isset($_POST["idPaciente"]) ? limpiarCadena($_POST["idPaciente"]) : "";
$idServicio = isset($_POST["idServicio"]) ? limpiarCadena($_POST["idServicio"]) : "";
$fechaCita = isset($_POST["fechaCita"]) ? limpiarCadena($_POST["fechaCita"]) : "";
$comentarios = isset($_POST["comentarios"]) ? limpiarCadena($_POST["comentarios"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";

switch ($_GET["op"]) {
    case 'agendarCita':
        $rspta = $citas->agendarCita($idPaciente, $idServicio, $fechaCita, $comentarios);
        echo $rspta ? "Cita agendada" : "No se pudo agendar la cita";
        break;

    case 'eliminarCita':
        echo "que pedo";
        $rspta = $citas->eliminarCita1($id_cita);
        echo $rspta ? "Cita eliminada" : "No se pudo eliminar la cita";
        break;

    case 'cancelarCita':
        $rspta = $citas->cancelarCita($id_cita);
        echo $rspta ? "Cita cancelada" : "No se pudo cancelar la cita";
        break;

    case 'actualizarEstadoCita':
        $rspta = $citas->actualizarEstadoCita($id_cita, $estado);
        echo $rspta ? "Estado de cita actualizado" : "No se pudo actualizar el estado de la cita";
        break;

    case 'listar':
        $rspta = $citas->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg->id_cita . ')">Editar</button>',
                "1" => $reg->id_paciente,
                "2" => $reg->id_servicio,
                "3" => $reg->fecha_cita,
                "4" => $reg->estado,
                "5" => $reg->comentarios
            );
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'listarCitasPorPaciente':
        $rspta = $citas->listarCitasPorPaciente($idPaciente);
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id_cita,
                "1" => $reg->fecha_cita,
                "2" => $reg->estado,
                "3" => $reg->comentarios
            );
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'listarCitasPendientes':
        $rspta = $citas->listarCitasPendientes();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id_cita,
                "1" => $reg->id_paciente,
                "2" => $reg->fecha_cita,
                "3" => $reg->comentarios
            );
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'citasHoy':
        $totalCitas = $citas->citasHoy(); 
        echo json_encode(['total_citas' => $totalCitas]);

        break;
    
    case 'citaspendientes':
        $totalCitasPendientes = $citas->contarCitasPendientes();
        echo json_encode(['total_citas_pendientes' => $totalCitasPendientes]);

        break;

    case 'citasproximas':
        $rspta = $citas->resumenCitas();
        $data = array();
        if ($rspta->num_rows > 0) {
            while ($row = $rspta->fetch_assoc()) {
                echo "<tr>
                            <td>" . $row['nombre'] . "</td>
                            <td>" . $row['nombre_servicio'] . "</td>
                            <td>" . $row['fecha_cita'] . " </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No hay productos</td></tr>";
        }
            
}

?>