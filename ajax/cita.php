<?php

require_once "../modelos/Citas.php";

$citas = new Citas();

// Recuperamos los valores enviados por POST
$idCita = isset($_POST["idCita"]) ? limpiarCadena($_POST["idCita"]) : "";
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
        $rspta = $citas->eliminarCita($idCita);
        echo $rspta ? "Cita eliminada" : "No se pudo eliminar la cita";
        break;

    case 'cancelarCita':
        $rspta = $citas->cancelarCita($idCita);
        echo $rspta ? "Cita cancelada" : "No se pudo cancelar la cita";
        break;

    case 'actualizarEstadoCita':
        $rspta = $citas->actualizarEstadoCita($idCita, $estado);
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
}

?>