<?php

require_once "../modelos/Servicio.php";

$servicio = new Servicio();

// Recuperamos los valores enviados por POST
$idServicio = isset($_POST["idServicio"]) ? limpiarCadena($_POST["idServicio"]) : "";
$nombreServicio = isset($_POST["nombreServicio"]) ? limpiarCadena($_POST["nombreServicio"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$precio = isset($_POST["precio"]) ? limpiarCadena($_POST["precio"]) : "";

switch ($_GET["op"]) {
    case 'agregarServicio':
        $rspta = $servicio->agregarServicio($nombreServicio, $descripcion, $precio);
        echo $rspta ? "Servicio agregado" : "No se pudo agregar el servicio";
        break;

    case 'actualizarServicio':
        $rspta = $servicio->actualizarServicio($idServicio, $nombreServicio, $descripcion, $precio);
        echo $rspta ? "Servicio actualizado" : "No se pudo actualizar el servicio";
        break;

    case 'listarServicios':
        $rspta = $servicio->listarServicios();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id_servicio,
                "1" => $reg->nombre_servicio,
                "2" => $reg->descripcion,
                "3" => $reg->precio,
                "4" => '<button class="btn btn-warning" onclick="mostrar(' . $reg->id_servicio . ')">Editar</button>'
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
