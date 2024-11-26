<?php
require_once "../modelos/Usuarios.php";

$usuarios = new Usuarios();

$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena($_POST["correo"]) : "";
$fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? limpiarCadena($_POST["fecha_nacimiento"]) : "";
$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$id_rol = isset($_POST["id_rol"]) ? limpiarCadena($_POST["id_rol"]) : "";

switch ($_GET["op"]) {
    case 'listar':
       $rspta = $usuarios->contarUsuarios();

       echo json_encode(['total_usuarios' => $rspta]);

       break;
}
?>