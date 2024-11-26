<?php

require_once "../modelos/HistorialMedico.php";

$historialMedico = new HistorialMedico();

// Recuperamos los valores enviados por POST
$idHistorial = isset($_POST["idHistorial"]) ? limpiarCadena($_POST["idHistorial"]) : "";
$idPaciente = isset($_POST["idPaciente"]) ? limpiarCadena($_POST["idPaciente"]) : "";
$idCita = isset($_POST["idCita"]) ? limpiarCadena($_POST["idCita"]) : "";
$diagnostico = isset($_POST["diagnostico"]) ? limpiarCadena($_POST["diagnostico"]) : "";
$tratamiento = isset($_POST["tratamiento"]) ? limpiarCadena($_POST["tratamiento"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";

switch ($_GET["op"]) {
    case 'listarHistorialMedico':
        $rspta = $historialMedico->listarHistorialMedico();
        $data = array();
    
        // Generamos el array de datos
        while ($row = $rspta->fetch_assoc()) {  
            $data[] = array(
                "diagnostico" => $row['diagnostico'],
                "tratamiento" => $row['tratamiento'],
                "fecha" => $row['fecha'],
                
            );
        }
    
        // Devolvemos el array como JSON
        echo json_encode($data);
        break;

    case 'guardaryeditar':
        // Validamos el acceso solo a usuarios logueados en el sistema
        if (!isset($_SESSION["nombre"])) {
            header("Location: ../vistas/login.html");
            exit();
        } else {
            // Validación de archivo de imagen
            if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
                $imagen = $_POST["imagenactual"];
            } else {
                $ext = explode(".", $_FILES["imagen"]["name"]);
                if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                    $imagen = round(microtime(true)) . '.' . end($ext);
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
                }
            }

            // Si no se desea encriptar la contraseña
            $clave = $_POST["clave"];

            // Guardar o editar usuario según si el id está vacío o no
            if (empty($idusuario)) {
                $rspta = $usuario->insertar(
                    $nombre,
                    $tipo_documento,
                    $num_documento,
                    $direccion,
                    $telefono,
                    $email,
                    $cargo,
                    $login,
                    $clave, // Aquí se inserta la clave sin encriptar
                    $imagen,
                    $_POST['permiso']
                );
                echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
            } else {
                $rspta = $usuario->editar(
                    $idusuario,
                    $nombre,
                    $tipo_documento,
                    $num_documento,
                    $direccion,
                    $telefono,
                    $email,
                    $cargo,
                    $login,
                    $clave, // Aquí se actualiza la clave sin encriptar
                    $imagen,
                    $_POST['permiso']
                );
                echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
            }
        }
        break;
}
