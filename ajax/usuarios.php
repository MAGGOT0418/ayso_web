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
                        <td>" . htmlspecialchars($row['nombre']) . "</td>
                        <td>" . htmlspecialchars($row['correo']) . "</td>
                        <td>" . htmlspecialchars($row['fecha_nacimiento']) . "</td>
                        <td>" . htmlspecialchars($row['direccion']) . "</td>
                        <td>
                            <button class='btn btn-info btn-sm' onclick=\"mostrarFormularioRegistro({$row['id_usuario']})\">Historial</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron usuarios</td></tr>";
        }
        break;
}
?>
