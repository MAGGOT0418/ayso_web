<?php
require "../config/Conexion.php";

class Servicio {
    public function agregarServicio($nombre_servicio, $descripcion, $precio) {
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion, precio) VALUES ('$nombre_servicio', '$descripcion', '$precio')";
        return ejecutarConsulta($sql);
    }

    public function actualizarServicio($id_servicio, $nombre_servicio, $descripcion, $precio) {
        $sql = "UPDATE servicios SET nombre_servicio='$nombre_servicio', descripcion='$descripcion', precio='$precio' WHERE id_servicio='$id_servicio'";
        return ejecutarConsulta($sql);
    }

    public function listarServicios() {
        $sql = "SELECT * FROM servicios";
        return ejecutarConsulta($sql);
    }

    public function eliminarServicio($id_servicio) {
        $sql = "DELETE FROM servicios WHERE id_servicio = $id_servicio";
        return ejecutarConsulta($sql);
    }

    public function obtenerServicio($id_servicio) {
        $sql = "SELECT * FROM servicios WHERE id_servicio = '$id_servicio'";
        return ejecutarConsultaSimpleFila($sql);
    }
}
?>
