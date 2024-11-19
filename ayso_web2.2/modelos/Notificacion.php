<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
class Notificacion {
    // Método para enviar una notificación a un usuario
    public function enviarNotificacion($id_usuario, $mensaje) {
        $sql = "INSERT INTO notificaciones (id_usuario, mensaje, fecha) 
                VALUES ('$id_usuario', '$mensaje', NOW())";
        return ejecutarConsulta($sql);
    }

    // Método para listar todas las notificaciones de un usuario
    public function listarNotificaciones($id_usuario) {
        $sql = "SELECT * FROM notificaciones WHERE id_usuario='$id_usuario'";
        return ejecutarConsulta($sql);
    }
}
?>