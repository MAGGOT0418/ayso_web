<?php 
require "../config/Conexion.php";
class HistorialMedico {
    public function agregarHistorialMedico($id_paciente, $id_cita, $diagnostico, $tratamiento, $fecha) {
        $sql = "INSERT INTO historial_medico (id_paciente, id_cita, diagnostico, tratamiento, fecha) 
                VALUES ('$id_paciente', '$id_cita', '$diagnostico', '$tratamiento', '$fecha')";
        return ejecutarConsulta($sql);
    }

    public function mostrarHistorialPorPaciente($id_paciente) {
        $sql = "SELECT * FROM historial_medico WHERE id_paciente='$id_paciente'";
        return ejecutarConsulta($sql);
    }

    public function listarHistorialMedico() {
        $sql = "SELECT * FROM historial_medico;";
        return ejecutarConsulta($sql);
    }
    
}
?>