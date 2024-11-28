<?php
// eliminar_evento.php

// Conexión a la base de datos
$host = "localhost"; // Dirección de tu servidor
$dbname = "Vik_database"; // Nombre de tu base de datos
$username = "root"; // Usuario de tu base de datos
$password = ""; // Contraseña de tu base de datos

session_start(); // Iniciar sesión al inicio del archivo

// Verificar que el usuario tenga permisos de administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden eliminar eventos.";
    exit;
}

try {
    // Establecer la conexión con la base de datos
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el ID del evento fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_evento'])) {
        $id_evento = intval($_POST['id_evento']); // Obtener el ID del evento

        // Consulta para eliminar el evento de la base de datos
        $query = "DELETE FROM Eventos WHERE id_evento = :id_evento";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_evento', $id_evento, PDO::PARAM_INT);

        // Ejecutar la eliminación y verificar si fue exitosa
        if ($stmt->execute()) {
            echo "<script>alert('Evento eliminado con éxito.'); window.location.href = '../HTML/fechas.html';</script>";
        } else {
            echo "<script>alert('Error al eliminar el evento'); window.location.href = '../HTML/fechas.html';</script>";
        }
    } else {
        echo "<script>alert('ID del evento no válido'); window.location.href = '../HTML/fechas.html';</script>";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
