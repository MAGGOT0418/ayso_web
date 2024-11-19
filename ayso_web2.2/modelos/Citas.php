<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Citas {
    // Método para agendar una nueva cita
    public function agendarCita($id_paciente, $id_servicio, $fecha_cita, $comentarios) {
        $sql = "INSERT INTO citas (id_paciente, id_servicio, fecha_cita, estado, comentarios) 
                VALUES ('$id_paciente', '$id_servicio', '$fecha_cita', 'pendiente', '$comentarios')";
        return ejecutarConsulta($sql);
    }
    // Implementar un método para eliminar una cita
    public function eliminarCita($id_cita) {
        $sql = "DELETE FROM citas WHERE id_cita='$id_cita'";
        return ejecutarConsulta($sql);
    }


    // Método para cancelar una cita
    public function cancelarCita($id_cita) {
        $sql = "UPDATE citas SET estado='cancelada' WHERE id_cita='$id_cita'";
        return ejecutarConsulta($sql);
    }

    // Método para actualizar el estado de una cita
    public function actualizarEstadoCita($id_cita, $estado) {
        $sql = "UPDATE citas SET estado='$estado' WHERE id_cita='$id_cita'";
        return ejecutarConsulta($sql);
    }
    // Método para listar todas las citas
    public function listar() {
    $sql = "SELECT *
            FROM citas"; 
    return ejecutarConsulta($sql);
}

    // Método para listar citas por paciente
    public function listarCitasPorPaciente($id_usuario) {
        $sql = "SELECT * FROM citas WHERE id_usuario='$id_usuario'";
        return ejecutarConsulta($sql);
    }
    // Método para listar citas pendientes
    public function listarCitasPendientes() {
        $sql = "SELECT * FROM citas WHERE estado='pendiente'";
        return ejecutarConsulta($sql);
    }
}
?>