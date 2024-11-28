<?php

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el correo ingresado en el formulario
    $email = $_POST['mail'];
    
    // Dirección de la banda (destinatario del correo)
    $destinatario = 'chaves.abril.et21.22@gmail.com';
    
    // Asunto del correo
    $asunto = "Confirmación de suscripción al newsletter de VIK";
    
    // Mensaje del correo
    $mensaje = "¡Gracias por suscribirte al newsletter de VIK!\n\n";
    $mensaje .= "Este es un mensaje de confirmación. Estás oficialmente suscrito para recibir nuestras novedades.\n\n";
    $mensaje .= "Nos encanta tenerte en nuestra comunidad.\n\n";
    $mensaje .= "¡Saludos, VIK!";
    
    // Cabeceras para el correo
    $header = "From: no-reply@vikband.com\r\n";
    $header .= "Reply-To: no-reply@vikband.com\r\n";
    $header .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Enviar el correo de confirmación a la banda
    mail($destinatario, $asunto, $mensaje, $header);

    // Enviar el correo de confirmación al usuario
    $asuntoUsuario = "Confirmación de suscripción al newsletter de VIK";
    $mensajeUsuario = "¡Gracias por suscribirte a nuestro newsletter!\n\n";
    $mensajeUsuario .= "Estás oficialmente suscrito para recibir nuestras novedades.\n\n";
    $mensajeUsuario .= "Nos encanta tenerte en nuestra comunidad.\n\n";
    $mensajeUsuario .= "¡Saludos, VIK!";
    
    // Enviar el correo de confirmación al suscriptor
    mail($email, $asuntoUsuario, $mensajeUsuario, $header);
    
    // Mostrar un mensaje de éxito en la página
    echo "<script>alert('Gracias por suscribirte al newsletter. Revisa tu correo para confirmar la suscripción.');</script>";
    echo "<script> setTimeout(\"location.href='vik.html'\", 1000);</script>";
}
?>