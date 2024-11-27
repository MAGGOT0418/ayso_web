<?php
require_once "../modelos/Usuarios.php";

$usuarios = new Usuarios();

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $usuarios->contarUsuarios();
        echo json_encode(['total_usuarios' => $rspta]);
        break;

    case 'listarUsuarios':
        $rspta = $usuarios->listarUsuarios();
        if ($rspta->num_rows > 0) {
            while ($row = $rspta->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['nombre'] . "</td>
                        <td>" . $row['correo'] . "</td>
                        <td>" . $row['fecha_nacimiento'] . "</td>
                        <td>" . $row['direccion'] . "</td>
                        <td>
                            <button class='btn btn-info btn-sm' onclick=\"mostrarActualizarStock({$row['id_usuario']})\">Historial</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron usuarios</td></tr>";
        }
        break;
}
?>
