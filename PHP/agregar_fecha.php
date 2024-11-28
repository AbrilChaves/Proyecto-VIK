<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para agregar una fecha.";
    exit;
}

// Verifica si el usuario es administrador
if ($_SESSION['rol'] !== 'admin') {
    echo "Solo los administradores pueden agregar fechas.";
    exit;
}

// Conexión a la base de datos
$host = "localhost";
$dbname = "Vik_database";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}

// Verificar si los datos fueron enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['lugar']) && isset($_POST['fecha']) && isset($_POST['hora'])) {
    $lugar = $_POST['lugar'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    try {
        // Insertar la fecha en la base de datos
        $query = "INSERT INTO Eventos (lugar, fecha, hora) 
                  VALUES (:lugar, :fecha, :hora)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':lugar', $lugar);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':hora', $hora);
        $stmt->execute();

        echo "<script>alert('Fecha agregada con éxito.'); window.location.href = '../HTML/fechas.html';</script>";
    } catch (PDOException $e) {
        echo "Error al guardar la fecha: " . $e->getMessage();
    }
} else {
    echo "Faltan datos para agregar la fecha.";
}
?>
