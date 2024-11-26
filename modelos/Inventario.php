<?php
require "../config/conexion.php";

class Inventario {
    public function listarinventario() {
        $sql = "SELECT * FROM productos";
        return ejecutarConsulta($sql);
    }

    public function cambiarprecio($id_producto, $precio) {
        $sql = "UPDATE productos SET precio = $precio WHERE id_producto = $id_producto";
        return ejecutarConsulta($sql);
    }

    public function eliminarproducto($id_producto) {
        $sql = "DELETE FROM productos WHERE id_producto = $id_producto";
        return ejecutarConsulta($sql);
    }

    public function actualizarStock($id_producto, $cantidad) {
        $sql = "UPDATE productos SET stock = stock + $cantidad WHERE id_producto = $id_producto";
        return ejecutarConsulta($sql);
    }

    public function insertarProductos($nombre_producto, $stock, $precio) {
        $sql = "INSERT INTO productos (nombre_producto, stock, precio) VALUES ('$nombre_producto', $stock, $precio)";
        return ejecutarConsulta($sql);
    }
}
?>
