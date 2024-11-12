<?php

require_once "../modelos/Notificacion.php";

$notificacion = new Notificacion();

// Obtenemos los valores enviados por POST
$idUsuario = isset($_POST["idUsuario"]) ? limpiarCadena($_POST["idUsuario"]) : "";
$mensaje = isset($_POST["mensaje"]) ? limpiarCadena($_POST["mensaje"]) : "";

switch ($_GET["op"]) {
    case 'enviarNotificacion':
        $rspta = $notificacion->enviarNotificacion($idUsuario, $mensaje);
        echo $rspta ? "Notificación enviada" : "No se pudo enviar la notificación";
        break;

    case 'listarNotificaciones':
        $rspta = $notificacion->listarNotificaciones($idUsuario);
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id_notificacion,
                "1" => $reg->mensaje,
                "2" => $reg->fecha
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
