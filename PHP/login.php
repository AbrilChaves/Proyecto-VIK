<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Conectar a la base de datos
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=Vik_database", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar y ejecutar la consulta
        $stmt = $pdo->prepare("SELECT id_usuario, nombre, correo, rol, contraseña FROM Usuarios WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y la contraseña es correcta
        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            // Iniciar sesión si las credenciales son correctas
            $_SESSION['usuario_id'] = $usuario['id_usuario']; // Guardar el ID del usuario en la sesión
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['correo'] = $usuario['correo']; // Guardar el correo en la sesión
            $_SESSION['rol'] = $usuario['rol']; // Guardar el rol del usuario en la sesión

            // Redirigir a la página de comunidad
            header("Location: ../HTML/login.html");
            exit;
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}

?>