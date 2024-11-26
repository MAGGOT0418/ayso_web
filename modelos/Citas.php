<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class Citas
{
    // Método para agendar una nueva cita
    public function agendarCita($id_paciente, $id_servicio, $fecha_cita, $comentarios)
    {
        $sql = "INSERT INTO citas (id_paciente, id_servicio, fecha_cita, estado, comentarios) 
                VALUES ('$id_paciente', '$id_servicio', '$fecha_cita', 'pendiente', '$comentarios')";
        return ejecutarConsulta($sql);
    }
    // Implementar un método para eliminar una cita
    public function eliminarCita1($id_cita)
    {
        $sql = "DELETE FROM citas WHERE id_cita='$id_cita'";
        return ejecutarConsulta($sql);
    }


    // Método para cancelar una cita
    public function cancelarCita($id_cita)
    {
        $sql = "UPDATE citas SET estado='cancelada' WHERE id_cita='$id_cita'";
        return ejecutarConsulta($sql);
    }

    // Método para actualizar el estado de una cita
    public function actualizarEstadoCita($id_cita, $estado)
    {
        $sql = "UPDATE citas SET estado='$estado' WHERE id_cita='$id_cita'";
        return ejecutarConsulta($sql);
    }
    // Método para listar todas las citas
    public function listar()
    {
        $sql = "SELECT * FROM citas";
        return ejecutarConsulta($sql);
    }
    // Método para listar citas por paciente
    public function listarCitasPorPaciente($id_usuario)
    {
        $sql = "SELECT * FROM citas WHERE id_usuario='$id_usuario'";
        return ejecutarConsulta($sql);
    }
    // Método para listar citas pendientes
    public function listarCitasPendientes()
    {
        $sql = "SELECT * FROM citas WHERE estado='pendiente'";
        return ejecutarConsulta($sql);
    }

    public function citasHoy()
    {
        $sql = "SELECT COUNT(*) as total FROM citas WHERE DATE(fecha_cita) = CURDATE()";
        $resultado = ejecutarConsultaSimpleFila($sql); // Usa tu función para consultas simples
        return $resultado['total'];
    }


    public function contarCitasPendientes()
    {
        global $conexion;

        $stmt = $conexion->prepare("SELECT COUNT(*) AS total FROM citas WHERE estado = 'pendiente' OR estado = 'confirmada'");

        if (!$stmt->execute()) {
            die("Error en la ejecución de la consulta: " . $stmt->error);
        }

        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        return $fila['total'];
    } 

    public function resumenCitas()
    {
        $sql = "SELECT
                    usuarios.nombre,
                    servicios.nombre_servicio,
                    citas.fecha_cita
                FROM
                    citas
                JOIN usuarios ON citas.id_paciente = usuarios.id_usuario
                JOIN servicios ON citas.id_servicio = servicios.id_servicio;";

        return ejecutarConsulta($sql);
    }
}
