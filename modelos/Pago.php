<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Pago {
    // Método para registrar un pago
    public function registrarPago($id_cita, $monto, $metodo_pago, $fecha_pago) {
        $sql = "INSERT INTO pagos (id_cita, monto, metodo_pago, fecha_pago) 
                VALUES ('$id_cita', '$monto', '$metodo_pago', '$fecha_pago')";
        return ejecutarConsulta($sql);
    }

    // Método para listar pagos por paciente
    public function listarPagosPorPaciente($id_paciente) {
        $sql = "SELECT * FROM pagos 
                INNER JOIN citas ON pagos.id_cita = citas.id_cita 
                WHERE citas.id_paciente='$id_paciente'";
        return ejecutarConsulta($sql);
    }

    // Método para listar todos los pagos
    public function listarPagos() {
        $sql = "SELECT * FROM pagos";
        return ejecutarConsulta($sql);
    }
}
?>