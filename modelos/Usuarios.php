<?php
require "../config/conexion.php";

class Usuarios {
    public function contarUsuarios() {
        global $conexion; 

        $stmt = $conexion->prepare("SELECT COUNT(*) as total FROM usuarios");
        
        $stmt->execute();
        
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        
        return $fila['total'];
    }
    
}

?>