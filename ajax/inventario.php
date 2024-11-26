<?php
require_once "../modelos/Inventario.php";
$inventario = new Inventario();

$id_producto = isset($_POST["id_producto"]) ? limpiarCadena($_POST["id_producto"]) : "";
$nombre_producto = isset($_POST["nombre_producto"]) ? limpiarCadena($_POST["nombre_producto"]) : "";
$stock = isset($_POST["stock"]) ? limpiarCadena($_POST["stock"]) : "";
$precio = isset($_POST["precio"]) ? limpiarCadena($_POST["precio"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $inventario->listarinventario();
        $data = array();
        if ($rspta->num_rows > 0) {
            while ($row = $rspta->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['nombre_producto'] . "</td>
                        <td>" . $row['stock'] . "</td>
                        <td>
                            <button onclick=\"mostrarActualizarStock({$row['id_producto']})\">Actualizar Stock</button>
                            <button onclick=\"eliminarProducto({$row['id_producto']})\">Eliminar</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No hay productos</td></tr>";
        }
        break;
    case 'precio':
        $rspta = $inventario->cambiarprecio($id_producto, $precio);
        break;
    case 'eliminar':
        $rspta = $inventario->eliminarproducto($id_producto);
        echo json_encode(['status' => $rspta ? 'success' : 'error', 'message' => $rspta ? 'Producto eliminado correctamente.' : 'Error al eliminar el producto.']);
        break;
    case 'actualizarstock':
        $cantidad = isset($_POST['cantidad']) ? limpiarCadena($_POST['cantidad']) : 0;
        if ($cantidad > 0) {
            $rspta = $inventario->actualizarStock($id_producto, $cantidad);
            echo json_encode(['status' => $rspta ? 'success' : 'error', 'message' => $rspta ? 'Stock actualizado correctamente.' : 'Error al actualizar el stock.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cantidad no válida.']);
        }
        break;
    case 'insertarProducto':
        $rspta = $inventario->insertarProductos($nombre_producto, $stock, $precio);
        echo json_encode(['status' => $rspta ? 'success' : 'error', 'message' => $rspta ? 'Producto agregado correctamente.' : 'Error al agregar el producto.']);
        break;
}
?>
