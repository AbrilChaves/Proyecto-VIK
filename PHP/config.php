<?php
// Configuración de la base de datos
$host = 'localhost'; // o el host de tu base de datos (por ejemplo, "127.0.0.1" o una dirección IP)
$dbname = 'Vik_database'; // el nombre de tu base de datos
$username = 'root'; // el usuario de la base de datos
$password = ''; // la contraseña de la base de datos

try {
    // Crear la conexión usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurar el manejo de errores de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error en la conexión, mostrar un mensaje
    die("Error de conexión: " . $e->getMessage());
}
?>