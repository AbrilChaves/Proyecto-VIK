<?php
session_start();
// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    // Alerta para usuarios no logueados
    echo "Debes iniciar sesión para comentar";
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
    echo "<script>alert('Error de conexión: " . addslashes($e->getMessage()) . "'); window.location.href = '../HTML/comunidad.html';</script>";
    exit;
}

// Verifica si el comentario y el ID del post fueron enviados correctamente
if (isset($_POST['comentario']) && isset($_POST['post_id'])) {
    $comentario = $_POST['comentario'];
    $id_post = $_POST['post_id'];
    $id_usuario = $_SESSION['usuario_id'];
    $fecha_comentario = date('Y-m-d H:i:s');

    try {
        $query = "INSERT INTO Comentarios (id_post, id_usuario, contenido, fecha_comentario) 
                  VALUES (:id_post, :id_usuario, :contenido, :fecha_comentario)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_post', $id_post);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':contenido', $comentario);
        $stmt->bindParam(':fecha_comentario', $fecha_comentario);
        $stmt->execute();

        // Alerta de éxito
        echo "<script>alert('Comentario enviado con éxito.'); window.location.href = '../HTML/comunidad.html';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Error al guardar el comentario: " . addslashes($e->getMessage()) . "'); window.location.href = '../HTML/comunidad.html';</script>";
    }
} else {
    echo "<script>alert('Debe completar el comentario y el ID del post.'); window.location.href = '../HTML/comunidad.html';</script>";
}
?>
