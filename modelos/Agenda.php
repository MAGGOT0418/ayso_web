<?php

require "../config/conexion.php";

class Agenda
{
    public function citasHoy()
    {
        $sql = "SELECT COUNT(*) AS total FROM agenda WHERE DATE(STR_TO_DATE(inicio_normal, '%d/%m/%Y %H:%i:%s')) = CURDATE()";

        $resultado = ejecutarConsultaSimpleFila($sql); 

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
