<?php
require_once "../modelos/Agenda.php"; 

$agenda = new Agenda(); 

$id = isset($_POST["id"]) ? limpiarCadena($_POST["id"]) : "";
$title = isset($_POST["title"]) ? limpiarCadena($_POST["title"]) : "";
$body = isset($_POST["body"]) ? limpiarCadena($_POST["body"]) : "";
$url = isset($_POST["url"]) ? limpiarCadena($_POST["url"]) : "";
$class = isset($_POST["class"]) ? limpiarCadena($_POST["class"]) : "";
$start = isset($_POST["start"]) ? limpiarCadena($_POST["start"]) : "";
$end = isset($_POST["end"]) ? limpiarCadena($_POST["end"]) : "";
$inicio_normal = isset($_POST["inicio_normal"]) ? limpiarCadena($_POST["inicio_normal"]) : "";
$final_normal = isset($_POST["final_normal"]) ? limpiarCadena($_POST["final_normal"]) : "";


switch ($_GET["op"]) {
    case 'contarHoy':
        $rspta = $agenda->citasHoy();

        echo json_encode(['total_citas' => $rspta]);

        break;

    case 'listarProximas':

        $rspta = $agenda->listarProximas();
        $data = array();

        if ($rspta) {
            while ($row = $rspta->fetch_assoc()) {
                $data[] = [
                    'title' => $row['title'],
                    'class' => $row['class'],
                    'inicio_normal' => $row['inicio_normal']
                ];
            }
        }

        echo json_encode($data);
        break;
    
}
