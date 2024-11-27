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
        echo "Las contraseñas no coinciden.";
    } else {
        // Verificar si el correo ya está registrado
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        
        if ($stmt->rowCount() > 0) {
            echo "El correo ya está registrado.";
        } else {
            // Hashear la contraseña
            $contraseña_hashed = password_hash($contraseña, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $stmt = $pdo->prepare("INSERT INTO Usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)");
            if ($stmt->execute([$nombre, $correo, $contraseña_hashed])) {
                echo "Registro exitoso. Ahora puedes iniciar sesión.";
                // Puedes redirigir al usuario a la página de inicio de sesión
                // header("Location: login.php");
                // exit;
            } else {
                echo "Hubo un error al registrar el usuario.";
            }
        }
    }
}
?>
