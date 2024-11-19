<?php
// Incluimos el modelo Pago
require_once "../modelos/Pago.php"; // Verifica la ruta

// Creamos una instancia de la clase Pago
$pago = new Pago();

// Detectamos la acción que viene de AJAX
if (isset($_GET["action"])) {
    $action = $_GET["action"];

    switch ($action) {
        case 'listar':
            // Llamamos al método para listar todos los pagos
            $resultado = $pago->listarPagos();
            $pagos = [];

            // Convertimos el resultado en un array asociativo para JSON
            while ($fila = $resultado->fetch_assoc()) {
                $pagos[] = $fila;
            }

            // Retornamos la respuesta en formato JSON
            echo json_encode($pagos);
            break;

        case 'registrar':
            // Recibimos los datos por POST y registramos el pago
            $id_cita = $_POST["id_cita"];
            $monto = $_POST["monto"];
            $metodo_pago = $_POST["metodo_pago"];
            $fecha_pago = $_POST["fecha_pago"];

            $resultado = $pago->registrarPago($id_cita, $monto, $metodo_pago, $fecha_pago);

            // Enviamos una respuesta de éxito o error
            echo json_encode(["success" => $resultado]);
            break;

        // Puedes agregar más casos si necesitas otras acciones (actualizar, eliminar, etc.)
    }
}
?>
