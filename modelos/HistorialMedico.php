<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class HistorialMedico {
    // Método para agregar un registro al historial médico
    public function agregarHistorialMedico($id_paciente, $id_cita, $diagnostico, $tratamiento, $fecha) {
        $sql = "INSERT INTO historial_medico (id_paciente, id_cita, diagnostico, tratamiento, fecha) 
                VALUES ('$id_paciente', '$id_cita', '$diagnostico', '$tratamiento', '$fecha')";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar el historial médico de un paciente
    public function mostrarHistorialPorPaciente($id_paciente) {
        $sql = "SELECT * FROM historial_medico WHERE id_paciente='$id_paciente'";
        return ejecutarConsulta($sql);
    }

    // Método para listar todos los registros del historial médico
    public function listarHistorialMedico() {
        $sql = "SELECT * FROM historial_medico";
        return ejecutarConsulta($sql);
    }
}
?>