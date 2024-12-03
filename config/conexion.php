<?php 
require_once "global.php";

$servidor = DB_HOST;
$usuario = DB_USERNAME;
$pass = DB_PASSWORD;
$bd = DB_NAME;

$conexion = new mysqli($servidor, $usuario, $pass, $bd);

$conexion->set_charset(DB_ENCODE);

if ($conexion->connect_errno) {
    printf("Falló conexión a la base de datos: %s\n", $conexion->connect_error);
    exit();
}

$base_url = "http://localhost/AYSO_WEB/vistas/";

if (!function_exists('ejecutarConsulta')) {
    function ejecutarConsulta($sql) {
        global $conexion;
        $query = $conexion->query($sql);
        if (!$query) {
            die("Error en la consulta SQL: " . $conexion->error);
        }
        return $query;
    }
    

    function ejecutarConsultaSimpleFila($sql) {
        global $conexion;
        $query = $conexion->query($sql);
        if (!$query) {
            die("Error en la consulta SQL: " . $conexion->error);
        }
        $row = $query->fetch_assoc();
        return $row ? $row : null; 
    }
    

    function ejecutarConsulta_retornarID($sql) {
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;			
    }

    function limpiarCadena($str) {
        global $conexion;
        return mysqli_real_escape_string($conexion, trim($str));
    }
    
}
?>
