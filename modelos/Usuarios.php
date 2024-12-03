<?php
require "../config/conexion.php";

class Usuarios
{
    private $conexion;

    public function __construct()
    {
        global $conexion;
        $this->conexion = $conexion;
    }

    public function contarUsuarios()
    {
        $stmt = $this->conexion->prepare("SELECT COUNT(*) as total FROM usuarios");
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }

    public function listarUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function obtenerUsuario($id_usuario)
    {
        $sql = "SELECT u.*, hm.* 
                FROM usuarios u 
                LEFT JOIN historial_medico hm ON u.id_usuario = hm.id_usuario 
                WHERE u.id_usuario = ?";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado && $resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();

            $sql_condiciones = "SELECT condicion FROM condiciones_medicas WHERE id_usuario = ?";
            $stmt_condiciones = $this->conexion->prepare($sql_condiciones);
            $stmt_condiciones->bind_param("i", $id_usuario);
            $stmt_condiciones->execute();
            $result_condiciones = $stmt_condiciones->get_result();

            $condiciones = [];
            if ($result_condiciones && $result_condiciones->num_rows > 0) {
                while ($row = $result_condiciones->fetch_assoc()) {
                    $condiciones[] = $row['condicion'];
                }
            }

            $datos['historial_medico']['condiciones'] = $condiciones;

            return $datos;
        }

        return null;
    }
}