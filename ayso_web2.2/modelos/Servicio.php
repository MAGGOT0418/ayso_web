<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";s
class Servicio {
    // Método para agregar un nuevo servicio
    public function agregarServicio($nombre_servicio, $descripcion, $precio) {
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion, precio) 
                VALUES ('$nombre_servicio', '$descripcion', '$precio')";
        return ejecutarConsulta($sql);
    }

    // Método para actualizar un servicio existente
    public function actualizarServicio($id_servicio, $nombre_servicio, $descripcion, $precio) {
        $sql = "UPDATE servicios SET nombre_servicio='$nombre_servicio', descripcion='$descripcion', precio='$precio' 
                WHERE id_servicio='$id_servicio'";
        return ejecutarConsulta($sql);
    }

    // Método para listar todos los servicios
    public function listarServicios() {
        $sql = "SELECT * FROM servicios";
        return ejecutarConsulta($sql);
    }
}
?>