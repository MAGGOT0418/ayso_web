<?php 

require_once "../modelos/Citas.php";

$cita = new Citas();

$id_cita = isset($_POST["id_cita"]) ? limpiarCadena($_POST["id_cita"]) : "";
$id_paciente = isset($_POST["id_paciente"]) ? limpiarCadena($_POST["id_paciente"]) : "";
$id_servicio = isset($_POST["id_servicio"]) ? limpiarCadena($_POST["id_servicio"]) : "";
$fecha_cita = isset($_POST["fecha_cita"]) ? limpiarCadena($_POST["fecha_cita"]) : "";
$estado = isset($_POST["estado"]) ? limpiarCadena($_POST["estado"]) : "";
$comentarios = isset($_POST["comentarios"]) ? limpiarCadena($_POST["comentarios"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $cita->listar();
        $data = Array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ($reg->estado == 'pendiente') 
                    ? '<button class="btn btn-warning" onclick="mostrar('.$reg->id_cita.')"><i class="fa fa-pencil"></i></button>' .
                      ' <button class="btn btn-danger" onclick="cancelar('.$reg->id_cita.')"><i class="fa fa-close"></i></button>' 
                    : '<button class="btn btn-warning" onclick="mostrar('.$reg->id_cita.')"><i class="fa fa-pencil"></i></button>',
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
}
// Fin de las validaciones de acceso

?>
