<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pagos</title>
</head>
<body>

    <h1>Lista de Pagos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Cita</th>
                <th>Monto</th>
                <th>Método de Pago</th>
                <th>Fecha de Pago</th>
            </tr>
        </thead>
        <tbody id="tablaPagos">
            <!-- Los datos de los pagos se insertarán aquí -->
        </tbody>
    </table>

    <script>
        // Función para listar pagos
        function listarPagos() {
            // Enviar una solicitud GET a `pago_controlador.php` para listar los pagos
            fetch('ajax/pago_controlador.php?action=listar')
            .then(response => response.json())
            .then(data => {
                // Limpiar la tabla antes de llenarla
                const tablaPagos = document.getElementById("tablaPagos");
                tablaPagos.innerHTML = "";

                // Recorrer los datos recibidos y construir las filas de la tabla
                data.forEach(pago => {
                    const fila = `
                        <tr>
                            <td>${pago.id_cita}</td>
                            <td>${pago.monto}</td>
                            <td>${pago.metodo_pago}</td>
                            <td>${pago.fecha_pago}</td>
                        </tr>`;
                    tablaPagos.innerHTML += fila;
                });
            })
            .catch(error => console.error("Error al listar los pagos:", error));
        }

        // Llamar a listarPagos cuando se cargue la página
        document.addEventListener("DOMContentLoaded", listarPagos);
    </script>

</body>
</html>
