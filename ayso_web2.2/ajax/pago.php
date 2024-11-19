<?php

require_once "../modelos/Pago.php";

$pago = new Pago();

// Recuperamos los valores enviados por POST
$idCita = isset($_POST["idCita"]) ? limpiarCadena($_POST["idCita"]) : "";
$monto = isset($_POST["monto"]) ? limpiarCadena($_POST["monto"]) : "";
$metodoPago = isset($_POST["metodoPago"]) ? limpiarCadena($_POST["metodoPago"]) : "";
$fechaPago = isset($_POST["fechaPago"]) ? limpiarCadena($_POST["fechaPago"]) : "";
$idPaciente = isset($_POST["idPaciente"]) ? limpiarCadena($_POST["idPaciente"]) : "";

switch ($_GET["op"]) {
    case 'registrarPago':
        $rspta = $pago->registrarPago($idCita, $monto, $metodoPago, $fechaPago);
        echo $rspta ? "Pago registrado" : "No se pudo registrar el pago";
        break;

    case 'listarPagosPorPaciente':
        $rspta = $pago->listarPagosPorPaciente($idPaciente);
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id_pago,
                "1" => $reg->id_cita,
                "2" => $reg->monto,
                "3" => $reg->metodo_pago,
                "4" => $reg->fecha_pago
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

    case 'listarPagos':
        $rspta = $pago->listarPagos();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id_pago,
                "1" => $reg->id_cita,
                "2" => $reg->monto,
                "3" => $reg->metodo_pago,
                "4" => $reg->fecha_pago
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
