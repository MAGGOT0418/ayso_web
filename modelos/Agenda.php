<?php

require "../config/conexion.php";

class Agenda
{
    public function citasHoy()
    {
        // Consulta para contar las citas del día actual
        $sql = "SELECT COUNT(*) AS total FROM agenda WHERE DATE(STR_TO_DATE(inicio_normal, '%d/%m/%Y %H:%i:%s')) = CURDATE()";

        // Ejecuta la consulta y obtiene el resultado
        $resultado = ejecutarConsultaSimpleFila($sql); // Usando la función para consultas simples

        // Retorna el total de citas
        return $resultado['total'];
    }
    public function listarProximas()
    {
        $sql = "SELECT 
                    title, 
                    class, 
                    inicio_normal 
                FROM 
                    agenda 
                WHERE 
                DATE(STR_TO_DATE(inicio_normal, '%d/%m/%Y %H:%i:%s')) = CURDATE()";

        return ejecutarConsulta($sql);
    }

    
}
