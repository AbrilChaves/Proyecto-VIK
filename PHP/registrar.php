<?php
include('config.php'); // Incluir la conexión a la base de datos
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanitizar los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = htmlspecialchars(trim($_POST['correo']));
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Verificar que las contraseñas coincidan
    if ($contraseña !== $confirmar_contraseña) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.location.href = '../HTML/registrarse.html';</script>";
    } else {
        // Verificar si el correo ya está registrado
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('El correo ya está registrado.'); window.location.href = '../HTML/registrarse.html';</script>";
        } else {
            // Hashear la contraseña
            $contraseña_hashed = password_hash($contraseña, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $stmt = $pdo->prepare("INSERT INTO Usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)");
            if ($stmt->execute([$nombre, $correo, $contraseña_hashed])) {
                echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.'); window.location.href = '../HTML/login.html';</script>";

            } else {
                echo "<script>alert('Hubo un error al registrar el usuario.'); window.location.href = '../HTML/registrarse.html';</script>";
            }
        }
    }
    /*
    $sql = "SELECT correo FROM usuarios";
    $result = $conn->query($sql);

        // Verificar si hay correos en la base de datos
    if ($result->num_rows > 0) {
    // Datos del formulario
    $nombre = $_POST['nombre'];
    $asunto = $_POST['Registro en VIK'];
    $mensaje = $_POST['mensaje'];

    // Preparar el mensaje completo
    $mensajeCompleto = $mensaje . "\nAtentamente: " . $nombre;

    // Enviar el correo a cada destinatario
    while ($row = $result->fetch_assoc()) {
        $destinatario = $row['email'];
        $header = "From: VIK";
        if (mail($destinatario, $asunto, $mensajeCompleto, $header)) {
            echo "Correo enviado a: $destinatario<br>";
        } else {
            echo "Error al enviar el correo a: $destinatario<br>";
        }
    }
    } else {
        echo "No hay correos en la base de datos.";
    }

    $conn->close();

    echo "<script> alert('Proceso de envío completado') </script>";
    echo "<script> setTimeout(() => { location.href='index.html'; }, 1000); </script>";
*/
}
?>
