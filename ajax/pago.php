<?php
require_once "../modelos/Pagos.php";



// Recuperamos los valores enviados por POST
$idHistorial = isset($_POST["idHistorial"]) ? limpiarCadena($_POST["idHistorial"]) : "";
$idPaciente = isset($_POST["idPaciente"]) ? limpiarCadena($_POST["idPaciente"]) : "";
$idCita = isset($_POST["idCita"]) ? limpiarCadena($_POST["idCita"]) : "";
$diagnostico = isset($_POST["diagnostico"]) ? limpiarCadena($_POST["diagnostico"]) : "";
$tratamiento = isset($_POST["tratamiento"]) ? limpiarCadena($_POST["tratamiento"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";

switch ($_GET["op"]) {
    case 'listarResumenFinanciero':
        // Llamamos al método correspondiente en el modelo `Citas` para obtener el resumen
        $rspta = $citas->listarResumenFinanciero();
        $data = array();
    
        // Procesamos cada registro obtenido de la base de datos
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->id_pago,
                "1" => $reg->nombre_paciente,
                "2" => $reg->fecha_cita,
                "3" => $reg->monto,
                "4" => $reg->metodo_pago,
                "5" => $reg->nombre_servicio,
                "6" => $reg->precio_servicio,
                "7" => $reg->fecha_pago
            );
        }
    
        // Construimos el array final para DataTables
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
    
        // Devolvemos los resultados en formato JSON
        echo json_encode($results);
        break;
}
?>
