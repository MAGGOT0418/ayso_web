<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $phone = $_POST['Phone_Number'];
    $email = $_POST['Email'];
    $message = $_POST['Message'];

    $to = "jairo117black@gmail.com";
    $subject = "Nuevo mensaje de contacto";
    $body = "Nombre: $name\nTeléfono: $phone\nCorreo: $email\nMensaje: $message";
    $headers = "From: no-reply@tudominio.com" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $body, $headers)) {
        echo "Mensaje enviado correctamente";
    } else {
        echo "Hubo un error al enviar el mensaje.";
    }
}
?>
